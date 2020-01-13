<?php require __DIR__ . '/views/header.php'; ?>

<section class="column-space-evenly">

    <h1>
        Picture This
    </h1>

    <h3>
        Sign up to see photos from your friends.
    </h3>

    <form class="column" action="app/users/signup.php" method="post">


        <input class="rounded" type="email" name="email" id="email" placeholder="Email" required>
        <input class="rounded" type="text" name="full_name" id="full_name" placeholder="Full name" required>
        <input class="rounded" type="text" name="username" id="username" placeholder="Username" required>
        <input class="rounded" type="text" name="password" id="password" placeholder="Password" required>

        <button type="submit">Sign up</button>

    </form>


    <h3>
        Have an account?

        <a href="login.php" class="focus">Log in</a>
    </h3>

</section>
