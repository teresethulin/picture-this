<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$userID = $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$posts = getAllPosts($pdo); ?>

<div class="feed-container">
    <div class="dummy-user-div" id="<?= $userID; ?>"><?= $_SESSION['user']['username']; ?></div>

    <?php foreach ($posts as $post) : ?>
    <div class="dummy-post-div" id="<?= $post['user_id']; ?>"></div>


        <article>

            <?php $avatar = $post['avatar']; ?>
            <?php $postID = $post['id']; ?>
            <?php $likes = numberOfLikes((int) $postID, $pdo); ?>
            <?php $isLiked = isLiked((int) $userID, (int) $postID, $pdo); ?>
            <?php $comments = getCommentsByPostID($postID, $pdo); ?>

            <form id="form-<?= $post['id']; ?>" action="profile.php" method="post">
                <input type="hidden" name="profileID" value="<?= $post['user_id']; ?>">
                <div onclick="document.getElementById('form-<?= $post['id']; ?>').submit();" class="post-user-container">

                    <img class="post-avatar" src="<?php echo (isset($post['avatar'])) ? "/uploads/avatar/" . $post['avatar'] : "/uploads/avatar/placeholder.png"; ?>">

                    <h3 class="profile-username"><?php echo $post['username']; ?></h3>

                </div>
            </form>

            <!-- POST IMAGE -->
            <img class="post-img" src="<?php echo (isset($post['filename'])) ? "/uploads/posts/" . $post['filename'] : "/uploads/posts/placeholder.png"; ?>" id="<?php echo $post['id']; ?>">

            <!-- POST LIKE, COMMENT, EDIT, DELETE BUTTONS -->
            <div class="post-buttons-container">

                <div class="post-buttons">

                    <!-- LIKE IMG -->
                    <button class="like-button" id="<?= $post['id']; ?>"><img class="like-img" id="img-<?= $post['id']; ?>" src="<?php echo ($isLiked !== true) ? "/uploads/icons/heart-inactive.svg" : "/uploads/icons/heart-active.svg"; ?>">

                        <!-- NUMBER OF LIKES -->
                        <span class="span-<?= $post['id']; ?>"><?php echo $likes; ?></span>

                    </button>


                    </form>

                    <button class="comment-button" id="<?= $post['id']; ?>">

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

                                    <div class="column">

                                        <h2>
                                            <label for="caption">Edit Caption</label>
                                        </h2>

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

                                <a href="app/posts/delete.php?id=<?php echo $post['id']; ?>&return=index.php">
                                    <div class="delete-button column">
                                        Delete post <i class="far fa-trash-alt"></i>
                                </a>
                            </div>

                        </div>

                </div>

            <?php endif; ?>

            </div>

</div>
<!-- CAPTION -->
<p><?php echo $post['caption']; ?></p>
<!-- COMMENTS -->
<div class="comments-container-<?= $post['id']; ?>">
    <?php foreach ($comments as $comment) : ?>
        <div class="comment-container comment-container-<?= $comment['comment_id']; ?>">
        <div class="comment-box comment-writer-<?= $comment['user_id']; ?> comment-owner-<?= $post['user_id']; ?>" id="<?= $comment['comment_id']; ?>">
            <h5 class="comment-user"><?= $comment['username']; ?></h5>
            <h5 class="comment-text-<?= $comment['comment_id']; ?>"><?= $comment['comment_text']; ?></h5>
        </div>
        </div>
    <?php endforeach; ?>
</div>

<p class="post-date">
    <?php
        $date = $post['date_created'];
        echo timeSinceUploaded($date);
    ?>
</p>


</article>

<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
