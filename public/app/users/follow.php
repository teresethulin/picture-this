<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when a user is followed.

header('Content-Type: application/json');

if(isset($_POST['followed-user-id'])) {
    $queryInsertFollower = 'INSERT INTO follows (user_id, id_following) VALUES (:user_id, :id_following)';
    $statement = $pdo->prepare($queryInsertFollower);
    $statement->execute([
        ':user_id' => $_SESSION["user"]["id"],
        ':id_following' => $_POST['followed-user-id']
    ]);
};
