<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT u.*, 
                       (SELECT COUNT(*) FROM turmas t WHERE t.professor_id = u.id) as total_turmas
                       FROM usuarios u 
                       WHERE u.id = ? AND u.tipo = 'professor'");
$stmt->execute([$id]);
$professor = $stmt->fetch();

if (!$professor) {
    header('Location: index.php');
    exit;
}

// Buscar turmas do professor
$stmt = $pdo->prepare("SELECT t.*, 
                       (SELECT COUNT(*) FROM alunos a WHERE a.turma_id = t.id AND a.status = 'ativo') as total_alunos 
                       FROM turmas t 
                       WHERE t.professor_id = ?");
$stmt->execute([$id]);
$turmas = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2><i class="fas fa-chalkboard-teacher me-2"></i>Detalhes do Professor</h2>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações Pessoais</h5>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($professor['nome']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($professor['email']); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?php echo $professor['status'] == 'ativo' ? 'success' : 'danger'; ?>">
                            <?php echo ucfirst($professor['status']); ?>
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Informações Acadêmicas</h5>
                    <p><strong>Total de Turmas:</strong> <?php echo $professor['total_turmas']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($turmas)): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Turmas Atribuídas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Série</th>
                            <th>Classe</th>
                            <th>Total de Alunos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($turma['serie']); ?></td>
                            <td><?php echo htmlspecialchars($turma['classe']); ?></td>
                            <td><?php echo $turma['total_alunos']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="editar.php?id=<?php echo $professor['id']; ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>