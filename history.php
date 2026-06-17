<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT r.*, c.tipo_campo FROM reservas r JOIN campos c ON r.id_campo = c.id WHERE r.id_user = ? ORDER BY r.data_hora DESC");
$stmt->execute([$id_user]);
$reservas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Historico</title>
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
        <h2>Historico de Reservas</h2>
        <table>
            <tr>
                <th>Campo</th>
                <th>Data</th>
                <th>Hora Inicio</th>
                <th>Hora Fim</th>
                <th>Estado</th>
                <th>Iluminacao</th>
                <th>Check-in</th>
            </tr>
            <?php foreach ($reservas as $r): ?>
                <tr>
                    <td><?= $r['tipo_campo'] ?></td>
                    <td><?= $r['data_hora'] ?></td>
                    <td><?= $r['hora_inicio'] ?></td>
                    <td><?= $r['hora_fim'] ?></td>
                    <td><?= $r['estado'] ?></td>
                    <td><?= $r['iluminacao'] ? 'Sim' : 'Nao' ?></td>
                    <td><?= $r['check_in'] ? 'Sim' : 'Nao' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>