<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Handle blog creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO blogs (title, content) VALUES (:title, :content)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->execute();

    $message = "Blog posted successfully!";
}

// Handle blog deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = :id");
    $stmt->bindParam(':id', $delete_id);
    $stmt->execute();

    header('Location: admin_dashboard.php');
    exit;
}

// Fetch all blogs
$stmt = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        form {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            cursor: pointer;
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <!-- Blog Creation Form -->
    <form method="POST">
        <h3>Create a New Blog</h3>
        <input type="text" name="title" placeholder="Blog Title" required>
        <textarea name="content" placeholder="Blog Content" rows="5" required></textarea>
        <button type="submit" name="create">Post Blog</button>
    </form>

    <!-- Blog List -->
    <h3>Manage Existing Blogs</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><?php echo htmlspecialchars($blog['id']); ?></td>
                    <td><?php echo htmlspecialchars($blog['title']); ?></td>
                    <td>
                        <a href="edit_blog.php?id=<?php echo $blog['id']; ?>">Edit</a> |
                        <a href="admin_dashboard.php?delete_id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
