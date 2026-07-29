<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db_config.php';

if (!$conn) {
  echo json_encode(["success" => false, "message" => "DB connection failed"]);
  exit();
}

$title = trim($_POST['title'] ?? '');
$organization = trim($_POST['organization'] ?? '');
$issue_date = trim($_POST['issue_date'] ?? '');
$certificate_link = trim($_POST['certificate_link'] ?? '') ?: null;

if ($title === '' || $organization === '' || $issue_date === '') {
  echo json_encode(["success" => false, "message" => "Title, organization and issue date are required"]);
  exit();
}

// Folder outside api/
$target_dir = __DIR__ . "/../uploads/";
if (!file_exists($target_dir)) {
  mkdir($target_dir, 0755, true);
}

$certificate_image = "";
if (isset($_FILES['certificate_image']) && $_FILES['certificate_image']['error'] == 0) {
  $allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
  $original_name = basename($_FILES['certificate_image']['name']);
  $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

  // Only allow real image files (checked by content, not just the extension) to
  // stop someone uploading a .php file disguised as an image into a public folder.
  $image_info = @getimagesize($_FILES['certificate_image']['tmp_name']);

  if (!in_array($ext, $allowed_ext) || $image_info === false) {
    echo json_encode(["success" => false, "message" => "Only image files (jpg, jpeg, png, webp, avif) are allowed"]);
    exit();
  }

  if ($_FILES['certificate_image']['size'] > 5 * 1024 * 1024) {
    echo json_encode(["success" => false, "message" => "Image must be smaller than 5MB"]);
    exit();
  }

  $filename = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $original_name);
  $target_file = $target_dir . $filename;

  if (move_uploaded_file($_FILES['certificate_image']['tmp_name'], $target_file)) {
    // store relative path for frontend
    $certificate_image = "uploads/" . $filename;
  }
}

$sql = "INSERT INTO certifications (title, organization, issue_date, certificate_link, certificate_image)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $title, $organization, $issue_date, $certificate_link, $certificate_image);

if ($stmt->execute()) {
  echo json_encode(["success" => true, "message" => "Certification added successfully"]);
} else {
  echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}
