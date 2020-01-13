<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

$postID = $_GET['id'];

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

            // Remove file from uploads folder
            unlink(__DIR__ . '/../uploads/posts/' . $fileName);

            $_SESSION['success'] = 'Your post was deleted.';
            redirect('/app/users/profile.php');
        }
    }
}

redirect('/');
