<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serie = limparDados($_POST['serie']);
    $classe = limparDados($_POST['classe']);
    $professor_id = filter_input(INPUT_POST, 'professor_id', FILTER_VALIDATE_INT);

    try {
        $stmt = $pdo->prepare("UPDATE turmas SET serie = ?, classe = ?, professor_id = ? WHERE id = ?");
        $stmt->execute([$serie, $classe, $professor_id, $id]);
        
        $_SESSION['mensagem'] = "Turma atualizada com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $erro = "Erro ao atualizar: " . $e->getMessage();
    }
}

// Buscar dados da turma
$stmt = $pdo->prepare("SELECT * FROM turmas WHERE id = ?");
$stmt->execute([$id]);
$turma = $stmt->fetch();

if (!$turma) {
    header('Location: index.php');
    exit;
}

// Buscar professores disponíveis
$stmt = $pdo->query("SELECT id, nome FROM usuarios WHERE tipo = 'professor' AND status = 'ativo' ORDER BY nome");
$professores = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2><i class="fas fa-edit me-2"></i>Editar Turma</h2>
    
    <?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="serie" class="form-label">Série</label>
                    <input type="text" class="form-control" id="serie" name="serie" 
                           value="<?php echo htmlspecialchars($turma['serie']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="classe" class="form-label">Classe</label>
                    <input type="text" class="form-control" id="classe" name="classe" 
                           value="<?php echo htmlspecialchars($turma['classe']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="professor_id" class="form-label">Professor</label>
                    <select class="form-select" id="professor_id" name="professor_id">
                        <option value="">Selecione um professor</option>
                        <?php foreach ($professores as $professor): ?>
                        <option value="<?php echo $professor['id']; ?>" 
                                <?php echo $turma['professor_id'] == $professor['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($professor['nome']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar
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