<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = limparDados($_POST['nome']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = gerarSenhaAleatoria();
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, status) 
                              VALUES (?, ?, ?, 'professor', 'ativo')");
        $stmt->execute([$nome, $email, $senha_hash]);
        
        $_SESSION['mensagem'] = "Professor cadastrado com sucesso! Senha inicial: " . $senha;
        $_SESSION['tipo_mensagem'] = "success";
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <h2><i class="fas fa-user-plus me-2"></i>Cadastrar Novo Professor</h2>
    
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
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
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