<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$ocupacao = $pdo->query("SELECT data_hora, COUNT(*) as total FROM reservas GROUP BY data_hora")->fetchAll();

$estado_reservas = $pdo->query("SELECT estado, COUNT(*) as total FROM reservas GROUP BY estado")->fetchAll();

$receita = $pdo->query("SELECT c.tipo_campo, SUM(p.montante) as total FROM pagamentos p JOIN reservas r ON p.id_reserva = r.id JOIN campos c ON r.id_campo = c.id GROUP BY c.tipo_campo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Estatisticas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav>
    <a href="../index.php">Inicio</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="stats.php">Estatisticas</a>
    <a href="../logout.php">Sair</a>
</nav>

<h1>Estatisticas</h1>

<h2>Ocupacao por Dia</h2>
<table>
    <tr>
        <th>Data</th>
        <th>Total Reservas</th>
    </tr>
    <?php foreach ($ocupacao as $linha): ?>
    <tr>
        <td><?php echo $linha['data_hora']; ?></td>
        <td><?php echo $linha['total']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Estado das Reservas</h2>
<table>
    <tr>
        <th>Estado</th>
        <th>Total</th>
    </tr>
    <?php foreach ($estado_reservas as $linha): ?>
    <tr>
        <td><?php echo $linha['estado']; ?></td>
        <td><?php echo $linha['total']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Receita por Tipo de Campo</h2>
<table>
    <tr>
        <th>Tipo de Campo</th>
        <th>Total Faturado</th>
    </tr>
    <?php foreach ($receita as $linha): ?>
    <tr>
        <td><?php echo $linha['tipo_campo']; ?></td>
        <td><?php echo $linha['total']; ?> €</td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
