<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

if (isset($_POST['id'])) {
    $postID = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    if (isLiked((int) $userID, (int) $postID, $pdo)) {

        // If post is already liked and then unliked by user, delete like from database
        $statement = $pdo->prepare('DELETE FROM like WHERE post_id = :post_id AND user_id = :user_id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            'user_id' => $userID,
            'post_id' => $postID
        ]);
    } else {

        // If post is not liked by user, insert like into database
        $statement = $pdo->prepare('INSERT INTO like (user_id, post_id) VALUES (:user_id, :post_id)');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            'user_id' => $userID,
            'post_id' => $postID
        ]);
    }

    $likes = numberOfLikes($postId, $pdo);
    echo json_encode($likes);
}

redirect('/');
