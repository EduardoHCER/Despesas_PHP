<?php
// Garante que a sessão seja iniciada antes de ser destruída
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Remove todas as variáveis da sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login com uma mensagem de sucesso
header("Location: login.php?status=logout");
exit();
?>