<?php
include 'config.php';

// verifica se usuario esta logado
// se nao existir sessao 'user', redireciona para login
if (!isset($_session['user'])) {
    header("location: login.php");
    exit();
}

// verifica se recebeu id via get
if (isset($_get['id'])) {
    // captura id do post a ser deletado
    $post_id = $_get['id'];
    
    // consulta o post no banco usando prepared statement
    $stmt = $pdo->prepare("select * from posts where id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    // verifica permissoes:
    // 1. se post existe
    // 2. se usuario e dono do post ou administrador
    if ($post && ($_session['user']['id'] == $post['user_id'] || $_session['user']['is_admin'])) {
        // prepara e executa delete usando prepared statement
        $stmt = $pdo->prepare("delete from posts where id = ?");
        $stmt->execute([$post_id]);
        // mensagem de sucesso na sessao
        $_session['message'] = "post deletado com sucesso!.";
    } else {
        // mensagem de erro na sessao
        $_session['message'] = "voce nao tem permissao para deletar esse post.";
    }
}

// redireciona para pagina inicial independente do resultado
header("location: index.php");
exit();