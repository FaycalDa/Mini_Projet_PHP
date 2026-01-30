<?php
    declare(strict_types=1);

    require_once __DIR__ . '/src/auth.php';
    requireLogin();
    require_once __DIR__ . '/src/database.php';

    $pdo = getPdo();

    $id= (int)($_GET["id"] ?? 0 );

    if($id <= 0){
        header('Location: clients.php');
        exit;
    }

    $log= $pdo->prepare("DELETE FROM clients WHERE id = :id");
    $log->execute([":id" => $id]);

    header('Location: clients.php');
    exit;

?>