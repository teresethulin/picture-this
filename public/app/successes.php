<?php

declare(strict_types=1);

$successes = [];

if (isset($_SESSION['successes'])) {
    $successes = $_SESSION['successes'];
    unset($_SESSION['successes']);
}
