<?php
include 'config.php';
include 'helpers.php';
include 'header.php';

// Busca todos os posts com JOIN em users
$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<h1>Todos os Posts</h1>

<?php foreach ($posts as $post): ?>
    <article>
        <!-- Exibição segura com htmlspecialchars -->
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        
        <!-- nl2br mantém quebras de linha + proteção XSS -->
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        
        <!-- Dados do autor com formatação segura -->
        <small>Por <?= htmlspecialchars($post['username']) ?> em <?= formatDateTime($post['created_at']) ?></small>
        
        <!-- Controle de acesso para ações -->
        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $post['user_id'] || $_SESSION['user']['is_admin'])): ?>
            <div class="post-actions">
                <!-- Links de edição/exclusão vulneráveis a CSRF -->
                <a href="edit_post.php?id=<?= $post['id'] ?>" class="button">Edit</a>
                
                <!-- Confirmação client-side apenas (insuficiente) -->
                <a href="delete_post.php?id=<?= $post['id'] ?>" class="button button-delete" 
                   onclick="return confirm('Tem certeza que você quer deletar esse post?')">
                   Delete
                </a>
            </div>
        <?php endif; ?>
    </article>
    <hr>
<?php endforeach; ?>

<?php include 'footer.php'; ?>