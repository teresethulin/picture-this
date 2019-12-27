<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$postId = $_POST['id'];

$posts = getAllPostsByUser((int) $userID, $pdo);

$successes = [];

// Why is $_POST['id'] undefined?

if (isset($_POST['id'])) {

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
                ':id' => $postId,
                ':filename' => $fileName
            ]);

            // Remove file from uploads folder
            unlink(__DIR__ . '/../uploads/posts/' . $fileName);

            $successes[] = 'Your post was deleted.';

            if (count($successes) > 0) {
                $_SESSION['successes'] = $successes;
                redirect('/app/users/profile.php');
                exit;
            }
        }
    }
}

redirect('/');
