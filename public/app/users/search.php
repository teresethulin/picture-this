<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
Header('Content-Type: application/json');

if (!isLoggedIn()) {
    redirect('/');
}

if(isset($_POST['search'])) {
    $search = trim(filter_var('%' . $_POST['search'] . '%', FILTER_SANITIZE_STRING));
    $querySearch = 'SELECT * FROM user WHERE username LIKE :search';
    $statement = $pdo -> prepare($querySearch);
    if(!$querySearch) {
        $error = $pdo->errorInfo();
        echo json_encode($error);
        exit;
    }
    $statement -> execute([
        ':search' => $search
    ]);

    $users = $statement -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
    exit;
}
