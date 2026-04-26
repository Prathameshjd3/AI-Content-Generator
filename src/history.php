<?php include "../config/db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>History Content Generator AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<div class="text-center mb-4">
    <h1 class="fw-bold">AI Content Generator</h1>
    <p class="text-muted">Generate high-quality content effortlessly using AI</p>
</div>

<div class="card shadow">
<div class="card-body">

<div class="mb-3 d-flex justify-content-end">
   <a href="../front/index.php" class="btn btn-sm btn-secondary">Home</a>
</div>

<h4 class="mb-3">History</h4>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Prompt</th>
<th>Content Type</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php
$sql = "SELECT * FROM ai_content_records ORDER BY created_at DESC";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['prompt']) ?></td>
<td><?= htmlspecialchars($row['content_type']) ?></td>
<td><?= $row['created_at'] ?></td>
<td>
<a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a>
<a href="delete.php?id=<?= $row['id'] ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure to delete the content?')">
   Delete
</a>
</td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No history found</td></tr>";
}
?>
</tbody>

</table>
</div>

</div>
</div>

</div>
</body>
</html>