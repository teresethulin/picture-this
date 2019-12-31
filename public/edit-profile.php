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

?>

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

<img class="avatar" src="<?php echo ($avatar !== null) ? "uploads/avatar/" . $avatar : "uploads/avatar/placeholder.png"; ?>">
<!-- UPLOAD AVATAR -->
<form action="app/users/avatar.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" required>
    <button type="submit">Upload profile picture</button>
</form>


<!-- UPDATE EMAIL -->
<form action="app/users/email.php" method="post">

    <div class="form-element">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">

    </div>

    <button type="submit">Save</button>

</form>


<!-- UPDATE NAME -->
<form action="app/users/name.php" method="post">

    <div class="form-element">

        <label for="full_name">Full name</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo $user['full_name']; ?>">

    </div>

    <button type="submit">Save</button>

</form>


<!-- UPDATE BIOGRAPHY -->
<form action="app/users/biography.php" method="post">

    <div class="form-element">

        <label for="biography">Biography</label>
        <textarea type="text" name="biography" maxlength="255" value="<?php echo $user['biography']; ?>">
        </textarea>

    </div>

    <button type="submit">Save biography</button>

</form>


<!-- UPDATE PASSWORD -->
<form action="app/users/password.php" method="post">

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
