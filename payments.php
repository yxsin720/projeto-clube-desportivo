<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['user_id'];

$meus_pagamentos = $pdo->prepare("SELECT p.*, c.tipo_campo, r.data_hora FROM pagamentos p JOIN reservas r ON p.id_reserva = r.id JOIN campos c ON r.id_campo = c.id WHERE p.id_user = ? ORDER BY p.data DESC");
$meus_pagamentos->execute([$id_user]);
$meus_pagamentos = $meus_pagamentos->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pagamentos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="reservas.php">Reservas</a>
        <a href="campos.php">Campos</a>
        <a href="payments.php">Pagamentos</a>
        <a href="history.php">Historico</a>
        <a href="logout.php">Logout</a>
        <a href="about.php">Sobre nos</a>
    </nav>
    <div class="container">
        <h2>Os meus pagamentos</h2>
        <table>
            <tr>
                <th>Campo</th>
                <th>Data</th>
                <th>Montante</th>
                <th>Tipo</th>
            </tr>
            <?php foreach ($meus_pagamentos as $p): ?>
            <tr>
                <td><?= $p['tipo_campo'] ?></td>
                <td><?= $p['data'] ?></td>
                <td><?= $p['montante'] ?>€</td>
                <td><?= $p['tipo'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
