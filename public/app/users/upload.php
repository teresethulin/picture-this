<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

$userID = $_SESSION['user']['id'];
$user = getUserById($userID, $pdo);

// Display messages
$errors = [];
$successes = [];

if (isset($_FILES['image'], $_POST['caption'])) {

    $errors = [];
    $image = $_FILES['image'];
    $fileName = $image['name'];
    $fileType = $image['type'];
    $fileSize = $image['size'];
    $caption = trim(filter_var($_POST['caption'], FILTER_SANITIZE_STRING));


    if ($image['type'] !== 'image/gif' || 'image/jpg' || 'image/jpeg' || 'image/png') {
        $errors[] = 'The ' . $fileType . ' file extension is not allowed. Please use jpg, jpeg, png, or gif';
    } elseif ($image['size'] >= 1000000) {
        $errors[] = 'The uploaded file ' . $fileName . ' exceeded the filesize limit of 1MB (' . $fileSize . ' ). Please resize or upload another image.';
    } else {
        $destination = __DIR__ . '/uploads/' . date('ymdHi') . '-' . $fileName;
        move_uploaded_file($image['tmp_name'][$i], $destination);
    }

    // If errors, display error message and redirect user
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/upload.php');
        exit;
    }
}
