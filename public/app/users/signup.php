<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['username'], $_POST['full_name'], $_POST['email'], $_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $fullName = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please fill in a valid email.';
    }

    $statement = $pdo->prepare('SELECT email FROM user WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $emailExists = $statement->fetch(PDO::FETCH_ASSOC);

    if ($emailExists) {
        $errors[] = "There's already a registered user with this email.";
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/signup.php');
        exit;
    }

    $query = "INSERT INTO user (username, full_name, email, password, date_created) VALUES (:username, :full_name, :email, :password, date('now'))";

    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':full_name', $fullName, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);

    $statement->execute();

    // Log in the user after signing up
    $statement = $pdo->prepare('SELECT * FROM user WHERE username = :username');
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;

    redirect('/index.php');
}
