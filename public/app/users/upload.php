<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';
// require __DIR__ . '/../autoload.php';

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);


if (isset($_FILES['image'], $_POST['caption'])) {

    $errors = [];
    $image = $_FILES['image'];
    $fileName = $image['name'];
    $fileType = $image['type'];
    $fileSize = $image['size'];
    $caption = trim(filter_var($_POST['caption'], FILTER_SANITIZE_STRING));
    $date = date('Y-m-d H:i:s');


    if ($fileType !== 'image/gif' && $fileType !== 'image/jpg' && $fileType !== 'image/jpeg' && $fileType !== 'image/png') {
        $errors[] = 'The ' . $fileType . ' file extension is not allowed. Please use jpg, jpeg, png, or gif.';
    } elseif ($fileSize >= 1000000) {
        $errors[] = 'The uploaded file ' . $fileName . ' exceeded the filesize limit of 1MB (' . $fileSize . ' ). Please resize or upload another image.';
    } else {
        // If errors, display error message and redirect user
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            redirect('/upload.php');
            exit;
        }

        $destination = __DIR__ . '/../../uploads/' . date('ymd') . '-' . $fileName;
        move_uploaded_file($image['tmp_name'], $destination);

        // Store in database
        $query = "INSERT INTO post (user_id, caption, filename, date_created) VALUES (:user_id, :caption, :filename, :date)";
        $statement = $pdo->prepare($query);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->bindParam(':user_id', $userID, PDO::PARAM_STR);
        $statement->bindParam(':caption', $caption, PDO::PARAM_STR);
        $statement->bindParam(':filename', $fileName, PDO::PARAM_STR);
        $statement->bindParam(':date', $date, PDO::PARAM_STR);

        $statement->execute();

        $successes[] = 'File uploaded.';

        if (count($successes) > 0) {
            $_SESSION['successes'] = $successes;
            redirect('/app/users/profile.php');
            exit;
        }
    }
}
