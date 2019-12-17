<?php

declare(strict_types=1); ?>

<?php require __DIR__ . '/../../views/header.php'; ?>

<!-- Check if user is logged in before printing userdata to profile -->

<?php if (isLoggedIn()) : ?>

    <h1>
        <?php echo $_SESSION['user']['username']; ?>
    </h1>

    <p>
        <?php echo $_SESSION['user']['full_name']; ?>
    </p>

    <p>
        <?php echo $_SESSION['user']['biography']; ?>
    </p>

    <button class="edit-profile" type="button">Edit profile</button>

<?php endif; ?>

<?php require __DIR__ . '/../../views/footer.php'; ?>
