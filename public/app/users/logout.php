<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// Remove the user session variable and redirect the user back to the homepage.
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

redirect('/');
