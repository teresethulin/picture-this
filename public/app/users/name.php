<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// UPDATE USER FULL NAME
if (isset($_POST['full_name'])) {

    $fullName = trim(filter_var($_POST['full_name'], FILTER_SANITIZE_STRING));

    $query = 'UPDATE user SET full_name = :name WHERE id = :userid';
    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':name', $fullName, PDO::PARAM_STR);
    $statement->execute([
        ':name' => $fullName,
        ':userid' => $userID,
    ]);

    $_SESSION['user']['full_name'] = $fullName;

    $_SESSION['success'] = "Name updated.";

    // redirect('/edit-profile.php');
}
