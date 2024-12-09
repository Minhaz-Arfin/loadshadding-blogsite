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
    <link rel="stylesheet" href="css/style.css">

    <style>


    body {
        background: url('images/background.jpg') no-repeat center center fixed;
        background-size: cover;
    }


        .card {
            background: rgba(0, 0, 0, 0.7); /* Translucent black background */
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 50px auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 2rem;
            text-align: center;
        }
        p {
            font-size: 1rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
    </div>
</body>
</html>
