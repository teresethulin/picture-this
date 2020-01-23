<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

// UPDATE USER BIOGRAPHY
if (isset($_POST['biography'])) {

    $biography = trim(filter_var($_POST['biography'], FILTER_SANITIZE_STRING));

    $query = 'UPDATE user SET biography = :biography WHERE id = :userid';
    $statement = $pdo->prepare($query);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->execute([
        ':biography' => $biography,
        ':userid' => $userID,
    ]);

    $_SESSION['user']['biography'] = $biography;

    // Display confirmation
    $_SESSION['success'] = "Biography updated.";
    redirect('../../myProfile.php');
}
