<?php
// Inicia a sessão em todas as páginas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Volta pro login se não estiver logado com o usuario
    header("Location: login.php?erro=acesso_negado");
    exit();
}
?>