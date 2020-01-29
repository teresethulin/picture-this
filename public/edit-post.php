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

$postID = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
$returnURL = trim(filter_var($_GET['return'], FILTER_SANITIZE_STRING));

$posts = getPostsByUser((int) $userID, $pdo);
$post = getPostByID((int) $postID, $pdo);

?>

<a href="my-profile.php">
    <p class="back-button">
        <i class="fas fa-chevron-left"></i>
        Back
    </p>
</a>

<section class="column-space-evenly">

    <!-- UPDATE CAPTION -->
    <form action="app/posts/edit-post.php?id=<?php echo $post['id']; ?>&return=<?= $returnURL; ?>" method="post">

        <div class="edit-container">


            <h2>
                Edit post caption
            </h2>

            <img class="post-thumbnail" id="<?php echo $post['id']; ?>" src="<?php echo "/uploads/posts/" . $post['filename']; ?>" id="<?php echo $post['id']; ?>">

            <label for="caption">Write caption here</label>
            <textarea type="text" name="caption" maxlength="255"><?php echo $post['caption']; ?></textarea>


            <button type="submit">Save caption</button>

        </div>

    </form>

</section>
