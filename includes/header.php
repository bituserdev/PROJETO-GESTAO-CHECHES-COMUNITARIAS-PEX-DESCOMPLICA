<?php 
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php'; 
verificaLogin(); 
?> 
<!DOCTYPE html> 
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Sistema de Gestão Escolar</title> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="<?php echo getBaseUrl(); ?>/assets/css/custom.css" rel="stylesheet"> 
</head> 
<body> 
    <div class="d-flex"> 
        <!-- Sidebar --> 
        <div class="sidebar"> 
            <div class="sidebar-header"> 
                <i class="fas fa-school fa-2x text-white"></i> 
                <h4 class="text-white">Gestão Escolar</h4> 
            </div> 
            <ul class="nav flex-column"> 
                <li class="nav-item"> 
                    <a href="<?php echo getBaseUrl(); ?>/admin/dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"> 
                        <i class="fas fa-tachometer-alt"></i> Dashboard 
                    </a> 
                </li> 
                <?php if (isDiretor()): ?> 
                <li class="nav-item"> 
                    <a href="<?php echo getBaseUrl(); ?>/admin/alunos/" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/alunos/') ? 'active' : ''; ?>"> 
                        <i class="fas fa-users"></i> Alunos 
                    </a> 
                </li> 
                <li class="nav-item"> 
                    <a href="<?php echo getBaseUrl(); ?>/admin/professores/" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/professores/') ? 'active' : ''; ?>"> 
                        <i class="fas fa-chalkboard-teacher"></i> Professores 
                    </a> 
                </li> 
                <?php endif; ?> 
                <li class="nav-item"> 
                    <a href="<?php echo getBaseUrl(); ?>/admin/presenca/" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/presenca/') ? 'active' : ''; ?>"> 
                        <i class="fas fa-clipboard-check"></i> Presença 
                    </a> 
                </li> 
                <li class="nav-item"> 
                    <a href="<?php echo getBaseUrl(); ?>/logout.php" class="nav-link text-danger"> 
                        <i class="fas fa-sign-out-alt"></i> Sair 
                    </a> 
                </li> 
            </ul> 
        </div> 

        <!-- Conteúdo Principal --> 
        <div class="main-content"> 
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm"> 
                <div class="container-fluid"> 
                    <span class="navbar-text"> 
                        <i class="fas fa-user-circle me-2"></i> 
                        Bem-vindo(a), <?php echo getUsuarioNome(); ?> 
                    </span> 
                </div> 
            </nav> 
            <div class="container-fluid mt-4">