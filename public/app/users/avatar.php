<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// Display messages
$errors = [];
$successes = [];

// Store avatar in database and save in uploads
if (isset($_FILES['avatar'])) {

    $avatar = $_FILES['avatar'];

    $fileName = date('ymd') . '-' . $avatar['name'];
    $fileType = $avatar['type'];
    $fileSize = $avatar['size'];

    // Display messages
    $errors = [];
    $successes = [];

    if ($fileType !== 'image/jpg' && $fileType !== 'image/jpeg' && $fileType !== 'image/png') {
        $errors[] = 'The ' . $fileType . ' file extension is not allowed. Please use jpg, jpeg, or png.';
    } elseif ($fileSize >= 1000000) {
        $errors[] = 'The uploaded file ' . $fileName . ' exceeded the filesize limit of 1MB (' . $fileSize . ' ). Please resize or upload another image.';
    } else {

        // Destination folder
        $destination = __DIR__ . '/../uploads/avatar/' . date('ymd') . '-' . $avatar['name'];
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
        $successes[] = 'Avatar updated.';

        if (count($successes) > 0) {
            $_SESSION['successes'] = $successes;
            redirect('profile.php');
            exit;
        }
    }
    // If errors, display error message and redirect user
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        redirect('/../edit-profile.php');
        exit;
    }
}

redirect('/');
