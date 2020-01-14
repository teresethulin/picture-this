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
 * Checks for errors in $_SESSION and prints them. Then unsets $_SESSION['error']
 *
 * @return void
 */
function isError()
{
    if (isset($_SESSION['error'])) {
        return true;
    }
    return false;
}

/**
 * Checks for successes in $_SESSION and prints them. Then unsets $_SESSION['success']
 *
 * @return void
 */
function isSuccess()
{
    if (isset($_SESSION['success'])) {
        return true;
    }
    return false;
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
function getPostsByUser(int $userID, PDO $pdo): array
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


/**
 * Get all posts from users
 *
 * @param PDO $pdo
 * @return array
 */
function getAllPosts(PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT post.id, post.user_id, post.caption, post.filename, post.date_created, user.username, user.avatar FROM post JOIN user ON post.user_id = user.id ORDER BY post.date_created DESC');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute();

    $allPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}


/**
 * Check if post is liked by user
 *
 * @param integer $userID
 * @param integer $postID
 * @param PDO $pdo
 * @return boolean
 */
function isLiked(int $userID, int $postID, PDO $pdo): bool
{
    $statement = $pdo->prepare('SELECT * FROM like WHERE user_id = :user_id AND post_id = :post_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        'user_id' => $userID,
        'post_id' => $postID
    ]);

    $isLiked = $statement->fetch(PDO::FETCH_ASSOC);

    if ($isLiked) {
        return true;
    } else {
        return false;
    }
}


/**
 * Get number of likes on post from database
 *
 * @param integer $postID
 * @param PDO $pdo
 * @return string
 */
function numberOfLikes(int $postID, PDO $pdo): string
{
    $statement = $pdo->prepare('SELECT COUNT(user_id) FROM like WHERE post_id = :post_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':post_id' => $postID
    ]);

    $likes = $statement->fetch();

    return $likes['COUNT(user_id)'];
}

/**
 * Checks if user is owner of post
 *
 * @param array $post
 * @return boolean
 */
function isUser($post)
{
    if ($_SESSION['user']['id'] === $post['user_id']) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if id of current post matches post id in database. If true, return post
 *
 * @param array $posts
 * @return void
 */
function getCurrentPost($posts)
{
    $postID = $_GET['id'];
    if (isset($_GET['id'])) {
        foreach ($posts as $post) {
            if ($postID === $post['id']) {
                return $post;
            }
        }
    }
}
