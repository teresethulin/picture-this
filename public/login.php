<?php require __DIR__ . '/views/header.php'; ?>

<form action="app/users/login.php" method="post">
    <div>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="text" name="password" id="password" placeholder="Password" required>
    </div>

    <button type="submit">Log in</button>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
