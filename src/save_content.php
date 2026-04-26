<?php
include "../config/db.php";

$prompt = $_POST['prompt'] ?? '';
$content_type = $_POST['content_type'] ?? 'General';
$content = $_POST['content'] ?? '';

// echo "Received prompt: " . $prompt . "<br>";
// echo "Received content: " . $content . "<br>";
// echo "Received content type: " . $content_type . "<br>";

if(empty($prompt) || empty($content)) {
    echo "Prompt and content cannot be empty!";
    exit;
}

$stmt = $db->prepare("INSERT INTO ai_content_records 
(prompt, content_type, generated_content, created_at) 
VALUES (?, ?, ?, NOW())");

// 3 values → 3 types
$stmt->bind_param("sss", $prompt, $content_type, $content);

if($stmt->execute()) {
    echo "Content saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$db->close();
?>