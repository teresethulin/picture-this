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

/**
 * Determine if a user is logged in
 *
 * @return boolean
 */
function isLoggedIn()
{
    return isset($_SESSION['user']);
}


/**
 * Get user data by id
 *
 * @param string $userID
 * @param PDO $pdo
 * @return array
 */
function getUserById(string $userID, PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT * FROM user WHERE id = :userid');

    $statement->bindParam(':userid', $userID, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        return $user;
    }
    return $user = [];
}
