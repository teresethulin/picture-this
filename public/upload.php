<?php

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}
?>

<form action="/app/posts/upload.php" method="POST" enctype="multipart/form-data">

    <div>

        <label for="image">
            Choose image to upload
        </label>

        <input type="file" name="image" id="image" accept="image/*" required>

        <label for="caption">
            Image caption
        </label>

        <textarea type="text" name="caption" maxlength="255" value="<?php echo $_SESSION['post']['caption']; ?>">
        </textarea>

    </div>

    <button type="submit">
        Upload
    </button>

</form>

<?php require __DIR__ . '/views/footer.php'; ?>
