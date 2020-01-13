<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// UPDATE USER EMAIL
if (isset($_POST['email'])) {
    $newEmail = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please fill in a valid email.';
        redirect('/edit-profile.php');
    }

    $query = 'UPDATE user SET email = :new_email WHERE id = :userid';
    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute([
        ':new_email' => $newEmail,
        ':userid' => $userID,
    ]);

    $_SESSION['user']['email'] = $newEmail;

    $_SESSION['success'] = "Email updated.";

    redirect('/edit-profile.php');
}
