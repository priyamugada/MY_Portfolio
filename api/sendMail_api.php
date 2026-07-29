<?php
// Never let PHP notices/warnings leak into the response body — the
// front end does JSON.parse() on whatever we output, and a single stray
// "Warning: ..." line before the JSON breaks that parse silently.
ini_set('display_errors', '0');
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once __DIR__ . '/../config/mail_config.php';
require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// The message always goes to the site owner. The visitor's address (the
// "recipient" field in the form — poorly named, but kept as-is so the HTML
// form doesn't need to change) is only ever used as the Reply-To, never as
// the destination, so a visitor can't redirect mail to themselves or anyone
// else.
$visitor_email = trim($_POST['recipient'] ?? '');
$message       = trim($_POST['message'] ?? '');

if (empty($visitor_email) || empty($message)) {
    echo json_encode(["success" => false, "message" => "Recipient and message required"]);
    exit();
}

if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Please enter a valid email address"]);
    exit();
}
// Defense in depth against header injection, even though PHPMailer already
// escapes/validates addresses internally.
$visitor_email = str_replace(["\r", "\n"], '', $visitor_email);

function fetch_env($key) {
    $val = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key) ?: '';
    return trim((string)$val);
}

// 1. Check for HTTPS-based API keys first (bypasses Render's outbound SMTP port blocking)
$resend_key    = fetch_env('RESEND_API_KEY');
$brevo_key     = fetch_env('BREVO_API_KEY');
$web3forms_key = fetch_env('WEB3FORMS_KEY');

if (!empty($resend_key)) {
    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $resend_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'from'     => 'Portfolio Contact <onboarding@resend.dev>',
        'to'       => [$owner_email],
        'reply_to' => $visitor_email,
        'subject'  => 'New message from Portfolio',
        'text'     => "Message from: $visitor_email\n\n$message"
    ]));
    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode($res, true);
    if ($code >= 200 && $code < 300) {
        echo json_encode(["success" => true, "message" => "message sent successfully"]);
        exit();
    } else {
        $msg = $json['message'] ?? "HTTP $code";
        echo json_encode(["success" => false, "message" => "Resend Error: " . $msg]);
        exit();
    }
}

if (!empty($brevo_key)) {
    $ch = curl_init('https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'api-key: ' . $brevo_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'sender'      => ['name' => $owner_name, 'email' => !empty($smtp_username) ? $smtp_username : $owner_email],
        'to'          => [['email' => $owner_email, 'name' => $owner_name]],
        'replyTo'     => ['email' => $visitor_email],
        'subject'     => 'New message from Portfolio',
        'textContent' => "Message from: $visitor_email\n\n$message"
    ]));
    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode($res, true);
    if ($code >= 200 && $code < 300) {
        echo json_encode(["success" => true, "message" => "message sent successfully"]);
        exit();
    } else {
        $msg = $json['message'] ?? "HTTP $code";
        echo json_encode(["success" => false, "message" => "Brevo Error: " . $msg]);
        exit();
    }
}

if (!empty($web3forms_key)) {
    $ch = curl_init('https://api.web3forms.com/submit');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'access_key' => $web3forms_key,
        'name'       => $visitor_email,
        'email'      => $visitor_email,
        'message'    => $message,
        'subject'    => 'New message from Portfolio'
    ]));
    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode($res, true);
    if (($code >= 200 && $code < 300) && (!isset($json['success']) || $json['success'] === true)) {
        echo json_encode(["success" => true, "message" => "message sent successfully"]);
        exit();
    } else {
        $msg = $json['message'] ?? "HTTP $code";
        echo json_encode(["success" => false, "message" => "Web3Forms Error: " . $msg]);
        exit();
    }
}

if (empty($smtp_username) || empty($smtp_password)) {
    echo json_encode([
        "success" => false,
        "message" => "Mail is not configured on the server yet."
    ]);
    exit();
}

function send_with_phpmailer($host, $port, $secure, $user, $pass, $from_name, $to_email, $to_name, $reply_to, $body_text) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $user;
    $mail->Password   = $pass;
    $mail->Timeout    = 10;
    
    $sec = strtolower(trim($secure));
    if ($sec === 'ssl' || $sec === 'smtps' || (int) $port === 465) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }
    $mail->Port       = (int) $port;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ]
    ];

    $mail->setFrom($user, $from_name);
    $mail->addAddress($to_email, $to_name);
    $mail->addReplyTo($reply_to, $reply_to);

    $mail->isHTML(false);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "New message from Portfolio";
    $mail->Body    = "Message from: $reply_to\n\n$body_text";

    $mail->send();
}

// Try with configured port & secure settings
try {
    send_with_phpmailer($smtp_host, $smtp_port, $smtp_secure, $smtp_username, $smtp_password, $owner_name, $owner_email, $owner_name, $visitor_email, $message);
    echo json_encode(["success" => true, "message" => "message sent successfully"]);
    exit();
} catch (Throwable $e1) {
    $err1 = $e1->getMessage();
    
    $fallback_port   = ((int)$smtp_port === 465) ? 587 : 465;
    $fallback_secure = ($fallback_port === 465) ? 'ssl' : 'tls';
    
    try {
        send_with_phpmailer($smtp_host, $fallback_port, $fallback_secure, $smtp_username, $smtp_password, $owner_name, $owner_email, $owner_name, $visitor_email, $message);
        echo json_encode(["success" => true, "message" => "message sent successfully"]);
        exit();
    } catch (Throwable $e2) {
        echo json_encode([
            "success" => false,
            "message" => "Render Free Tier blocks raw SMTP ports 465/587. Please add WEB3FORMS_KEY or RESEND_API_KEY in Render Environment Variables for HTTPS email sending."
        ]);
        exit();
    }
}
