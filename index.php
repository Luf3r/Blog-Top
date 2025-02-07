<?php
include 'config.php';
include 'helpers.php';
include 'header.php';

$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<h1>Todos os Posts</h1>

<?php foreach ($posts as $post): ?>
    <article>
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <small>Por <?= htmlspecialchars($post['username']) ?> em <?= formatDateTime($post['created_at']) ?></small>
        
        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $post['user_id'] || $_SESSION['user']['is_admin'])): ?>
            <div class="post-actions">
                <a href="edit_post.php?id=<?= $post['id'] ?>" class="button">Edit</a>
                <a href="delete_post.php?id=<?= $post['id'] ?>" class="button button-delete" onclick="return confirm('Tem certeza que você quer deletar esse post?')">Delete</a>
            </div>
        <?php endif; ?>
    </article>
    <hr>
<?php endforeach; ?>

<?php include 'footer.php'; ?>