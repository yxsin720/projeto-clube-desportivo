<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$erro = '';
$sucesso = '';
$id_user = $_SESSION['user_id'];

$stmt = $pdo->query("SELECT * FROM campos WHERE estado = 'disponivel'");
$campos = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservar'])) {
    $id_campo = $_POST['id_campo'];
    $data_hora = $_POST['data_hora'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $iluminacao = isset($_POST['iluminacao']) ? 1 : 0;
    $aluguer_material = isset($_POST['aluguer_material']) ? 1 : 0;

    $verificar = $pdo->prepare("SELECT * FROM reservas WHERE id_campo = ? AND data_hora = ? AND estado = 'ativa' AND ((hora_inicio < ? AND hora_fim > ?) OR (hora_inicio < ? AND hora_fim > ?))");
    $verificar->execute([$id_campo, $data_hora, $hora_fim, $hora_inicio, $hora_fim, $hora_inicio]);

    if ($verificar->rowCount() > 0) {
        $erro = 'Campo ja reservado nesse horario.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO reservas (id_campo, id_user, data_hora, hora_inicio, hora_fim, iluminacao, aluguer_material) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_campo, $id_user, $data_hora, $hora_inicio, $hora_fim, $iluminacao, $aluguer_material]);
        $sucesso = 'Reserva efetuada com sucesso!';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancelar'])) {
    $id_reserva = $_POST['id_reserva'];

    $reserva = $pdo->prepare("SELECT * FROM reservas WHERE id = ? AND id_user = ?");
    $reserva->execute([$id_reserva, $id_user]);
    $reserva = $reserva->fetch();

    if ($reserva) {
        $data_reserva = $reserva['data_hora'] . ' ' . $reserva['hora_inicio'];
        $diferenca = strtotime($data_reserva) - time();

        if ($diferenca > 86400) {
            $stmt = $pdo->prepare("UPDATE reservas SET estado = 'cancelada' WHERE id = ?");
            $stmt->execute([$id_reserva]);
            $sucesso = 'Reserva cancelada com sucesso!';
        } else {
            $erro = 'Nao pode cancelar com menos de 24 horas de antecedencia.';
        }
    }
}

$minhas_reservas = $pdo->prepare("SELECT r.*, c.tipo_campo FROM reservas r JOIN campos c ON r.id_campo = c.id WHERE r.id_user = ? ORDER BY r.data_hora DESC");
$minhas_reservas->execute([$id_user]);
$minhas_reservas = $minhas_reservas->fetchAll();
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
            <label><input type="checkbox" name="iluminacao"> Iluminacao noturna</label>
            <label><input type="checkbox" name="aluguer_material"> Aluguer de material</label>
            <button type="submit" name="reservar">Reservar</button>
        </form>

        <h2>As minhas reservas</h2>
        <p class="aviso">Pode editar ou cancelar ate 24 horas antes do inicio do jogo.</p>
        <table>
            <tr>
                <th>Campo</th>
                <th>Data</th>
                <th>Hora Inicio</th>
                <th>Hora Fim</th>
                <th>Estado</th>
                <th>Acao</th>
            </tr>
            <?php foreach ($minhas_reservas as $r): ?>
                <tr>
                    <td><?= $r['tipo_campo'] ?></td>
                    <td><?= $r['data_hora'] ?></td>
                    <td><?= $r['hora_inicio'] ?></td>
                    <td><?= $r['hora_fim'] ?></td>
                    <td><?= $r['estado'] ?></td>
                    <td>
                        <?php if ($r['estado'] == 'ativa' && (strtotime($r['data_hora'] . ' ' . $r['hora_inicio']) - time()) > 86400): ?>
                            <form method="POST">
                                <input type="hidden" name="id_reserva" value="<?= $r['id'] ?>">
                                <button type="submit" name="cancelar">Cancelar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>