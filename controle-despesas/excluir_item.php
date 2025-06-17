<?php
require 'config/proteger_pagina.php'; // Protege a página
require 'config/conexao.php';

// 1. Pega o ID da URL e o ID do usuário da sessão
$item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario_id = $_SESSION['usuario_id'];

// 2. Verifica se o ID é válido
if (!$item_id) {
    // Se não houver ID, redireciona de volta para o dashboard
    header("Location: dashboard.php");
    exit();
}

// 3. Prepara e executa a query de exclusão
// A query SÓ DEVE DELETAR se o ID do item E o ID do usuário corresponderem.
// Isso impede que um usuário delete despesas de outro.
$sql = "DELETE FROM itens WHERE id = :id AND usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        'id' => $item_id,
        'usuario_id' => $usuario_id
    ]);

    // 4. Redireciona para o dashboard com mensagem de sucesso
    header("Location: dashboard.php?sucesso=exclusao");
    exit();

} catch (PDOException $e) {
    // Em caso de erro, pode redirecionar com uma mensagem de erro (opcional)
    // ou simplesmente voltar para o dashboard.
    // die("Erro ao excluir o item: " . $e->getMessage()); // Para depuração
    header("Location: dashboard.php?erro=exclusao");
    exit();
}
?>