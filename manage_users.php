<?php
include 'config.php'; 
include 'helpers.php';

// verifica se usuario e admin logado
// nao verifica alteracoes na sessao ou fingerprint
if (!isset($_session['user']) || !$_session['user']['is_admin']) {
    header("location: index.php");
    exit();
}

// busca todos usuarios sem paginacao
// risco de performance com muitos registros
$stmt = $pdo->query("select id, username, created_at from users order by created_at desc");
$users = $stmt->fetchall();

include 'header.php';
?>

<h1>gerenciar usuarios</h1>

<!-- exibe mensagem sem sanitizacao (risco xss) -->
<?php if (isset($_session['message'])): ?>
    <div class="message"><?= $_session['message'] ?></div>
    <?php unset($_session['message']); ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>usuario</th>
            <th>data registro</th>
            <th>acoes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <!-- username protegido contra xss -->
                <td><?= htmlspecialchars($user['username']) ?></td>
                
                <!-- data formatada por funcao helper -->
                <td><?= formatdatetime($user['created_at']) ?></td>
                
                <td>
                    <!-- impede auto-delecao -->
                    <?php if ($user['id'] != $_session['user']['id']): ?>
                        <!-- problema 1: acao via get -->
                        <!-- problema 2: falta token csrf -->
                        <!-- problema 3: texto de confirmacao quebrado -->
                        <a href="delete_user.php?user_id=<?= $user['id'] ?>" 
                           class="button button-delete" 
                           onclick="return confirm('voce tem certeza:[?')"> 
                           delete
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>