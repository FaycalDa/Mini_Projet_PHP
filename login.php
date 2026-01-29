<?php
    declare(strict_types=1);

    session_start();

    require_once __DIR__ . '/src/database.php';

    $pdo = getPdo();
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
    
        if($email === '' || $password === ''){
            $error = "Email et mot de passe obligatoire.";
            }
        
        else{
            $bdd_users = $pdo->prepare("SELECT id, email, password_hash FROM users WHERE email = :email");
            $bdd_users->execute([':email' => $email]);
            $user = $bdd_users->fetch();
        
            if(!$user){
            $error = "Identifiants invalides.";
            }

            elseif(!password_verify($password, $user['password_hash'])){
                $error = "Mot de passe invalides";
            }
            
            else{
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: clients.php');
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if($error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <br>
    <form method="post">
        <div>
            <label>E-mail:</label><br>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <label>Mot de passe:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>