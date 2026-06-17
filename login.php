<?php
session_start();
require_once 'config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_role'] = $user['role'];

        if ($user['role'] == 'gestor' || $user['role'] == 'rececionista') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $erro = 'Email ou password incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="login.php">Login</a>
        <a href="register.php">Registar</a>
        <a href="about.php">Sobre nos</a>
    </nav>
    <div class="container">
        <h2>Login</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>

</html>