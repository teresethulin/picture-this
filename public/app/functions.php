<?php

declare(strict_types=1);


if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}


function newUser()
{
    $config = require __DIR__ . '/config.php';
    $pdo = new PDO($config['database_path']);

    // Fetch all users
    $statement = $pdo->query('SELECT * FROM user');
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['username'], $_POST['full-name'], $_POST['email'], $_POST['password'])) {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $fullName = filter_var($_POST['full-name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $dateCreated = date("Y-m-d H:i:s");

        $query = "INSERT INTO picture_this (username, full_name, email, password, date_created) VALUES ('$username', '$fullName', '$email', '$password', '$dateCreated')";

        $statement = $pdo->prepare($query);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':full-name', $fullName, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':date', $dateCreated, PDO::PARAM_INT);

        $statement->execute();
    }
}
