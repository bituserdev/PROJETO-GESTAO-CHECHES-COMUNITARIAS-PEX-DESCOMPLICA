<?php
require_once '../../includes/header.php';

// Parâmetros do filtro
$turma_id = filter_input(INPUT_GET, 'turma_id', FILTER_VALIDATE_INT);
$data_inicio = filter_input(INPUT_GET, 'data_inicio');
$data_fim = filter_input(INPUT_GET, 'data_fim');

// Buscar turmas disponíveis
if (isProfessor()) {
    $stmt = $pdo->prepare("SELECT t.* FROM turmas t 
                          WHERE t.professor_id = ? 
                          ORDER BY t.serie, t.classe");
    $stmt->execute([$_SESSION['usuario_id']]);
} else {
    $stmt = $pdo->query("SELECT * FROM turmas ORDER BY serie, classe");
}
$turmas = $stmt->fetchAll();

// Buscar dados do relatório se os filtros estiverem definidos
$relatorio = [];
if ($turma_id && $data_inicio && $data_fim) {
    $stmt = $pdo->prepare("
        SELECT 
            a.nome as aluno_nome,
            COUNT(p.id) as total_dias,
            SUM(p.presente) as total_presencas,
            ROUND((SUM(p.presente) / COUNT(p.id)) * 100, 2) as percentual_presenca
        FROM alunos a
        LEFT JOIN presenca p ON a.id = p.aluno_id
        WHERE a.turma_id = ? 
        AND p.data_presenca BETWEEN ? AND ?
        AND a.status = 'ativo'
        GROUP BY a.id, a.nome
        ORDER BY a.nome
    ");
    $stmt->execute([$turma_id, $data_inicio, $data_fim]);
    $relatorio = $stmt->fetchAll();
}
?>

<div class="container-fluid">
    <h2><i class="fas fa-chart-bar me-2"></i>Relatório de Presenças</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="turma_id" class="form-label">Turma</label>
                    <select class="form-select" id="turma_id" name="turma_id" required>
                        <option value="">Selecione uma turma</option>
                        <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['id']; ?>" 
                                <?php echo $turma_id == $turma['id'] ? 'selected' : ''; ?>>
                            <?php echo $turma['serie'] . ' ' . $turma['classe']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="<?php echo $data_inicio; ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="<?php echo $data_fim; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($relatorio)): ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th class="text-center">Total de Dias</th>
                            <th class="text-center">Total de Presenças</th>
                            <th class="text-center">Percentual de Presença</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($relatorio as $registro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registro['aluno_nome']); ?></td>
                            <td class="text-center"><?php echo $registro['total_dias']; ?></td>
                            <td class="text-center"><?php echo $registro['total_presencas']; ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo $registro['percentual_presenca'] >= 75 ? 'success' : 'danger'; ?>">
                                    <?php echo $registro['percentual_presenca']; ?>%
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php elseif ($turma_id && $data_inicio && $data_fim): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Nenhum registro encontrado para o período selecionado.
    </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>