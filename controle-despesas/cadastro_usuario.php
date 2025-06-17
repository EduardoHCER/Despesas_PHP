<?php
require 'config/conexao.php';
$erros = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $confirmar_senha = trim($_POST['confirmar_senha']);

    // Validações
    if (empty($login)) $erros[] = "O campo login é obrigatório.";
    if (empty($email)) $erros[] = "O campo e-mail é obrigatório.";
    if (empty($senha)) $erros[] = "O campo senha é obrigatório.";
    if ($senha !== $confirmar_senha) $erros[] = "As senhas não coincidem.";

    // Se não houver erros de validação, verifica se já existe
    if (empty($erros)) {
        // Verifica login
        $sql = "SELECT id FROM usuarios WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        if ($stmt->fetch()) {
            $erros[] = "Este login já está em uso.";
        }

        // Verifica e-mail
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $erros[] = "Este e-mail já está cadastrado.";
        }
    }

    // Se ainda não houver erros, insere no banco
    if (empty($erros)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (login, email, senha) VALUES (:login, :email, :senha)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'login' => $login,
                'email' => $email,
                'senha' => $senha_hash
            ]);
            header("Location: login.php?sucesso=cadastro");
            exit();
        } catch (PDOException $e) {
            $erros[] = "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow sm">
            <div class="card-header">
                <h3>Cadastro de Usuário</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($erros)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($erros as $erro): ?>
                            <p class="mb-0"><?php echo $erro; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="cadastro_usuario.php" method="POST">
                    <div class="mb-3">
                        <label for="login" class="form-label">Login</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
             <div class="card-footer text-center">
                <a href="login.php">Já tem uma conta? Faça login</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>