<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sobre Nos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">Inicio</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="reservas.php">Reservas</a>
            <a href="campos.php">Campos</a>
            <a href="payments.php">Pagamentos</a>
            <a href="history.php">Historico</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Registar</a>
        <?php endif; ?>
        <a href="about.php">Sobre nos</a>
    </nav>
    <div class="container">
        <h2>Sobre Nos</h2>
        <p>Somos um clube desportivo especializado em ténis e pádel.</p>
        <p>Oferecemos campos de qualidade e reservas online para os nossos atletas.</p>
    </div>
</body>
</html>
