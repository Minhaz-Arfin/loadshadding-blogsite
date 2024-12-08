<?php
include 'config.php';

// Define the number of blogs per page
$blogsPerPage = 6;

// Determine the current page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($currentPage < 1) $currentPage = 1;

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $blogsPerPage;

// Fetch the blogs for the current page
try {
    $stmt = $conn->prepare("SELECT id, title, SUBSTRING(content, 1, 150) AS snippet FROM blogs ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $blogsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total blogs for pagination
    $countStmt = $conn->query("SELECT COUNT(*) AS total FROM blogs");
    $totalBlogs = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalBlogs / $blogsPerPage);
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .card h2 {
            margin: 0;
            padding: 15px;
            font-size: 20px;
            background-color: #007BFF;
            color: #fff;
        }
        .card p {
            padding: 15px;
            margin: 0;
            flex-grow: 1;
            color: #555;
        }
        .card a {
            display: block;
            text-align: center;
            padding: 10px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 0 0 8px 8px;
            font-weight: bold;
        }
        .card a:hover {
            background-color: #0056b3;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        .pagination a.active {
            background-color: #0056b3;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <h1>Blog Posts</h1>
    <div class="card-container">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="card">
                    <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                    <p><?php echo htmlspecialchars($blog['snippet']); ?>...</p>
                    <a href="blog.php?id=<?php echo $blog['id']; ?>">Read More</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No blogs available. Please check back later.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
        <?php endif; ?>
        
        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <a href="?page=<?php echo $page; ?>" class="<?php echo ($page === $currentPage) ? 'active' : ''; ?>">
                <?php echo $page; ?>
            </a>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>
