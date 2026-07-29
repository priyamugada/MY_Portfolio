<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db_config.php';

if (!$conn) {
    $response = array("success" => false, "message" => "cannot connect now" . mysqli_connect_error());
    echo json_encode($response);
    exit();
}

$domain_name = trim($_POST['domainName'] ?? '');
$title = trim($_POST['projectName'] ?? '');
$technologies = trim($_POST['technologies'] ?? '');
$description = trim($_POST['projectDesc'] ?? '');
$project_link = trim($_POST['projectLink'] ?? '');

if ($domain_name === '' || $title === '') {
    $response = array("success" => false, "message" => "Project name and domain are required");
    echo json_encode($response);
    exit();
}

// Fixed: previously built with raw string interpolation, which was a SQL
// injection vulnerability. Now uses a prepared statement instead.
$sql = "INSERT INTO projects (domain_name, title, technologies, description, project_link) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $domain_name, $title, $technologies, $description, $project_link);

if (mysqli_stmt_execute($stmt)) {
    $response = array("success" => true, "message" => "succesfully added");
    echo json_encode($response);
} else {
    $response = array("success" => false, "message" => mysqli_stmt_error($stmt));
    echo json_encode($response);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
