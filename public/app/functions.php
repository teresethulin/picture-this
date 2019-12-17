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

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

// function getUserById()
// {
//     $username = $_SESSION['user']['username'];
//     $statement = $pdo->prepare('SELECT id FROM user WHERE username = :username');

//     $statement->bindParam(':username', $username, PDO::PARAM_STR);
//     $statement->execute();

//     // Fetch the user as an associative array.
//     $user = $statement->fetch(PDO::FETCH_ASSOC);
//     return $user;
// }
