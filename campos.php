<?php
session_start();
require_once 'config/database.php';

$stmt = $pdo->query("SELECT * FROM campos");
$campos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Campos</title>
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
        <h2>Campos Disponiveis</h2>
        <table>
            <tr>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Valor/hora</th>
            </tr>
            <?php foreach ($campos as $campo): ?>
                <tr>
                    <td><?= $campo['tipo_campo'] ?></td>
                    <td><?= $campo['estado'] ?></td>
                    <td><?= $campo['valor'] ?>€</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>