<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    // Verificar se existem alunos na turma
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM alunos WHERE turma_id = ? AND status = 'ativo'");
    $stmt->execute([$id]);
    $total_alunos = $stmt->fetch()['total'];

    if ($total_alunos > 0) {
        $_SESSION['mensagem'] = "Não é possível excluir uma turma com alunos ativos!";
        $_SESSION['tipo_mensagem'] = "danger";
    } else {
        $stmt = $pdo->prepare("DELETE FROM turmas WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['mensagem'] = "Turma excluída com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    }
} catch(PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao excluir turma: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
}

header('Location: index.php');
exit;
?>