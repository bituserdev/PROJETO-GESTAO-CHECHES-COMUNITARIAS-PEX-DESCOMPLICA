<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificaLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /index.php');
        exit;
    }
}

function verificaPermissao($tipo) {
    verificaLogin();

    if (!isset($_SESSION['usuario_tipo'])) {
        header('Location: /index.php');
        exit;
    }

    if ($_SESSION['usuario_tipo'] !== $tipo && $_SESSION['usuario_tipo'] !== 'diretor') {
        header('Location: /admin/dashboard.php');
        exit;
    }
}
function getTurmaInfo($turma_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT t.*, u.nome as professor_nome 
                          FROM turmas t 
                          LEFT JOIN usuarios u ON t.professor_id = u.id 
                          WHERE t.id = ?");
    $stmt->execute([$turma_id]);
    return $stmt->fetch();
}

function isDiretor() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'diretor';
}

function isProfessor() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'professor';
}

function getUsuarioNome() {
    return $_SESSION['usuario_nome'] ?? 'Usuário';
}
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host;
}

function limparDados($dados) {
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

function formatarData($data) {
    return date('d/m/Y', strtotime($data));
}

function mascaraTelefone($telefone) {
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    if (strlen($telefone) === 11) {
        return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7);
    }
    return $telefone;
}

function gerarSenhaAleatoria($tamanho = 8) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $senha = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $senha;
}
?>