<?php
require_once '../../includes/header.php';

$data = filter_input(INPUT_POST, 'data');
$turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

if (!$data || !$turma_id) {
    $_SESSION['mensagem'] = "Dados inválidos!";
    $_SESSION['tipo_mensagem'] = "danger";
    header('Location: index.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // Primeiro, remove os registros existentes para esta data e turma
    $stmt = $pdo->prepare("DELETE p FROM presenca p 
                          INNER JOIN alunos a ON p.aluno_id = a.id 
                          WHERE p.data_presenca = ? AND a.turma_id = ?");
    $stmt->execute([$data, $turma_id]);

    // Insere os novos registros
    $presencas = $_POST['presenca'] ?? [];
    $observacoes = $_POST['observacao'] ?? [];

    $stmt = $pdo->prepare("INSERT INTO presenca (aluno_id, data_presenca, presente, observacao) 
                          VALUES (?, ?, ?, ?)");

    // Busca todos os alunos da turma
    $stmtAlunos = $pdo->prepare("SELECT id FROM alunos WHERE turma_id = ? AND status = 'ativo'");
    $stmtAlunos->execute([$turma_id]);
    $alunos = $stmtAlunos->fetchAll();

    foreach ($alunos as $aluno) {
        $presente = isset($presencas[$aluno['id']]) ? 1 : 0;
        $observacao = $observacoes[$aluno['id']] ?? '';
        $stmt->execute([$aluno['id'], $data, $presente, $observacao]);
    }

    $pdo->commit();
    $_SESSION['mensagem'] = "Presenças registradas com sucesso!";
    $_SESSION['tipo_mensagem'] = "success";
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['mensagem'] = "Erro ao registrar presenças: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
}

header('Location: index.php?turma_id=' . $turma_id . '&data=' . $data);
exit;
?>