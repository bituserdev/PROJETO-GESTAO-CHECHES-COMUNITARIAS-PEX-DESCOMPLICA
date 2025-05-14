<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tipo = filter_input(INPUT_POST, 'tipo');
    
    // Gera uma senha aleatória
    $senha = gerarSenhaAleatoria(8);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha_hash, $tipo])) {
            // Armazena a senha temporária para exibir ao usuário
            $_SESSION['senha_temp'] = $senha;
            header('Location: index.php?success=1');
            exit;
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $erro = "Este email já está cadastrado.";
        } else {
            $erro = "Erro ao cadastrar usuário.";
        }
    }
}
?>

<div class="container-fluid">
    <h2><i class="fas fa-user-plus me-2"></i>Cadastrar Usuário</h2>

    <?php if (isset($erro)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $erro; ?>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Usuário</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">Selecione...</option>
                        <option value="professor">Professor</option>
                        <option value="diretor">Diretor</option>
                    </select>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Uma senha aleatória será gerada automaticamente e exibida após o cadastro.
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Cadastrar
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>