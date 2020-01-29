<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

$postID = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
$returnURL = trim(filter_var($_GET['return'], FILTER_SANITIZE_STRING));

$posts = getPostsByUser((int) $userID, $pdo);


if (isset($_GET['id'])) {

    foreach ($posts as $post) {

        // Compare id with id in database
        if ($postID === $post['id']) {

            $fileName = $post['filename'];

            // Delete post from database
            $statement = $pdo->prepare('DELETE FROM post WHERE id = :id AND filename = :filename');

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->execute([
                ':id' => $postID,
                ':filename' => $fileName
            ]);

            // Delete likes associated with post
            $queryDeleteLikes = sprintf('DELETE FROM like WHERE post_id = :post_id');
            $statement = $pdo->prepare($queryDeleteLikes);

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
            $statement->execute();

            // Delete comments associated with post
            $queryDeleteComments = sprintf('DELETE FROM comments WHERE post_id = :post_id');
            $statement = $pdo->prepare($queryDeleteComments);

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->bindParam(':post_id', $postID, PDO::PARAM_INT);
            $statement->execute();

            // Remove file from uploads folder
            unlink(__DIR__ . '/../uploads/posts/' . $fileName);

            $_SESSION['success'] = 'Your post was deleted.';
            redirect("/$returnURL");
        }
    }
}

redirect('/');
