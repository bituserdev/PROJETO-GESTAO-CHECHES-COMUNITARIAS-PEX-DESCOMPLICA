<?php
require_once '../../includes/header.php';
verificaPermissao('diretor');

$stmt = $pdo->query("SELECT * FROM usuarios WHERE status = 'ativo' ORDER BY nome");
$usuarios = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-users me-2"></i>Usuários</h2>
        <a href="cadastrar.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Usuário
        </a>
    </div>

    <?php if (isset($_SESSION['senha_temp'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo $_SESSION['mensagem']; ?>
        <br>
        <strong>Senha temporária: <?php echo $_SESSION['senha_temp']; ?></strong>
        <br>
        <small>Anote esta senha, pois ela não será exibida novamente.</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        unset($_SESSION['senha_temp']);
        unset($_SESSION['mensagem']);
    endif; 
    ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo ucfirst($usuario['tipo']); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                <a href="excluir.php?id=<?php echo $usuario['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
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