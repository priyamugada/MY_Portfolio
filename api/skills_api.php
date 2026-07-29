<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db_config.php';

if (!$conn) {
    $response = array("success" => false, "message" => "Cannot connect right now!");
    echo json_encode($response);
    exit();
}

$table_name = isset($_POST['table_name']) ? trim($_POST['table_name']) : '';
$skill_name = isset($_POST['skillName']) ? trim($_POST['skillName']) : '';
$skill_level = isset($_POST['proficiency']) ? trim($_POST['proficiency']) : '';

if ($skill_name === '' || $skill_level === '') {
    $response = array("success" => false, "message" => "Skill name and proficiency are required");
    echo json_encode($response);
    exit();
}

if ($table_name === 'technical') {
    $sql = "INSERT INTO technical_skills (programming_language, proficiency) VALUES (?, ?)";
} elseif ($table_name === 'soft') {
    $sql = "INSERT INTO soft_skills (skills, proficiency) VALUES (?, ?)";
} else {
    $response = array("success" => false, "message" => "Invalid table name");
    echo json_encode($response);
    exit();
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $skill_name, $skill_level);

if (mysqli_stmt_execute($stmt)) {
    $response = array("success" => true, "message" => "Skill added successfully");
} else {
    $response = array("success" => false, "message" => mysqli_stmt_error($stmt));
}

echo json_encode($response);
mysqli_stmt_close($stmt);
mysqli_close($conn);
