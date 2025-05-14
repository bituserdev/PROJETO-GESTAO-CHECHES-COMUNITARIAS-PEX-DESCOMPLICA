<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$stmt = $pdo->query("SELECT t.*, u.nome as professor_nome,
                    (SELECT COUNT(*) FROM alunos a WHERE a.turma_id = t.id AND a.status = 'ativo') as total_alunos
                    FROM turmas t
                    LEFT JOIN usuarios u ON t.professor_id = u.id
                    ORDER BY t.serie, t.classe");
$turmas = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chalkboard me-2"></i>Gerenciar Turmas</h2>
        <a href="cadastrar.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nova Turma
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Série</th>
                            <th>Classe</th>
                            <th>Professor</th>
                            <th>Total de Alunos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($turma['serie']); ?></td>
                            <td><?php echo htmlspecialchars($turma['classe']); ?></td>
                            <td><?php echo htmlspecialchars($turma['professor_nome'] ?? 'Não atribuído'); ?></td>
                            <td><?php echo $turma['total_alunos']; ?></td>
                            <td>
                                <a href="visualizar.php?id=<?php echo $turma['id']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="editar.php?id=<?php echo $turma['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="excluir.php?id=<?php echo $turma['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tem certeza que deseja excluir esta turma?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>