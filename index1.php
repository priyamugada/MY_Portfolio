<?php
require_once __DIR__ . '/config/db_config.php';
if (!$conn) {
    echo "not connected";
    exit();
}
$sql="select * from soft_skills";
$soft_skills=mysqli_query($conn,$sql);
$sql="select * from technical_skills";
$technical_skills=mysqli_query($conn,$sql);
$sql="select * from projects";
$projects=mysqli_query($conn,$sql);

?>