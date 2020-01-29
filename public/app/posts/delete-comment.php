<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called when a selected post is deleted from a user's profile & the database.

if(isset($_POST['comment-id'])) {
    $commentID = intval(filter_var($_POST['comment-id'],FILTER_SANITIZE_NUMBER_INT));

    // Delete comments associated with post
    $queryDeleteComment = sprintf('DELETE FROM comments WHERE comment_id = :comment_id');
    $statement = $pdo->prepare($queryDeleteComment);
    $statement->bindParam(':comment_id', $commentID, PDO::PARAM_INT);
    $statement->execute();
    exit;
}
