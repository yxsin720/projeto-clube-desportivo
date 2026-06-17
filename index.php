<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Clube Desportivo</title>
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
        <h1>Bem-vindo ao Clube Desportivo</h1>
        <p>Reserve o seu campo de ténis ou pádel online.</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php"><button>Registar</button></a>
            <a href="login.php"><button>Login</button></a>
        <?php else: ?>
            <a href="reservas.php"><button>Fazer Reserva</button></a>
        <?php endif; ?>
    </div>
</body>

</html>