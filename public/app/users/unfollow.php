<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a user is unfollowed.

header('Content-Type: application/json');

if(isset($_POST['unfollowed-user-id'])) {
    $queryUnfollow = 'DELETE FROM follows WHERE user_id = :user_id AND id_following = :id_following';
    $statement = $pdo->prepare($queryUnfollow);
    $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':id_following' => $_POST['unfollowed-user-id'],
    ]);
};
