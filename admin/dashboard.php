<?php
require_once '../includes/header.php';

// Estatísticas gerais
$stmt = $pdo->query("SELECT COUNT(*) as total FROM alunos WHERE status = 'ativo'");
$total_alunos = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE tipo = 'professor' AND status = 'ativo'");
$total_professores = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM turmas");
$total_turmas = $stmt->fetch()['total'];

$data_atual = date('Y-m-d');
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM presenca WHERE data_presenca = ? AND presente = 1");
$stmt->execute([$data_atual]);
$presentes_hoje = $stmt->fetch()['total'];
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>

    <!-- Cards de Estatísticas -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Alunos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_alunos; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Presentes Hoje</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $presentes_hoje; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total de Professores</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_professores; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total de Turmas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_turmas; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Links Rápidos -->
    <div class="row">
        <?php if (isDiretor()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-users me-2"></i>Alunos
                    </h5>
                    <p class="card-text">Gerenciar cadastros de alunos e matrículas.</p>
                    <a href="/admin/alunos/" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Professores
                    </h5>
                    <p class="card-text">Gerenciar cadastros de professores.</p>
                    <a href="/admin/professores/" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chalkboard me-2"></i>Turmas
                    </h5>
                    <p class="card-text">Gerenciar turmas e atribuições.</p>
                    <a href="/admin/turmas/" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Acessar
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isProfessor()): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-clipboard-check me-2"></i>Presenças
                    </h5>
                    <p class="card-text">Registrar presenças dos alunos.</p>
                    <a href="/admin/presenca/" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i>Relatórios
                    </h5>
                    <p class="card-text">Visualizar relatórios de presença.</p>
                    <a href="/admin/presenca/relatorio.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Acessar
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>