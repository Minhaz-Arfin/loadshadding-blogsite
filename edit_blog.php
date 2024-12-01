<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid blog ID.";
    exit;
}

// Fetch the blog for editing
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE blogs SET title = :title, content = :content WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
</head>

<body>
    <h2>Edit Blog</h2>
    <form method="POST">
        <input type="text" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
        <textarea name="content" rows="5" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
        <button type="submit">Update Blog</button>
    </form>
</body>

</html>