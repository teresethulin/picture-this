<?php

declare(strict_types=1); ?>

<?php require __DIR__ . '/views/header.php'; ?>


<!-- Check if user is logged in before they can edit their user data -->
<?php if (isLoggedIn()) : ?>

    <form action="app/users/edit-profile.php" method="post">

        <!-- Display error messages -->
        <?php foreach ($errors as $error) : ?>

            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>

        <?php endforeach; ?>

        <!-- Display confirmation of save success -->
        <?php foreach ($successes as $success) : ?>

            <div class="alert alert-primary" role="alert">
                <?php echo $success; ?>
            </div>

        <?php endforeach; ?>

        <h2>
            Edit your details
        </h2>

        <!-- UPDATE EMAIL -->
        <div class="form-element">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>">

        </div>

        <!-- UPDATE NAME -->
        <div class="form-element">

            <label for="full_name">Full name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo $_SESSION['user']['full_name']; ?>">

        </div>

        <!-- UPDATE BIOGRAPHY -->
        <div class="form-element">

            <label for="biography">Biography</label>
            <textarea name="biography" id="biography" form="post" maxlength="255" value="<?php echo $_SESSION['user']['biography']; ?>">
            </textarea>

        </div>

        <button type="submit">Save details</button>

    </form>


    <!-- UPDATE PASSWORD -->
    <form action="app/users/edit-profile.php" method="post">

        <!-- Display error messages -->
        <?php foreach ($errors as $error) : ?>

            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>

        <?php endforeach; ?>

        <!-- Display confirmation of save success -->
        <?php foreach ($successes as $success) : ?>

            <div class="alert alert-primary" role="alert">
                <?php echo $success; ?>
            </div>

        <?php endforeach; ?>

        <h2>
            Change password
        </h2>

        <!-- CURRENT PASSWORD -->
        <div class="form-element">

            <label for="password">Current password</label>
            <input type="password" name="password">

        </div>

        <!-- NEW PASSWORD -->
        <div class="form-element">

            <label for="new-password">New password</label>
            <input type="password" name="new-password">

        </div>

        <button type="submit">Save password</button>

    </form>

<?php endif; ?>
