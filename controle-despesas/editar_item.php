<?php
require 'config/proteger_pagina.php';
require 'config/conexao.php';

$erros = [];
$item_id = $_GET['id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

if (!$item_id) {
    header("Location: dashboard.php");
    exit();
}

// Busca o item e verifica se pertence ao usuário
$sql = "SELECT * FROM itens WHERE id = :id AND usuario_id = :uid";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $item_id, 'uid' => $usuario_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// Se o item não for encontrado ou não pertencer ao usuário, redireciona
if (!$item) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mesma lógica de validação do cadastro
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $valor = trim($_POST['valor']);
    $data_criacao = trim($_POST['data_criacao']);

    if (empty($titulo)) $erros[] = "O título é obrigatório.";
    if (empty($valor)) $erros[] = "O valor é obrigatório.";
    if (empty($data_criacao)) $erros[] = "A data é obrigatória.";

    if (empty($erros)) {
        $valor_db = str_replace(',', '.', str_replace('.', '', $valor));
        $sql = "UPDATE itens SET titulo = :titulo, descricao = :desc, valor = :valor, data_criacao = :data WHERE id = :id AND usuario_id = :uid";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'titulo' => $titulo,
                'desc' => $descricao,
                'valor' => $valor_db,
                'data' => $data_criacao,
                'id' => $item_id,
                'uid' => $usuario_id
            ]);
            header("Location: dashboard.php?sucesso=edicao");
            exit();
        } catch (PDOException $e) {
            $erros[] = "Erro ao atualizar despesa.";
        }
    }
}

?>

<?php include 'includes/header.php'; ?>
<h3>Editar Despesa</h3>

<div class="card">
    <div class="card-body">
         <?php if (!empty($erros)): ?>
            <div class="alert alert-danger">
                <?php foreach ($erros as $erro): ?>
                    <p class="mb-0"><?php echo $erro; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="editar_item.php?id=<?php echo $item['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo htmlspecialchars($item['titulo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor (R$)</label>
                <input type="text" name="valor" id="valor" class="form-control" value="<?php echo number_format($item['valor'], 2, ',', '.'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="data_criacao" class="form-label">Data</label>
                <input type="date" name="data_criacao" id="data_criacao" class="form-control" value="<?php echo $item['data_criacao']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (Opcional)</label>
                <textarea name="descricao" id="descricao" rows="3" class="form-control"><?php echo htmlspecialchars($item['descricao']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>