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
        <div class="cards">
            <?php foreach ($campos as $campo): ?>
                <div class="card <?= $campo['estado'] == 'manutencao' ? 'card-indisponivel' : '' ?>">
                    <h3><?= $campo['tipo_campo'] ?></h3>
                    <p><?= $campo['descricao'] ?></p>
                    <p><strong>Estado:</strong>
                        <?php if ($campo['estado'] == 'disponivel'): ?>
                            <span class="badge-disponivel">Disponivel</span>
                        <?php else: ?>
                            <span class="badge-indisponivel">Indisponivel</span>
                        <?php endif; ?>
                    </p>
                    <p><strong>Valor/hora:</strong> <?= $campo['valor'] ?>€</p>
                    <p><strong>Iluminacao noturna:</strong> <?= $campo['custo_iluminacao'] ?>€</p>
                    <p><strong>Aluguer de material:</strong> <?= $campo['custo_aluguer_material'] ?>€</p>
                    <?php if ($campo['estado'] == 'disponivel' && isset($_SESSION['user_id'])): ?>
                        <a href="reservas.php"><button>Reservar</button></a>
                    <?php elseif ($campo['estado'] == 'manutencao'): ?>
                        <button disabled>Indisponivel</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>