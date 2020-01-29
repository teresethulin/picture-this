<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// This file is called whenever a comment is entered into the database.

header('Content-Type: application/json');

if(isset($_POST['post-id'],$_POST['comment-text'])) {
    $commentText = trim(filter_var($_POST['comment-text'], FILTER_SANITIZE_STRING));
    if ($commentText==="") {
        $comment = [
            'commentText' => "",
        ];
        $comment = json_encode($comment);
        echo $comment;
        exit;
    }
    $queryInsertComment = 'INSERT INTO comments (post_id, user_id, username, comment_text) VALUES (:post_id, :user_id, :username, :comment_text)';
    $statement = $pdo->prepare($queryInsertComment);
    $statement->execute([
        ':post_id' => $_POST['post-id'],
        ':user_id' => $_SESSION['user']['id'],
        ':username' => $_SESSION['user']['username'],
        ':comment_text' => $commentText
    ]);
    $queryFetchComment = 'SELECT * FROM comments WHERE comment_text = :comment_text AND post_id = :post_id AND user_id = :user_id AND username = :username';
    $statement = $pdo->prepare($queryFetchComment);
    $statement->execute([
        ':post_id' => $_POST['post-id'],
        ':user_id' => $_SESSION['user']['id'],
        ':username' => $_SESSION['user']['username'],
        ':comment_text' => $commentText
    ]);

    $comment = $statement->fetch(PDO::FETCH_ASSOC);

    $comment = [
        'commentID' => $comment['comment_id'],
        'userID' => $comment['user_id'],
        'commentText' => $comment['comment_text']
    ];
    $comment = json_encode($comment);
    echo $comment;
    exit;
};
