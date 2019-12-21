<?php

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}
?>

<form action="/app/users/upload.php" method="POST" enctype="multipart/form-data">
    <div>
        <label for="posts">Choose images to upload</label>
        <input type="file" name="posts[]" id="posts" accept=".jpg, .jpeg, .png, .gif" multiple required>
    </div>

    <button type="submit">Upload</button>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
