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
        <div class="form-element">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>">
        </div>
        <div class="form-element">
            <label for="full_name">Full name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo $_SESSION['user']['full_name']; ?>">
        </div>
        <div class="form-element">
            <label for="biography">Biography</label>
            <textarea name="biography" id="biography" form="post" maxlength="255" value="<?php echo $_SESSION['user']['biography']; ?>">
            </textarea>
        </div>

        <button type="submit">Save</button>

    </form>
<?php endif; ?>
