<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];

    $destination = __DIR__ . '/app/uploads' . date('ymd') . '-' . $avatar['name'];
    move_uploaded_file($avatar['tmp_name'], $destination);
}
