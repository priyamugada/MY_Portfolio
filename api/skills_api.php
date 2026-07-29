<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db_config.php';

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . mysqli_connect_error()]);
    exit();
}

$action     = trim($_POST['action'] ?? 'add');
$table_name = trim($_POST['table_name'] ?? '');

if ($table_name !== 'technical' && $table_name !== 'soft') {
    echo json_encode(["success" => false, "message" => "Invalid skill type/table name"]);
    exit();
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid skill ID"]);
        exit();
    }

    $table = ($table_name === 'technical') ? 'technical_skills' : 'soft_skills';
    $sql   = "DELETE FROM {$table} WHERE id = ?";
    $stmt  = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Skill deleted successfully", "id" => $id, "type" => $table_name]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

$skill_name  = trim($_POST['skillName'] ?? '');
$skill_level = trim($_POST['proficiency'] ?? '');

if ($skill_name === '' || $skill_level === '') {
    echo json_encode(["success" => false, "message" => "Skill name and proficiency are required"]);
    exit();
}

if ($action === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid skill ID for edit"]);
        exit();
    }

    if ($table_name === 'technical') {
        $sql = "UPDATE technical_skills SET programming_language = ?, proficiency = ? WHERE id = ?";
    } else {
        $sql = "UPDATE soft_skills SET skills = ?, proficiency = ? WHERE id = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $skill_name, $skill_level, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Skill updated successfully", "id" => $id, "type" => $table_name]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    // Add action
    if ($table_name === 'technical') {
        $sql = "INSERT INTO technical_skills (programming_language, proficiency) VALUES (?, ?)";
    } else {
        $sql = "INSERT INTO soft_skills (skills, proficiency) VALUES (?, ?)";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $skill_name, $skill_level);

    if (mysqli_stmt_execute($stmt)) {
        $inserted_id = mysqli_insert_id($conn);
        echo json_encode(["success" => true, "message" => "Skill added successfully", "id" => $inserted_id, "type" => $table_name]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
