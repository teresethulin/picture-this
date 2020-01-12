<?php require __DIR__ . '/views/header.php'; ?>

<section class="column splash">

    <h1>
        Picture This
    </h1>

    <form class="column" action="app/users/login.php" method="post">
        <div class="form-element">
            <input type="text" class="rounded" name="username" id="username" placeholder="Username" required>
            <input type="text" class="rounded" name="password" id="password" placeholder="Password" required>
        </div>

        <button type="submit">Log in</button>
    </form>

</section>
