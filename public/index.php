<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

$posts = getAllPosts($pdo); ?>

<article>

    <?php foreach ($posts as $post) : ?>

        <?php $avatar = $post['avatar']; ?>
        <?php $postID = $post['id']; ?>
        <?php $likes = numberOfLikes((int) $postID, $pdo); ?>
        <?php $isLiked = isLiked((int) $userID, (int) $postID, $pdo); ?>

        <img class="avatar" src="<?php echo ($post['avatar'] !== null) ? "/uploads/avatar/" . $post['avatar'] : "/uploads/avatar/placeholder.png"; ?>">

        <h3><?php echo $post['username']; ?></h3>

        <img class="post-img" src="<?php echo '/uploads/posts/' . $post['filename']; ?>" id="<?php echo $post['id']; ?>">

        <!-- LIKE FORM -->
        <form class="form-like" id="<?php echo $postID; ?>" action="app/posts/like.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $postID; ?>">

            <button class="like-button" type="submit" id="<?php echo $postID; ?>">

                <i class="<?php echo ($isLiked !== true) ? "far fa-heart" : "fas fa-heart"; ?>"></i>

            </button>

            <p><?php echo $likes; ?> likes</p>

        </form>

        <button class="comment">
            <i class="far fa-comment-alt"></i>
        </button>

        <!-- IF POST USER EQUALS LOGGED IN USER, SHOW EDIT AND DELETE BUTTONS ON THEIR POSTS-->
        <?php if (($_SESSION['user']['id'] === $post['user_id'])) : ?>
            <a href="../../edit-post.php?id=<?php echo $post['id']; ?>"><i class="far fa-edit"></i></a>
            <a href="../posts/delete.php?id=<?php echo $post['id']; ?>"><i class="far fa-trash-alt"></i></a>
        <?php endif; ?>

        <p><?php echo $post['caption']; ?></p>
        <br>

    <?php endforeach; ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
