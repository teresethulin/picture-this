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

$postID = $_GET['id'];

$posts = getPostsByUser((int) $userID, $pdo);
$post = getPostByID((int) $postID, $pdo);

$errors = [];
$successes = [];

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

            $successes[] = 'Your post was edited.';

            if (count($successes) > 0) {
                $_SESSION['successes'] = $successes;
                redirect('/app/users/profile.php');
                exit;
            }
        }
    }
}

// redirect('/');
