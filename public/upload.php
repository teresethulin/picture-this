<?php

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

if (isset($_POST['submit'])) {
}
