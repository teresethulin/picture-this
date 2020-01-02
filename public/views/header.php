<?php
// Always start by loading the default application setup.
require __DIR__ . '/../app/autoload.php';

require __DIR__ . '/../app/errors.php';
require __DIR__ . '/../app/successes.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $config['title']; ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/css/avatar.css">
    <link rel="stylesheet" href="/assets/css/post-img.css">
</head>

<body>
    <?php require __DIR__ . '/navigation.php'; ?>

    <div class="container py-5">
