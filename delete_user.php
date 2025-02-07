<?php
include 'config.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    if ($user_id == $_SESSION['user']['id']) {
        $_SESSION['message'] = "Você não pode deletar a si mesmo.";
        header("Location: manage_users.php");
        exit();
    }

    try {
        $pdo->beginTransaction();
        
        // Deletar post do usuario
        $stmt = $pdo->prepare("DELETE FROM posts WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        // Deletar o usuario
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        $pdo->commit();
        $_SESSION['message'] = "Usuário deletado com sucesso.";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['message'] = "Solicitação inválida.";
}

header("Location: manage_users.php");
exit();
?>