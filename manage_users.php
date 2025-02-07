<?php
include 'config.php';
include 'helpers.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT id, username, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

include 'header.php';
?>

<h1>Gerenciar Usuários</h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?= $_SESSION['message'] ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Criado Em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= formatDateTime($user['created_at']) ?></td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                        <a href="delete_user.php?user_id=<?= $user['id'] ?>" class="button button-delete" onclick="return confirm('Você tem certeza:[?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>