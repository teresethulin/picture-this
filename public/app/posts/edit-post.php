<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we edit posts in the database.

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

$postID = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
$returnURL = trim(filter_var($_GET['return'], FILTER_SANITIZE_STRING));

$posts = getPostsByUser((int) $userID, $pdo);
$post = getPostByID((int) $postID, $pdo);


if (isset($_POST['caption'])) {

    foreach ($posts as $post) {

        // Compare id with id in database
        if ($postID === $post['id']) {

            $caption = $_POST['caption'];

            // Edit post in database
            $statement = $pdo->prepare('UPDATE post SET caption = :caption WHERE id = :id');

            if (!$statement) {
                die(var_dump($pdo->errorInfo()));
            }

            $statement->execute([
                ':id' => $postID,
                ':caption' => $caption
            ]);

            $_SESSION['success'] = 'Your post was updated.';
            redirect("/../../$returnURL");
        }
    }
}
