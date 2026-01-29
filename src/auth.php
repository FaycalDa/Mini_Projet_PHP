<?php
    declare(strict_types=1);

    session_start();

    function requireLogin(): void
    {
        if(!isset($_SESSION['user_id'])){
            header('Location: login.php');
            exit;
        }
    }
?>