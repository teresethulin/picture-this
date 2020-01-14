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

$postID = $_GET['id'];

$posts = getPostsByUser((int) $userID, $pdo);
$post = getPostByID((int) $postID, $pdo);

?>

<!-- UPDATE CAPTION -->
<form action="app/posts/edit-post.php?id=<?php echo $post['id']; ?>" method="post">

    <div class="form-element">

        <label for="caption">caption</label>
        <textarea type="text" name="caption" maxlength="255"><?php echo $post['caption']; ?></textarea>

    </div>

    <button type="submit">Save caption</button>

</form>
