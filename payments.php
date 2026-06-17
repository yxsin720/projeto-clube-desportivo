<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['user_id'];
$erro = '';
$sucesso = '';

$stmt = $pdo->prepare("SELECT r.id, c.tipo_campo, r.data_hora FROM reservas r JOIN campos c ON r.id_campo = c.id WHERE r.id_user = ? AND r.estado = 'ativa'");
$stmt->execute([$id_user]);
$reservas = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reserva = $_POST['id_reserva'];
    $montante = $_POST['montante'];
    $tipo = $_POST['tipo'];
    $data = date('Y-m-d');
    try {
        $stmt = $pdo->prepare("INSERT INTO pagamentos (id_reserva, id_user, data, montante, tipo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_reserva, $id_user, $data, $montante, $tipo]);
        $sucesso = 'Pagamento registado com sucesso!';
    } catch (PDOException $e) {
        $erro = 'Erro ao registar pagamento.';
    }
}

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
        <h2>Pagamentos</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <?php if ($sucesso): ?><p class="sucesso"><?= $sucesso ?></p><?php endif; ?>

        <form method="POST">
            <select name="id_reserva" required>
                <option value="">Escolha uma reserva</option>
                <?php foreach ($reservas as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['tipo_campo'] ?> - <?= $r['data_hora'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="montante" placeholder="Montante (€)" step="0.01" required>
            <select name="tipo">
                <option value="total">Total</option>
                <option value="parcial">Parcial</option>
            </select>
            <button type="submit">Pagar</button>
        </form>

        <h3>Os meus pagamentos</h3>
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