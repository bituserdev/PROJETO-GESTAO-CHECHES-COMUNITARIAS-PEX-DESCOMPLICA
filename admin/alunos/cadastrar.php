<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = limparDados($_POST['nome']);
    $data_nascimento = $_POST['data_nascimento'];
    $responsavel = limparDados($_POST['responsavel']);
    $telefone = limparDados($_POST['telefone']);
    $turma_id = $_POST['turma_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO alunos (nome, data_nascimento, responsavel, telefone, turma_id, status) 
                              VALUES (?, ?, ?, ?, ?, 'ativo')");
        $stmt->execute([$nome, $data_nascimento, $responsavel, $telefone, $turma_id]);
        
        $_SESSION['mensagem'] = "Aluno cadastrado com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT id, serie, classe FROM turmas ORDER BY serie, classe");
$turmas = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2><i class="fas fa-user-plus me-2"></i>Cadastrar Novo Aluno</h2>
    
    <?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="responsavel" class="form-label">Nome do Responsável</label>
                        <input type="text" class="form-control" id="responsavel" name="responsavel" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" 
                               onkeyup="mascaraTelefone(this)" maxlength="15" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="turma_id" class="form-label">Turma</label>
                        <select class="form-select" id="turma_id" name="turma_id" required>
                            <option value="">Selecione uma turma</option>
                            <?php foreach ($turmas as $turma): ?>
                            <option value="<?php echo $turma['id']; ?>">
                                <?php echo $turma['serie'] . ' ' . $turma['classe']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cadastrar
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>