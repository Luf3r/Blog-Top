<?php
include 'config.php';

// verifica autenticacao do usuario
if (!isset($_session['user'])) {
    header("location: login.php");
    exit();
}

// busca post para edicao
$post_id = $_get['id'];
$stmt = $pdo->prepare("select * from posts where id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

// verifica permissoes: post existe + dono ou admin
if (!$post || ($post['user_id'] != $_session['user']['id'] && !$_session['user']['is_admin'])) {
    header("location: index.php");
    exit();
}

// processa formulario de edicao
if ($_server['request_method'] === 'post') {
    $title = trim($_post['title']);
    $content = trim($_post['content']);
    
    // atualiza post com prepared statement
    $stmt = $pdo->prepare("update posts set title = ?, content = ? where id = ?");
    $stmt->execute([$title, $content, $post_id]);
    header("location: index.php");
    exit();
}

// inclui cabecalho html
include 'header.php';
?>

<!-- formulario de edicao -->
<h1>editar post</h1>
<form method="post">
    <!-- exibe dados atuais com escape contra xss -->
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
    <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
    <button type="submit">atualizar post</button>
</form>

<?php include 'footer.php'; ?>