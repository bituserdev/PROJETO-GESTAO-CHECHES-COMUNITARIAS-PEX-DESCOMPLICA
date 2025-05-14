<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$stmt = $pdo->query("SELECT a.*, t.serie, t.classe FROM alunos a 
                     LEFT JOIN turmas t ON a.turma_id = t.id 
                     WHERE a.status = 'ativo'
                     ORDER BY a.nome");
$alunos = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users me-2"></i>Gerenciar Alunos</h2>
        <a href="cadastrar.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Aluno
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Turma</th>
                            <th>Responsável</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo $aluno['serie'] . ' ' . $aluno['classe']; ?></td>
                            <td><?php echo htmlspecialchars($aluno['responsavel']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['telefone']); ?></td>
                            <td>
                                <a href="visualizar.php?id=<?php echo $aluno['id']; ?>" class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="editar.php?id=<?php echo $aluno['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="excluir.php?id=<?php echo $aluno['id']; ?>" class="btn btn-sm btn-danger" title="Excluir" 
                                   onclick="return confirmarExclusao('Tem certeza que deseja excluir este aluno?')">
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