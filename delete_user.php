<?php
include 'config.php';

// verifica se usuario e admin logado
// se nao for, redireciona para pagina inicial
if (!isset($_session['user']) || !$_session['user']['is_admin']) {
    header("location: index.php");
    exit();
}

// verifica se recebeu id de usuario para deletar
if (isset($_get['user_id'])) {
    $user_id = $_get['user_id'];
    
    // impede auto-delecao de admins
    if ($user_id == $_session['user']['id']) {
        $_session['message'] = "voce nao pode se deletar.";
        header("location: manage_users.php");
        exit();
    }

    try {
        // inicia transacao para operacoes atomicas
        $pdo->begintransaction();
        
        // remove posts do usuario (prepared statement)
        $stmt = $pdo->prepare("delete from posts where user_id = ?");
        $stmt->execute([$user_id]);
        
        // remove usuario (prepared statement)
        $stmt = $pdo->prepare("delete from users where id = ?");
        $stmt->execute([$user_id]);
        
        // confirma operacoes no banco
        $pdo->commit();
        $_session['message'] = "usuario removido com sucesso.";
    } catch (pdoexception $e) {
        // reverte operacoes em caso de erro
        $pdo->rollback();
        $_session['message'] = "erro: " . $e->getmessage();
    }
} else {
    $_session['message'] = "requisicao invalida.";
}

// redireciona para painel de gerenciamento
header("location: manage_users.php");
exit();