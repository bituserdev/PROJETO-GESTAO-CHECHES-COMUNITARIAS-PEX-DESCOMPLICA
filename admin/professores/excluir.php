<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET status = 'inativo' WHERE id = ? AND tipo = 'professor'");
    $stmt->execute([$id]);
    
    $_SESSION['mensagem'] = "Professor excluído com sucesso!";
    $_SESSION['tipo_mensagem'] = "success";
} catch(PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao excluir professor: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
}

header('Location: index.php');
exit;
?>