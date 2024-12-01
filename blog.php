<?php
include 'config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo "Blog not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link animation styles -->
</head>

<body>
    <!-- Animation Container -->
    <div id="container" class="container">
        <div id="output"></div>
    </div>

    <div class="content">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
    </div>

    <!-- Include Animation Script -->
    <script src="js/script.js"></script>
</body>

</html>