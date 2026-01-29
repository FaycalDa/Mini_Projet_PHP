<?php 
    declare(strict_types=1);

    require_once __DIR__ . '/src/auth.php';
    requireLogin();
    
    require_once __DIR__ . '/src/database.php';

    $pdo = getPdo();

    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $name = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if($name === '' || $email === ''){

            $error = "Nom et Email sont obligatoires.";
        }
        else{

            $log = $pdo->prepare("INSERT INTO clients (nom, email, telephone) VALUES (:nom, :email, :phone)");
            $log->execute([':nom' => $name,':email' => $email,':phone' =>$phone != '' ? $phone : null]);

            header('Location: clients.php');
            exit;
        
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un client</title>
</head>
<body>
    <h1>Ajouter un client</h1>
    <p><a href="clients.php"> Retour a la liste de clients</a></p>

    <?php if($error): ?>
        <p> style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label>Nom :</label><br>
            <input type="text" name="nom" required>
        </div>
        <br>
        <div>
            <label>Email :</label><br>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <label>Téléphone :</label><br>
            <input type="text" name="phone">
        </div>
        <br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>