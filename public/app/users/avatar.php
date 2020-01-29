<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// Store avatar in database and save in uploads
if (isset($_FILES['avatar'])) {

    $avatar = $_FILES['avatar'];

    $fileName = date('ymd') . '-' . $avatar['name'];
    $fileType = $avatar['type'];
    $fileSize = $avatar['size'];


    if ($fileType !== 'image/jpg' && $fileType !== 'image/jpeg' && $fileType !== 'image/png') {
        $_SESSION['error'] = 'The ' . $fileType . ' file extension is not allowed. Please use jpg, jpeg, or png.';
        redirect('/../edit-profile.php');
    } elseif ($fileSize >= 1000000) {
        $_SESSION['error'] = 'The uploaded file ' . $avatar['name'] . ' exceeded the filesize limit of 1MB ( ' . $fileSize . ' ). Please resize or upload another image.';
        redirect('/../edit-profile.php');
    } else {

        // Destination folder
        $destination = __DIR__ . '/../../uploads/avatar/' . date('ymd') . '-' . $avatar['name'];
        move_uploaded_file($avatar['tmp_name'], $destination);

        // Store in database
        $query = "UPDATE user SET avatar = :avatar WHERE id = :userid";
        $statement = $pdo->prepare($query);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':avatar' => $fileName,
            ':userid' => $userID
        ]);

        move_uploaded_file($avatar['tmp_name'], $destination);
        $_SESSION['success'] = 'Avatar updated.';

        redirect('../../my-profile.php');
    }
}

redirect('/');
