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
        <p>Somos um clube desportivo especializado em ténis e pádel, localizado em Lisboa.</p>
        <p>O nosso objetivo é proporcionar uma experiência de qualidade aos nossos atletas, com campos bem equipados e um sistema de reservas simples e eficiente.</p>

        <h3>O que oferecemos</h3>
        <div class="cards">
            <div class="card">
                <h3>Campos de Qualidade</h3>
                <p>Dispomos de campos de ténis e pádel, cobertos e descobertos, mantidos em excelentes condições.</p>
            </div>
            <div class="card">
                <h3>Reservas Online</h3>
                <p>Sistema de reservas simples e rapido, disponivel 24 horas por dia.</p>
            </div>
            <div class="card">
                <h3>Equipamentos</h3>
                <p>Aluguer de raquetes e bolas para quem precisar, com iluminacao noturna disponivel.</p>
            </div>
        </div>

        <h3>Contactos</h3>
        <p>Email: clube@desportivo.pt</p>
        <p>Telefone: +351 210 000 000</p>
        <p>Morada: Rua do Clube Desportivo, Lisboa</p>
    </div>
</body>

</html>