<?php
require 'config/proteger_pagina.php';
require 'config/conexao.php';

$erros = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $valor = trim($_POST['valor']);
    $data_criacao = trim($_POST['data_criacao']);
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($titulo)) $erros[] = "O título é obrigatório.";
    if (empty($valor)) $erros[] = "O valor é obrigatório.";
    if (empty($data_criacao)) $erros[] = "A data é obrigatória.";

    if (empty($erros)) {
        // Formata o valor para o padrão do MySQL
        $valor_db = str_replace(',', '.', str_replace('.', '', $valor));

        $sql = "INSERT INTO itens (usuario_id, titulo, descricao, valor, data_criacao) VALUES (:uid, :titulo, :desc, :valor, :data)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                'uid' => $usuario_id,
                'titulo' => $titulo,
                'desc' => $descricao,
                'valor' => $valor_db,
                'data' => $data_criacao
            ]);
            header("Location: dashboard.php?sucesso=cadastro");
            exit();
        } catch (PDOException $e) {
            $erros[] = "Erro ao cadastrar despesa.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<h3>Cadastrar Nova Despesa</h3>

<div class="card">
    <div class="card-body">
        <?php if (!empty($erros)): ?>
            <div class="alert alert-danger">
                <?php foreach ($erros as $erro): ?>
                    <p class="mb-0"><?php echo $erro; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="cadastrar_item.php" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor (R$)</label>
                <input type="text" name="valor" id="valor" class="form-control" required placeholder="Ex: 1.250,50">
            </div>
            <div class="mb-3">
                <label for="data_criacao" class="form-label">Data</label>
                <input type="date" name="data_criacao" id="data_criacao" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (Opcional)</label>
                <textarea name="descricao" id="descricao" rows="3" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Despesa</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>