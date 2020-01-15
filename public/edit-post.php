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

<a href="app/users/profile.php">
    <p class="back-button">
        <i class="fas fa-chevron-left"></i>
        Back
    </p>
</a>

<section class="column-space-evenly">


    <!-- UPDATE CAPTION -->
    <form action="app/posts/edit-post.php?id=<?php echo $post['id']; ?>" method="post">

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
