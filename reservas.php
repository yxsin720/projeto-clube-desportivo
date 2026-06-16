<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$erro = '';
$sucesso = '';

$stmt = $pdo->query("SELECT * FROM campos WHERE estado = 'disponivel'");
$campos = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_campo = $_POST['id_campo'];
    $data_hora = $_POST['data_hora'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $id_user = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO reservas (id_campo, id_user, data_hora, hora_inicio, hora_fim) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_campo, $id_user, $data_hora, $hora_inicio, $hora_fim]);
        $sucesso = 'Reserva efetuada com sucesso!';
    } catch(PDOException $e) {
        $erro = 'Erro ao efetuar reserva.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Reservas</title>
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
        <h2>Efetuar Reserva</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <?php if ($sucesso): ?><p class="sucesso"><?= $sucesso ?></p><?php endif; ?>
        <form method="POST">
            <select name="id_campo" required>
                <option value="">Escolha um campo</option>
                <?php foreach ($campos as $campo): ?>
                <option value="<?= $campo['id'] ?>"><?= $campo['tipo_campo'] ?> - <?= $campo['valor'] ?>€/hora</option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="data_hora" required>
            <input type="time" name="hora_inicio" required>
            <input type="time" name="hora_fim" required>
            <button type="submit">Reservar</button>
        </form>
    </div>
</body>
</html>
