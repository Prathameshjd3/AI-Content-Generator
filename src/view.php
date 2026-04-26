<?php include "../config/db.php";

$id = $_GET['id'];
$data = $db->query("SELECT * FROM ai_content_records WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Content</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="../assets/ckeditor/ckeditor.js"></script>
</head>

<body class="bg-light">

<div class="container py-5">

<!-- Header -->
<div class="text-center mb-4">
    <h1 class="fw-bold">AI Content Generator</h1>
    <p class="text-muted">Generate high-quality content effortlessly using AI</p>
</div>

<!-- Card -->
<div class="card shadow-lg border-0">
<div class="card-body p-4">

<h5 class="mb-3"><?= htmlspecialchars($data['prompt']) ?></h5>

<textarea id="editor"></textarea>

<div class="mt-3">
    <a href="history.php" class="btn btn-secondary">Back</a>
</div>

</div>
</div>

</div>

<script>
CKEDITOR.replace('editor');
CKEDITOR.instances['editor'].setData(`<?= addslashes($data['generated_content']) ?>`);
</script>

</body>
</html>