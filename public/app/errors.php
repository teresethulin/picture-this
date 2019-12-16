<?php

declare(strict_types=1);

$errors = [];

if (isset($_SESSION['errors'])) {

    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
