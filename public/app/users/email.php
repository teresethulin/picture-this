<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// Display messages
$errors = [];
$successes = [];


// UPDATE USER EMAIL
if (isset($_POST['email'])) {
    $newEmail = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please fill in a valid email.';
    }

    // If errors, display error message and redirect user
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/edit-profile.php');
        exit;
    }

    // Send query to database

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

    // Display confirmation
    $successes[] = "Email updated.";

    if (count($successes) > 0) {
        $_SESSION['successes'] = $successes;
        redirect('/edit-profile.php');
        exit;
    }
}
