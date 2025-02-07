<?php
include 'config.php';

// verifica se o usuario esta logado
// se nao houver sessao de usuario, redireciona para login
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

// verifica se o formulario foi enviado via metodo post
if ($_server['request_method'] === 'post') {
    // remove espacos em branco do inicio/fim dos campos
    $title = trim($_post['title']);
    $content = trim($_post['content']);
    
    // pega o id do usuario da sessao
    $user_id = $_session['user']['id'];
    
    // prepara a query sql usando prepared statements
    // os ? sao placeholders para prevenir sql injection
    $stmt = $pdo->prepare("insert into posts (title, content, user_id) values (?, ?, ?)");
    
    // executa a query passando os valores em array
    $stmt->execute([$title, $content, $user_id]);
    
    // redireciona para a pagina inicial apos criar o post
    header("location: index.php");
    exit();
}

include 'header.php';
?>

<h1>criar posts</h1>
<form method="post">
    <input type="text" name="title" placeholder="titulo" required>
    
    <textarea name="content" placeholder="conteudo" required></textarea>
    
    <button type="submit">criar post</button>
</form>

<?php 
include 'footer.php'; 
?>