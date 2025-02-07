<?php
include 'config.php';

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Sem sanitização
    $password = $_POST['password'];
    
    // Consulta segura com prepared statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(); // 5. Pode retornar false
    
    // Verificação correta de senha hash
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; // risco de session fixation
        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciais inválidas!"; // mensagem generica
    }
}

include 'header.php'; // Cabeçalho comum
?>

<h1>Login</h1>
<?php if (isset($error)) echo "<p>$error</p>" ?> <!-- XSS potential -->
<form method="post">
    <!-- Falta autocomplete="off" -->
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <!-- Falta CSRF token -->
    <button type="submit">Login</button>
</form>

<?php include 'footer.php'; ?>