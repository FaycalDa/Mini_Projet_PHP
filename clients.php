<?php
    declare(strict_types=1);

    require_once __DIR__ . '/src/auth.php';
    requireLogin();

    require_once __DIR__ . '/src/database.php';

    $pdo = getPdo(); 
    $bdd_clients = $pdo->query("SELECT id, nom, email, telephone FROM clients ORDER BY id ASC"); //On récupére les clients présents dans la bdd hotel_name, table client.

    $clients = $bdd_clients->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <p><a href="add_client.php">+ Ajouter un client</a></p>
    <p>
      Connecté en tant que <?= htmlspecialchars($_SESSION['user_email'] ?? ''); ?>— <a href="logout.php">Déconnexion</a>
    </p>
    <h1>Clients</h1>
    <?php if (count($clients) === 0): ?>
    <p>Aucun client.</p>
  <?php else: ?>
    <table border="1" cellpadding="6">
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Actions</th>
      </tr>

      <?php foreach ($clients as $c): ?>
        <tr>
          <td><?= (int)$c['id'] ?></td>
          <td><?= htmlspecialchars($c['nom']) ?></td>
          <td><?= htmlspecialchars($c['email']) ?></td>
          <td><?= htmlspecialchars((string)$c['telephone']) ?></td>
          <td><a href="edit_client.php?id=<?= (int)$c['id']?>">Modifier</td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>


</body>
</html>

    

