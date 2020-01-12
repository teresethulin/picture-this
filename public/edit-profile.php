<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php';

// Redirect the user if not logged in
if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$avatar = $user['avatar'];

$errors = [];
$successes = [];

?>

<!-- Display error messages -->
<?php foreach ($errors as $error) : ?>

    <div class="alert-error" role="alert">
        <?php echo $error; ?>
    </div>

<?php endforeach; ?>

<!-- Display confirmation of save success -->
<?php foreach ($successes as $success) : ?>

    <div class="alert-success" role="alert">
        <?php echo $success; ?>
    </div>

<?php endforeach; ?>

<section class="edit-container">

    <img class="edit-avatar" id="output" src="<?php echo ($avatar !== null) ? "uploads/avatar/" . $avatar : "uploads/avatar/placeholder.png"; ?>">

    <!-- UPLOAD AVATAR -->
    <form class="form-avatar" action="app/users/avatar.php" method="POST" enctype="multipart/form-data">

        <div class="form-element column">

            <h2>
                Profile Picture
            </h2>

            <label for="avatar">Choose new profile picture</label>
            <input type="file" class="rounded" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" required onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

            <button type="submit" class="save-button">Upload profile picture</button>

        </div>

    </form>


    <!-- UPDATE EMAIL -->
    <form class="form-email" action="app/users/email.php" method="post">

        <div class="form-element column">

            <h2>
                Email
            </h2>

            <label for="email">Fill in your email</label>
            <input type="email" class="rounded" name="email" id="email" value="<?php echo $user['email']; ?>">

            <button type="submit" class="save-button">Save email</button>

        </div>

    </form>


    <!-- UPDATE NAME -->
    <form class="form-fullname" action="app/users/name.php" method="post">

        <div class="form-element column">

            <h2>
                Name
            </h2>

            <label for="full_name">Fill in your full name</label>
            <input type="text" class="rounded" name="full_name" id="full_name" value="<?php echo $user['full_name']; ?>">

            <button type="submit" class="save-button">Save full name</button>

        </div>

    </form>


    <!-- UPDATE BIOGRAPHY -->
    <form class="form-bio" action="app/users/biography.php" method="post">

        <div class="form-element column">

            <h2>
                Biography
            </h2>

            <label for="biography">Fill in your profile biography</label>
            <textarea type="text" class="rounded" name="biography" maxlength="255"><?php echo $user['biography']; ?></textarea>

            <button type="submit" class="save-button">Save biography</button>

        </div>

    </form>


    <!-- UPDATE PASSWORD -->
    <form class="form-password" action="app/users/password.php" method="post">

        <div class="form-element column">

            <h2>
                Change password
            </h2>

            <!-- CURRENT PASSWORD -->

            <label for="password">Current password</label>
            <input type="password" class="rounded" name="password">

            <!-- NEW PASSWORD -->

            <label for="new-password">New password</label>
            <input type="password" class="rounded" name="new-password">

            <button type="submit" class="save-button">Save password</button>

        </div>

    </form>

    <div class="form-element column">

        <h2>
            Sign out
        </h2>

        <a class="nav-link" href="/app/users/logout.php"><i class="fas fa-sign-out-alt"></i></a>

    </div>

</section>
