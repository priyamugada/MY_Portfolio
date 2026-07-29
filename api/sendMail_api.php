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

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_username;
    $mail->Password   = $smtp_password;
    $mail->SMTPSecure = $smtp_secure === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int) $smtp_port;

    // Sender / recipient
    // Most SMTP providers (Gmail included) reject or spoof-flag a From
    // address that isn't the authenticated mailbox, so the authenticated
    // SMTP account is always the From address. The visitor's email is set
    // as Reply-To so the owner can just hit "reply" in their mail client.
    $mail->setFrom($smtp_username, $owner_name);
    $mail->addAddress($owner_email, $owner_name);
    $mail->addReplyTo($visitor_email, $visitor_email);

    // Content
    $mail->isHTML(false);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "New message from Portfolio";
    $mail->Body    = "Message from: $visitor_email\n\n$message";

    $mail->send();

    echo json_encode(["success" => true, "message" => "message sent successfully"]);
} catch (PHPMailerException $e) {
    // $mail->ErrorInfo has the underlying SMTP error (auth failure, wrong
    // host/port, etc.) which is far more useful for debugging than a
    // generic "something went wrong".
    echo json_encode(["success" => false, "message" => "Mail could not be sent. Error: " . $mail->ErrorInfo]);
    exit();
} catch (Throwable $e) {
    echo json_encode(["success" => false, "message" => "Something went wrong: " . $e->getMessage()]);
    exit();
}
