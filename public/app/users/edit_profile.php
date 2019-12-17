<?php

declare(strict_types=1); ?>

<?php require __DIR__ . '/../autoload.php'; ?>

<?php if (isLoggedIn()) : ?>

    <form action="app/users/edit_profile.php" method="post">

    </form>
<?php endif; ?>
