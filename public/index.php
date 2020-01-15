<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$posts = getAllPosts($pdo); ?>

<div class="feed-container">

    <?php foreach ($posts as $post) : ?>

        <article>

            <?php $avatar = $post['avatar']; ?>
            <?php $postID = $post['id']; ?>
            <?php $likes = numberOfLikes((int) $postID, $pdo); ?>
            <?php $isLiked = isLiked((int) $userID, (int) $postID, $pdo); ?>

            <div class="post-user-container">

                <img class="post-avatar" src="<?php echo ($post['avatar'] !== null) ? "/uploads/avatar/" . $post['avatar'] : "/uploads/avatar/placeholder.png"; ?>">

                <h3><?php echo $post['username']; ?></h3>

            </div>

            <!-- POST IMAGE -->
            <img class="post-img" src="<?php echo '/uploads/posts/' . $post['filename']; ?>" id="<?php echo $post['id']; ?>">


            <!-- POST LIKE, COMMENT, EDIT, DELETE BUTTONS -->
            <div class="post-buttons-container">

                <div class="post-buttons">

                    <!-- LIKE BUTTON -->
                    <form class="form-like" id="<?php echo $postID; ?>" action="app/posts/like.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $postID; ?>">

                        <button class="like-button" type="submit" id="<?php echo $postID; ?>">

                            <i class="<?php echo ($isLiked !== true) ? "far fa-heart" : "fas fa-heart"; ?>"></i>

                            <!-- NUMBER OF LIKES -->
                            <?php echo $likes; ?>

                        </button>


                    </form>

                    <button class="comment-button">

                        <i class="far fa-comment-alt"></i>

                    </button>

                </div>

                <!-- IF POST USER EQUALS LOGGED IN USER, SHOW EDIT AND DELETE BUTTONS ON THEIR POSTS-->
                <div class="edit-buttons">

                    <?php if (isUser($post)) : ?>

                        <!-- EDIT POST ICON -->
                        <a href="#openModal<?php echo $post['id']; ?>">
                            <i class="far fa-edit"></i>
                        </a>

                        <!-- EDIT POST MODAL WINDOW -->
                        <div id="openModal<?php echo $post['id']; ?>" class="modal column">

                            <div class="background column">

                                <a href="#close" title="Close window" class="close-window">
                                    <i class="fas fa-times fa-2x"></i>
                                </a>

                                <img class="post-thumbnail" id="<?php echo $post['id']; ?>" src="<?php echo "/uploads/posts/" . $post['filename']; ?>" id="<?php echo $post['id']; ?>">

                                <!-- UPDATE CAPTION -->
                                <form action="app/posts/edit-post.php?id=<?php echo $post['id']; ?>" method="post">

                                    <div class="form-element column">

                                        <label for="caption">Update caption</label>
                                        <textarea type="text" name="caption" maxlength="255"><?php echo $post['caption']; ?></textarea>

                                        <button type="submit">Save caption</button>

                                    </div>

                                </form>

                            </div>

                        </div>
                        <!-- END EDIT POST MODAL WINDOW -->

                        <!-- DELETE POST ICON -->
                        <a href="#openModalDelete<?php echo $post['id']; ?>">
                            <i class="far fa-trash-alt"></i>
                        </a>

                        <!-- DELETE POST MODAL WINDOW -->
                        <div id="openModalDelete<?php echo $post['id']; ?>" class="modal column">

                            <div class="background column">

                                <a href="#close" title="Close window" class="close-window">
                                    <i class="fas fa-times fa-2x"></i>
                                </a>

                                <h2>
                                    Are you sure you want to delete this post?
                                </h2>

                                <a href="app/posts/delete.php?id=<?php echo $post['id']; ?>">
                                    <div class="delete-button column">
                                        Delete post <i class="far fa-trash-alt"></i>
                                </a>
                            </div>

                        </div>

                </div>

            <?php endif; ?>

            </div>

</div>

<p>
    <?php echo $post['caption']; ?>
</p>

<p class="post-date">
    <?php
        $date = $post['date_created'];
        echo timeSinceUploaded($date);
    ?>
</p>


</article>

<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
