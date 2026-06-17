<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 'gestor' && $_SESSION['user_role'] != 'rececionista')) {
    header('Location: ../login.php');
    exit;
}

$role = $_SESSION['user_role'];
$atletas = $pdo->query("SELECT * FROM users WHERE role = 'atleta'")->fetchAll();
$reservas = $pdo->query("SELECT r.*, c.tipo_campo, u.nome FROM reservas r JOIN campos c ON r.id_campo = c.id JOIN users u ON r.id_user = u.id ORDER BY r.data_hora DESC")->fetchAll();
$pagamentos = $pdo->query("SELECT p.*, u.nome as atleta_nome, o.nome as operador_nome FROM pagamentos p JOIN users u ON p.id_user = u.id LEFT JOIN users o ON p.operador = o.id ORDER BY p.data DESC")->fetchAll();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_campo']) && $role == 'gestor') {
        $tipo = $_POST['tipo_campo'];
        $estado = $_POST['estado'];
        $valor = $_POST['valor'];
        $stmt = $pdo->prepare("INSERT INTO campos (tipo_campo, estado, valor) VALUES (?, ?, ?)");
        $stmt->execute([$tipo, $estado, $valor]);
        header('Location: dashboard.php');
        exit;
    }

    if (isset($_POST['checkin'])) {
        $id_reserva = $_POST['id_reserva'];
        $stmt = $pdo->prepare("UPDATE reservas SET check_in = 1 WHERE id = ?");
        $stmt->execute([$id_reserva]);
        header('Location: dashboard.php');
        exit;
    }

    if (isset($_POST['inativar_atleta'])) {
        $id_user = $_POST['id_user'];
        $stmt = $pdo->prepare("UPDATE users SET estado = 'inativo' WHERE id = ?");
        $stmt->execute([$id_user]);
        header('Location: dashboard.php');
        exit;
    }

    if (isset($_POST['cancelar_reserva'])) {
        $id_reserva = $_POST['id_reserva'];
        $stmt = $pdo->prepare("UPDATE reservas SET estado = 'cancelada' WHERE id = ?");
        $stmt->execute([$id_reserva]);
        header('Location: dashboard.php');
        exit;
    }

    if (isset($_POST['registar_pagamento'])) {
        $id_reserva = $_POST['id_reserva'];
        $montante = $_POST['montante'];
        $tipo = $_POST['tipo'];
        $data = date('Y-m-d');
        $operador = $_SESSION['user_id'];
        $stmt_r = $pdo->prepare("SELECT id_user FROM reservas WHERE id = ?");
        $stmt_r->execute([$id_reserva]);
        $reserva = $stmt_r->fetch();
        $id_user = $reserva['id_user'];
        try {
            $stmt = $pdo->prepare("INSERT INTO pagamentos (id_reserva, id_user, data, montante, tipo, operador) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$id_reserva, $id_user, $data, $montante, $tipo, $operador]);
            $sucesso = 'Pagamento registado com sucesso!';
        } catch (PDOException $e) {
            $erro = 'Erro ao registar pagamento.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <?php if ($role == 'gestor'): ?>
        <a href="stats.php">Estatisticas</a>
        <?php endif; ?>
        <a href="../logout.php">Sair</a>
    </nav>
    <div class="container">
        <h2>Painel de Administracao</h2>

        <?php if ($role == 'gestor'): ?>
        <h3>Adicionar Campo</h3>
        <form method="POST">
            <input type="text" name="tipo_campo" placeholder="Tipo de campo" required>
            <select name="estado">
                <option value="disponivel">Disponivel</option>
                <option value="manutencao">Manutencao</option>
            </select>
            <input type="number" name="valor" placeholder="Valor/hora (€)" step="0.01" required>
            <button type="submit" name="add_campo">Adicionar Campo</button>
        </form>
        <?php endif; ?>

        <h3>Registar Pagamento</h3>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <?php if ($sucesso): ?><p class="sucesso"><?= $sucesso ?></p><?php endif; ?>
        <form method="POST">
            <select name="id_reserva" required>
                <option value="">Escolha uma reserva</option>
                <?php foreach ($reservas as $r): if ($r['estado'] == 'ativa'): ?>
                <option value="<?= $r['id'] ?>"><?= $r['nome'] ?> - <?= $r['tipo_campo'] ?> - <?= $r['data_hora'] ?></option>
                <?php endif; endforeach; ?>
            </select>
            <input type="number" name="montante" placeholder="Montante (€)" step="0.01" required>
            <select name="tipo">
                <option value="total">Total</option>
                <option value="parcial">Parcial</option>
            </select>
            <button type="submit" name="registar_pagamento">Registar Pagamento</button>
        </form>

        <h3>Atletas</h3>
        <table>
            <tr><th>Nome</th><th>Email</th><th>Estado</th><th>Acao</th></tr>
            <?php foreach ($atletas as $a): ?>
            <tr>
                <td><?= $a['nome'] ?></td>
                <td><?= $a['email'] ?></td>
                <td><?= $a['estado'] ?></td>
                <td>
                    <?php if ($a['estado'] == 'ativo'): ?>
                    <form method="POST">
                        <input type="hidden" name="id_user" value="<?= $a['id'] ?>">
                        <button type="submit" name="inativar_atleta">Inativar</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Reservas</h3>
        <table>
            <tr><th>Atleta</th><th>Campo</th><th>Data</th><th>Estado</th><th>Check-in</th><th>Acao</th></tr>
            <?php foreach ($reservas as $r): ?>
            <tr>
                <td><?= $r['nome'] ?></td>
                <td><?= $r['tipo_campo'] ?></td>
                <td><?= $r['data_hora'] ?></td>
                <td><?= $r['estado'] ?></td>
                <td><?= $r['check_in'] ? 'Sim' : 'Nao' ?></td>
                <td>
                    <?php if ($r['estado'] == 'ativa' && !$r['check_in']): ?>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_reserva" value="<?= $r['id'] ?>">
                        <button type="submit" name="checkin">Check-in</button>
                    </form>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="id_reserva" value="<?= $r['id'] ?>">
                        <button type="submit" name="cancelar_reserva">Cancelar</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Pagamentos</h3>
        <table>
            <tr><th>Atleta</th><th>Montante</th><th>Tipo</th><th>Data</th><th>Operador</th></tr>
            <?php foreach ($pagamentos as $p): ?>
            <tr>
                <td><?= $p['atleta_nome'] ?></td>
                <td><?= $p['montante'] ?>€</td>
                <td><?= $p['tipo'] ?></td>
                <td><?= $p['data'] ?></td>
                <td><?= $p['operador_nome'] ?? 'Atleta' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
