<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a post is edited/changed.

header('Content-Type: application/json');

if(isset($_POST['comment-id'],$_POST['comment-text'])) {
    $commentID = trim(filter_var($_POST['comment-id'],FILTER_SANITIZE_NUMBER_INT));
    $newCommentText = trim(filter_var($_POST['comment-text'],FILTER_SANITIZE_STRING));
    $queryUpdateCommentText = 'UPDATE comments SET comment_text = :comment_text WHERE comment_id = :comment_id';
    $statement = $pdo->prepare($queryUpdateCommentText);
    $statement->execute([
        ':comment_id' => $commentID,
        ':comment_text' => $newCommentText
    ]);
    $newComment = [
        'commentID' => $commentID,
        'commentText' => $newCommentText,
    ];
    $newComment = json_encode($newComment);
    echo $newComment;
    exit;
};
