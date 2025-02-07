<?php
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    if ($post && ($_SESSION['user']['id'] == $post['user_id'] || $_SESSION['user']['is_admin'])) {
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $_SESSION['message'] = "Post deletado com sucesso!.";
    } else {
        $_SESSION['message'] = "Você não tem permissão para deletar esse post.";
    }
}

header("Location: index.php");
exit();