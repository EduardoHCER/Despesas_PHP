<?php
session_start();
require 'config/conexao.php';

// Se o usuário já estiver logado, redireciona
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    if (empty($login) || empty($senha)) {
        $erro = "Login e senha são obrigatórios.";
    } else {
        // Busca o usuário no banco
        $sql = "SELECT id, senha FROM usuarios WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido, armazena na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_login'] = $login;
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Login ou senha inválidos.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['sucesso'])): ?>
                    <div class="alert alert-success">Usuário cadastrado com sucesso! Faça o login.</div>
                <?php endif; ?>
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 'acesso_negado'): ?>
                    <div class="alert alert-warning">Você precisa fazer login para acessar essa página.</div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="login" class="form-label">Login</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="cadastro_usuario.php">Não tem uma conta? Cadastre-se</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>