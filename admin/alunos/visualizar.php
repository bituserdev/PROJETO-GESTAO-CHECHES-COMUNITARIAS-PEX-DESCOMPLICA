<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT a.*, t.serie, t.classe 
                       FROM alunos a 
                       LEFT JOIN turmas t ON a.turma_id = t.id 
                       WHERE a.id = ?");
$stmt->execute([$id]);
$aluno = $stmt->fetch();

if (!$aluno) {
    header('Location: index.php');
    exit;
}

// Buscar histórico de presença
$stmt = $pdo->prepare("SELECT p.*, DATE_FORMAT(p.data_presenca, '%d/%m/%Y') as data_formatada 
                       FROM presenca p 
                       WHERE p.aluno_id = ? 
                       ORDER BY p.data_presenca DESC 
                       LIMIT 10");
$stmt->execute([$id]);
$presencas = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2><i class="fas fa-user me-2"></i>Detalhes do Aluno</h2>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações Pessoais</h5>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($aluno['nome']); ?></p>
                    <p><strong>Data de Nascimento:</strong> <?php echo formatarData($aluno['data_nascimento']); ?></p>
                    <p><strong>Responsável:</strong> <?php echo htmlspecialchars($aluno['responsavel']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($aluno['telefone']); ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Informações Acadêmicas</h5>
                    <p><strong>Turma:</strong> <?php echo $aluno['serie'] . ' ' . $aluno['classe']; ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?php echo $aluno['status'] == 'ativo' ? 'success' : 'danger'; ?>">
                            <?php echo ucfirst($aluno['status']); ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Histórico de Presença</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($presencas as $presenca): ?>
                        <tr>
                            <td><?php echo $presenca['data_formatada']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $presenca['presente'] ? 'success' : 'danger'; ?>">
                                    <?php echo $presenca['presente'] ? 'Presente' : 'Ausente'; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($presenca['observacao'] ?? ''); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="editar.php?id=<?php echo $aluno['id']; ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>