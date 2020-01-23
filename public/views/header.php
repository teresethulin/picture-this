<?php
// Always start by loading the default application setup.
require __DIR__ . '/../app/autoload.php';

// require __DIR__ . '/../app/errors.php';
// require __DIR__ . '/../app/successes.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <title><?php echo $config['title']; ?></title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://use.typekit.net/ets7mqa.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/search.css">
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet" href="/assets/css/nav.css">
    <link rel="stylesheet" href="/assets/css/post.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
    <link rel="stylesheet" href="/assets/css/alert.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/edit-profile.css">
    <script src="https://kit.fontawesome.com/86df5cd063.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php if (isError()) : ?>

        <div class="alert-error">

            <p>
                <?php echo $_SESSION['error']; ?>
            </p>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <?php if (isSuccess()) : ?>

        <div class="alert-success">

            <p>
                <?php echo $_SESSION['success']; ?>
            </p>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>
