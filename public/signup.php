<?php require __DIR__ . '/views/header.php'; ?>

<form action="app/users/signup.php" method="post">
    <?php foreach ($errors as $error) : ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <h2>
        Sign up to see photos from your friends.
    </h2>
    <div>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="text" name="full_name" id="full_name" placeholder="Full name" required>
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
