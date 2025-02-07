<!DOCTYPE html>
<html>
<head>
    <title>Blog Top</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Blog Top</h1>
        <nav>
            <?php if (isset($_SESSION['user'])): ?>
                <span>Bem-vindo(a), <?= htmlspecialchars($_SESSION['user']['username']) ?>!</span>
                <div>
                    <a href="create_post.php" class="action-button">Criar Post</a>
                    <?php if ($_SESSION['user']['is_admin']): ?>
                        <a href="manage_users.php" class="action-button">Gerenciar Usuários</a>
                    <?php endif; ?>
                    <a href="logout.php" class="action-button">Logout</a>
                </div>
            <?php else: ?>
                <div>
                    <a href="register.php">Registrar</a>
                    <a href="login.php">Login</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>