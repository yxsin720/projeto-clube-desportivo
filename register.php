<?php
session_start();
require_once 'config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (nome, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $password]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $erro = 'Email já registado.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Registar</title>
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
        <h2>Registar</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Registar</button>
        </form>
    </div>
</body>

</html>