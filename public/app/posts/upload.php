<?php

declare(strict_types=1);


// require __DIR__ . '/../autoload.php';
require __DIR__ . '/../../views/header.php';

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);


if (isset($_FILES['image'], $_POST['caption'])) {

    $image = $_FILES['image'];
    $fileName = date('ymd') . '-' . $image['name'];
    $fileType = $image['type'];
    $fileSize = $image['size'];
    $caption = trim(filter_var($_POST['caption'], FILTER_SANITIZE_STRING));
    $dateCreated = date('Y-m-d H:i:s');

    if (($fileType === 'image/gif' || $fileType === 'image/jpg' || $fileType === 'image/jpeg' || $fileType === 'image/png') && $fileSize <= 1000000) {

        $destination = __DIR__ . '/../../uploads/posts/' . $fileName;

        // Store in database
        $query = "INSERT INTO post (user_id, caption, filename, date_created) VALUES (:user_id, :caption, :filename, :date_created)";
        $statement = $pdo->prepare($query);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':user_id' => $userID,
            ':caption' => $caption,
            ':filename' => $fileName,
            ':date_created' => $dateCreated
        ]);

        move_uploaded_file($image['tmp_name'], $destination);

        $_SESSION['success'] = 'File uploaded.';

        redirect('/../../index.php');
    } elseif ($fileSize > 1000000) {
        $_SESSION['error'] = 'The uploaded file ' . $fileName . ' exceeded the filesize limit of 1MB (' . $fileSize . ' ). Please resize or upload another image.';
        redirect('../../upload.php');
    } else {
        $_SESSION['error'] = 'The ' . $fileType . ' file extension is not allowed. Please use jpg, jpeg, png, or gif.';
        redirect('../../upload.php');
    }
}
