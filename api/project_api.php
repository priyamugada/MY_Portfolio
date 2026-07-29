<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db_config.php';

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . mysqli_connect_error()]);
    exit();
}

$action = trim($_POST['action'] ?? 'add');

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid project ID"]);
        exit();
    }
    
    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Project deleted successfully", "id" => $id]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

$domain_name  = trim($_POST['domainName'] ?? '');
$title        = trim($_POST['projectName'] ?? '');
$technologies = trim($_POST['technologies'] ?? '');
$description  = trim($_POST['projectDesc'] ?? '');
$project_link = trim($_POST['projectLink'] ?? '');

if ($domain_name === '' || $title === '') {
    echo json_encode(["success" => false, "message" => "Project name and domain are required"]);
    exit();
}

if ($action === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid project ID for edit"]);
        exit();
    }
    
    $sql = "UPDATE projects SET domain_name = ?, title = ?, technologies = ?, description = ?, project_link = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $domain_name, $title, $technologies, $description, $project_link, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Project updated successfully", "id" => $id]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    // Default action: add
    $sql = "INSERT INTO projects (domain_name, title, technologies, description, project_link) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $domain_name, $title, $technologies, $description, $project_link);
    
    if (mysqli_stmt_execute($stmt)) {
        $inserted_id = mysqli_insert_id($conn);
        echo json_encode(["success" => true, "message" => "Project added successfully", "id" => $inserted_id]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
