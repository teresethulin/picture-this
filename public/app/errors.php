<?php

$errors = [];

if ($_SESSION['error']) {

    $errors = $_SESSION['error'];
    unset($_SESSION['error']);
}
