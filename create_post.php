<?php
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user']['id'];
    
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $user_id]);
    header("Location: index.php");
    exit();
}

include 'header.php';
?>

<h1>Criar Posts</h1>
<form method="post">
    <input type="text" name="title" placeholder="Título" required>
    <textarea name="content" placeholder="Conteúdo" required></textarea>
    <button type="submit">Criar Post</button>
</form>

<?php include 'footer.php'; ?>