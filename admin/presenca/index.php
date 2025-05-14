<?php
require_once '../../includes/header.php';

$data_atual = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

if (isProfessor()) {
    $stmt = $pdo->prepare("SELECT t.* FROM turmas t 
                          WHERE t.professor_id = ? 
                          ORDER BY t.serie, t.classe");
    $stmt->execute([$_SESSION['usuario_id']]);
} else {
    $stmt = $pdo->query("SELECT * FROM turmas ORDER BY serie, classe");
}
$turmas = $stmt->fetchAll();

$turma_selecionada = isset($_GET['turma_id']) ? $_GET['turma_id'] : ($turmas[0]['id'] ?? null);

if ($turma_selecionada) {
    $stmt = $pdo->prepare("SELECT a.*, p.presente 
                          FROM alunos a 
                          LEFT JOIN presenca p ON a.id = p.aluno_id 
                          AND p.data_presenca = ?
                          WHERE a.turma_id = ? AND a.status = 'ativo'
                          ORDER BY a.nome");
    $stmt->execute([$data_atual, $turma_selecionada]);
    $alunos = $stmt->fetchAll();
}
?>

<div class="container-fluid">
    <h2><i class="fas fa-clipboard-check me-2"></i>Controle de Presença</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="turma_id" class="form-label">Turma</label>
                    <select class="form-select" id="turma_id" name="turma_id" onchange="this.form.submit()">
                        <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['id']; ?>" 
                                <?php echo $turma['id'] == $turma_selecionada ? 'selected' : ''; ?>>
                            <?php echo $turma['serie'] . ' ' . $turma['classe']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="data" class="form-label">Data</label>
                    <input type="date" class="form-control" id="data" name="data" 
                           value="<?php echo $data_atual; ?>" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <?php if ($turma_selecionada && !empty($alunos)): ?>
    <form method="POST" action="salvar_presenca.php">
        <input type="hidden" name="data" value="<?php echo $data_atual; ?>">
        <input type="hidden" name="turma_id" value="<?php echo $turma_selecionada; ?>">
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-center">Presença</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" 
                                               name="presenca[<?php echo $aluno['id']; ?>]" 
                                               value="1" <?php echo $aluno['presente'] ? 'checked' : ''; ?>>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" 
                                           name="observacao[<?php echo $aluno['id']; ?>]">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Salvar Presença
                </button>
            </div>
        </div>
    </form>
    <?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Nenhum aluno encontrado para esta turma.
    </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>