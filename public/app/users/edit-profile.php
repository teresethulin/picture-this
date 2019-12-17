<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

$userID = $_SESSION['user']['id'];

if (isset($_POST['email'])) {
    $newEmail = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $errors = [];

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please fill in a valid email.';
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('profile.php');
        exit;
    }

    getUserById($userID, $pdo);

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

    echo "Email updated.";
}
