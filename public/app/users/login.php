<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// Check if both username and password exists in the POST request.
if (isset($_POST['username'], $_POST['password'])) {
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));

    // Prepare, bind parameter and execute the database query.
    $statement = $pdo->prepare('SELECT * FROM user WHERE username = :username');

    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // If we couldn't find the user in the database, redirect back to the login page
    if (!$user) {
        redirect('/login.php');
    }

    // If we found the user in the database, compare the given password from the
    // request with the one in the database using the password_verify function.
    if (password_verify($_POST['password'], $user['password'])) {
        // If the password was valid we know that the user exists and provided
        // the correct password. We can now save the user in our session.
        unset($user['password']);

        $_SESSION['user'] = $user;
        echo 'logged in';
    }
}

redirect('/');
