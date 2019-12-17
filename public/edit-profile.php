<?php

declare(strict_types=1); ?>

<?php require __DIR__ . '/views/header.php'; ?>


<!-- Check if user is logged in before they can edit their user data -->
<?php if (isLoggedIn()) : ?>

    <form action="app/users/edit-profile.php" method="post">
        <?php foreach ($errors as $error) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <h2>
            Edit your profile.
        </h2>
        <div>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="full_name" id="full_name" placeholder="Full name" required>
            <input type="text" name="biography" id="biography" placeholder="Tell us something about yourself." required>
        </div>

        <button type="submit">Save</button>

    </form>
<?php endif; ?>
