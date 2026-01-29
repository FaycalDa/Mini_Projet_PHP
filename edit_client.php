<?php
    declare(strict_types=1);

    require_once __DIR__ . '/src/auth.php';
    requireLogin();

    require_once __DIR__ .'/src/database.php';

    $pdo = getPdo();

    $id = (int)($_GET['id'] ?? 0);
    if($id <= 0){
        header('Location: clients.php');
        exit;
    }
    $error = null;

    $bdd_clients = $pdo->prepare("SELECT id, nom, email, telephone FROM clients WHERE id = :id");
    $bdd_clients->execute([':id' => $id]);
    $client = $bdd_clients->fetch();

    if(!$client) {
        echo " Pas de client trouver";
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $name = trim($_POST["name"] ?? '');
        $email = trim($_POST["email"] ?? '');
        $phone = trim($_POST["telephone"] ?? '');

        if($name === '' || $email === ''){
            $error = "Nom et email sont obligatoires";
        }
        elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $error = "Email invalide";
        }
        else{
            $maj = $pdo->prepare("UPDATE clients SET nom = :name, email = :email, telephone = :phone WHERE id = :id");
            $maj->execute([':name' => $name,':email' => $email,':phone' => $phone !== '' ? $phone : null, ':id' => $id]);

            header('Location: clients.php');
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier un client</title>
</head>
<body>
    <h1>Modifier un client</h1>
    <p><a href="clients.php">← Retour</a></p>

    <?php if($error): ?>
        <p> <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <form method="post">
        <div>
            <label>Nom :</label><br>
            <input type="text" name="name" required value="<?= htmlspecialchars($client['nom']) ?>">
        </div>
    <br>
        <div>
            <label>Email *</label><br>
            <input type="email" name="email" required value="<?= htmlspecialchars($client['email']) ?>">
        </div>
    <br>
        <div>
            <label>Téléphone</label><br>
            <input type="text" name="telephone" value="<?= htmlspecialchars((string)$client['telephone']) ?>">
        </div>
    <br>
    <button type="submit">Enregistrer</button>
    </form>
</body>
</html>