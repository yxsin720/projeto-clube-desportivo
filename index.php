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
    <div class="hero">
        <h1>Bem-vindo ao Clube Desportivo</h1>
        <p>Reserve o seu campo de ténis ou pádel de forma rápida e simples.</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php"><button>Registar</button></a>
            <a href="login.php"><button>Login</button></a>
        <?php else: ?>
            <p>Bem-vindo, <?= $_SESSION['user_nome'] ?>!</p>
            <a href="reservas.php"><button>Fazer Reserva</button></a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="cards">
            <div class="card">
                <h3>Tenis</h3>
                <p>Campos de terra batida e piso rapido disponiveis para reserva.</p>
            </div>
            <div class="card">
                <h3>Padel</h3>
                <p>Campos cobertos e descobertos para todos os niveis.</p>
            </div>
            <div class="card">
                <h3>Equipamentos</h3>
                <p>Aluguer de raquetes e bolas disponivel em todos os campos.</p>
            </div>
        </div>
    </div>
</body>

</html>