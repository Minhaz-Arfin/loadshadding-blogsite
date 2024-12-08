<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid blog ID.";
    exit;
}

// Fetch the blog details
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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .blog-card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            padding: 20px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }
        .blog-card h1 {
            margin: 0;
            font-size: 2.5rem;
            color: #FFD700;
        }
        .blog-card p {
            line-height: 1.6;
            font-size: 1.2rem;
            color: #f1f1f1;
            margin: 20px 0;
        }
        .blog-card a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .blog-card a:hover {
            background: #0056b3;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="blog-card">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
        <a href="index.php">Back to Blogs</a>
    </div>
</body>
</html>
