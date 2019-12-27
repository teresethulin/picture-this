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


// UPDATE USER PASSWORD
if (isset($_POST['password'], $_POST['new-password'])) {
    $password = $_POST['password'];

    // Verify entered password
    if (!password_verify($password, $user['password'])) {

        $errors[] = 'Please fill in a valid password.';
    }

    // If errors, display error message and redirect user
    if (count($errors) > 0) {

        $_SESSION['errors'] = $errors;
        redirect('/edit-profile.php');
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
        redirect('/edit-profile.php');
        exit;
    }
}
