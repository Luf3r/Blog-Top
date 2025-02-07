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
                <!-- Exibição segura do username com htmlspecialchars -->
                <span>Bem-vindo(a), <?= htmlspecialchars($_SESSION['user']['username']) ?>!</span>
                <div>
                    <!-- Links privilegiados -->
                    <a href="create_post.php" class="action-button">Criar Post</a>
                    <?php if ($_SESSION['user']['is_admin']): ?>
                        <!-- Acesso restrito a admin corretamente verificado -->
                        <a href="manage_users.php" class="action-button">Gerenciar Usuários</a>
                    <?php endif; ?>
                    <!-- Logout via GET -->
                    <a href="logout.php" class="action-button">Logout</a>
                </div>
            <?php else: ?>
                <div>
                    <!-- Links públicos -->
                    <a href="register.php">Registrar</a>
                    <a href="login.php">Login</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>