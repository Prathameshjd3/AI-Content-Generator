<?php
include "../config/db.php";


if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Invalid request");
}

$id = $_GET['id'];


$stmt = $db->prepare("DELETE FROM ai_content_records WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    // Redirect back to history page
    header("Location: history.php?msg=deleted");
    exit;
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$db->close();
?>