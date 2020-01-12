<?php

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}
?>

<form class="column" action="/app/posts/upload.php" method="POST" enctype="multipart/form-data">

    <div class="column">

        <img id="output" class="preview-img" />

        <label for="image">
            Choose image to upload
        </label>

        <input type="file" class="rounded" name="image" id="image" accept="image/*" required onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">

        <label for="caption">
            Write a caption
        </label>

        <textarea type="text" name="caption" maxlength="255"></textarea>


        <button type="submit">
            Upload image
        </button>

    </div>

</form>

<?php require __DIR__ . '/views/footer.php'; ?>
