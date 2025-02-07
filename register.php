<?php
include 'config.php';

// Processamento do formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // remove espacos em branco
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash seguro
    
    try {
        // prepared statements contra SQL Injection
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        
        // mensagem de sucesso
        $_SESSION['message'] = "Registro com sucesso! Por favor faça o login agora.";
        header("Location: login.php"); // redirecionamento pos-registro
        exit();
    } catch (PDOException $e) {
        // Mensagem genérica (evita enumeração de usuarios)
        $error = "Nome de usuário invalido!"; 
    }
}

include 'header.php'; // Cabeçalho comum
?>

<h1>Registrar</h1>
<?php if (isset($error)) echo "<p>$error</p>" ?>
<!-- ⚠️ galta sanitizacao da mensagem de erro (XSS potencial) -->

<form method="post">
    <!-- ⚠️ falta validacao de complexidade de senha no client-side -->
    <!-- ⚠️ nao possui campo de confirmacao de senha -->
    <!-- ⚠️ falta CSRF token -->
    
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Registrar</button>
</form>

<?php include 'footer.php'; ?>