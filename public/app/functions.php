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
 * @param int $userID
 * @param PDO $pdo
 * @return array
 */
function getUserById(int $userID, PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT * FROM user WHERE id = :user_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $userID
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return $user;
    }
}


/**
 * Get posts from user
 *
 * @param int $userID
 * @param PDO $pdo
 * @return array
 */
function getAllPostsByUser(int $userID, PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT * FROM post WHERE user_id = :user_id ORDER BY date_created DESC');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $userID
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

/**
 * Get post by ID from database
 *
 * @param integer $postID
 * @param PDO $pdo
 * @return array
 */
function getPostByID(int $postID, PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT * FROM post WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $postID
    ]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    return $post;
}
