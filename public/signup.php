<?php require __DIR__ . '/views/header.php'; ?>

<form class="column" action="app/users/signup.php" method="post">

    <h2>
        Sign up to see photos from your friends.
    </h2>

    <input class="rounded" type="email" name="email" id="email" placeholder="Email" required>
    <input class="rounded" type="text" name="full_name" id="full_name" placeholder="Full name" required>
    <input class="rounded" type="text" name="username" id="username" placeholder="Username" required>
    <input class="rounded" type="text" name="password" id="password" placeholder="Password" required>

    <button type="submit">Sign up</button>

</form>

<section class="column">

    <h2>
        Have an account?
    </h2>

    <h3>
        <a href="login.php">Log in</a>
    </h3>

</section>
