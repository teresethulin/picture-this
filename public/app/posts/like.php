<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
