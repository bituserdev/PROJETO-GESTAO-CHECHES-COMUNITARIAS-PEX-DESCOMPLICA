<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT t.*, u.nome as professor_nome 
                       FROM turmas t 
                       LEFT JOIN usuarios u ON t.professor_id = u.id 
                       WHERE t.id = ?");
$stmt->execute([$id]);
$turma = $stmt->fetch();

if (!$turma) {
    header('Location: index.php');
    exit;
}

// Buscar alunos da turma
$stmt = $pdo->prepare("SELECT * FROM alunos WHERE turma_id = ? AND status = 'ativo' ORDER BY nome");
$stmt->execute([$id]);
$alunos = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2><i class="fas fa-chalkboard me-2"></i>Detalhes da Turma</h2>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações da Turma</h5>
                    <p><strong>Série:</strong> <?php echo htmlspecialchars($turma['serie']); ?></p>
                    <p><strong>Classe:</strong> <?php echo htmlspecialchars($turma['classe']); ?></p>
                    <p><strong>Professor:</strong> <?php echo htmlspecialchars($turma['professor_nome'] ?? 'Não atribuído'); ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Estatísticas</h5>
                    <p><strong>Total de Alunos:</strong> <?php echo count($alunos); ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($alunos)): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Lista de Alunos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Responsável</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['responsavel']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['telefone']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="editar.php?id=<?php echo $turma['id']; ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>