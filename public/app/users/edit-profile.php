<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}


$userID = $_SESSION['user']['id'];


// UPDATE USER EMAIL
if (isset($_POST['email'])) {
    $newEmail = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $errors = [];
    $successes = [];

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please fill in a valid email.';
    }

    // If errors, display error message and redirect user
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('profile.php');
        exit;
    }

    // Get user data, then send query to database
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

    // Display confirmation
    $successes[] = "Email updated.";

    if (count($successes) > 0) {
        $_SESSION['successes'] = $successes;
        redirect('profile.php');
        exit;
    }
}


// UPDATE USER PASSWORD
if (isset($_POST['password'], $_POST['new-password'])) {
    $password = $_POST['password'];
    $errors = [];
    $successes = [];

    // Get user data
    $user = getUserById($userID, $pdo);

    // Verify entered password
    if (!password_verify($password, $user['password'])) {

        $errors[] = 'Please fill in a valid password.';
    }

    // If errors, display error message and redirect user
    if (count($errors) > 0) {

        $_SESSION['errors'] = $errors;
        redirect('profile.php');
        exit;
    }

    // Encrypt and hash the new password
    $newPassword = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

    // Send query to database and bind parameters
    $query = 'UPDATE user SET password = :password WHERE id = :userid';
    $statement = $pdo->prepare($query);

    if (!$statement) {

        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':password', $newPassword, PDO::PARAM_STR);
    $statement->execute([
        ':password' => $newPassword,
        ':userid' => $userID,
    ]);

    // Display confirmation
    $successes[] = "Password changed.";

    if (count($successes) > 0) {

        $_SESSION['successes'] = $successes;
        redirect('profile.php');
        exit;
    }
}
