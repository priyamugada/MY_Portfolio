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

if (empty($smtp_username) || empty($smtp_password)) {
    // Fail loudly and clearly instead of pretending to send. This is the
    // single most common reason contact forms "don't work": SMTP_USER /
    // SMTP_PASS were never set, so there is nothing to authenticate with.
    echo json_encode([
        "success" => false,
        "message" => "Mail is not configured on the server yet (missing SMTP_USER/SMTP_PASS). See README for setup."
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

// First try with configured port & secure settings
try {
    send_with_phpmailer($smtp_host, $smtp_port, $smtp_secure, $smtp_username, $smtp_password, $owner_name, $owner_email, $owner_name, $visitor_email, $message);
    echo json_encode(["success" => true, "message" => "message sent successfully"]);
    exit();
} catch (Throwable $e1) {
    $err1 = $e1->getMessage();
    
    // Fallback attempt: If primary attempted port 465, try 587 (or vice versa)
    $fallback_port   = ((int)$smtp_port === 465) ? 587 : 465;
    $fallback_secure = ($fallback_port === 465) ? 'ssl' : 'tls';
    
    try {
        send_with_phpmailer($smtp_host, $fallback_port, $fallback_secure, $smtp_username, $smtp_password, $owner_name, $owner_email, $owner_name, $visitor_email, $message);
        echo json_encode(["success" => true, "message" => "message sent successfully"]);
        exit();
    } catch (Throwable $e2) {
        $err2 = $e2->getMessage();
        echo json_encode([
            "success" => false,
            "message" => "Mail error (Port {$smtp_port}/{$smtp_secure}): " . $err1 . " | Fallback (Port {$fallback_port}/{$fallback_secure}): " . $err2 . " [User: " . substr($smtp_username, 0, 4) . "***]"
        ]);
        exit();
    }
}
