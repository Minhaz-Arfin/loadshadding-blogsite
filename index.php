<?php
include 'config.php';

try {
    $stmt = $conn->query("SELECT id, title, SUBSTRING(content, 1, 100) AS snippet FROM blogs ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching blogs: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Homepage</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link animation styles -->
    <style>
        /* Ensures the container is readable above the animation */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #fff;
            background: #000;
        }

        #container {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1; /* Ensures animation stays in the background */
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white background */
            border-radius: 10px;
            max-width: 800px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            font-size: 1.5rem;
            margin-top: 20px;
            color: #333;
        }

        p {
            font-size: 1rem;
            line-height: 1.5;
            color: #555;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Animation Container -->
    <div id="container" class="container">
        <div id="output"></div>
    </div>

    <!-- Blog Content -->
    <div class="content">
        <h1>Blog Posts</h1>
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                <p><?php echo htmlspecialchars($blog['snippet']); ?>...</p>
                <a href="blog.php?id=<?php echo $blog['id']; ?>">Read More</a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No blogs available. Please check back later.</p>
        <?php endif; ?>
    </div>

    <!-- Include Animation Script -->
    <script src="js/script.js"></script>
</body>
</html>
