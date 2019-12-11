<?php require __DIR__ . '/views/header.php'; ?>

<form action="app/users/signup.php" method="post">
    <h2>
        Sign up to see photos from your friends.
    </h2>
    <div>
        <input type="text" name="email" id="email" placeholder="Email" required>
        <input type="text" name="full-name" id="full-name" placeholder="Full name" required>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="text" name="password" id="password" placeholder="Password" required>
    </div>

    <button type="submit">Sign up</button>
</form>
<section>
    <h2>
        Have an account? <a href="login.php">Log in</a>
    </h2>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>
