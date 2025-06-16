<?php
require 'config/proteger_pagina.php'; 
require 'config/conexao.php';

$usuario_id = $_SESSION['usuario_id'];

// Busca os itens do usuário logado
$sql = "SELECT id, titulo, descricao, valor, DATE_FORMAT(data_criacao, '%d/%m/%Y') as data_formatada FROM itens WHERE usuario_id = :usuario_id ORDER BY data_criacao DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'includes/header.php'; ?>

<h3>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_login']); ?>!</h3>
<p>Aqui estão suas despesas cadastradas.</p>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'cadastro'): ?>
    <div class="alert alert-success">Despesa cadastrada com sucesso!</div>
<?php endif; ?>
<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'edicao'): ?>
    <div class="alert alert-success">Despesa atualizada com sucesso!</div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Minhas Despesas</h4>
        <a href="cadastrar_item.php" class="btn btn-primary">Adicionar Nova Despesa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Valor (R$)</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($itens) > 0): ?>
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['titulo']); ?></td>
                                <td><?php echo number_format($item['valor'], 2, ',', '.'); ?></td>
                                <td><?php echo $item['data_formatada']; ?></td>
                                <td>
                                    <a href="editar_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma despesa cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>