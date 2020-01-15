<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
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

                            <?php if (isLiked((int) $userID, (int) $postID, $pdo)) : ?>
                                <i class="far fa-heart" alt="liked"></i>
                            <?php else : ?>
                                <i class="fas fa-heart" alt="unliked"></i>
                            <?php endif; ?>
                            <span class="likes">
                                <?php
                                if ($likes === "0") {
                                    echo ' ';
                                } else {
                                    echo $likes;
                                } ?>
                            </span>

                        </button>

                    </form>

                    <button class="comment-button">

                        <i class="far fa-comment-alt"></i>

                    </button>

                </div>

                <!-- IF POST USER EQUALS LOGGED IN USER, SHOW EDIT AND DELETE BUTTONS ON THEIR POSTS-->
                <div class="edit-buttons">

                    <?php if (isUser($post)) : ?>
                        <a href="../../edit-post.php?id=<?php echo $post['id']; ?>"><i class="far fa-edit"></i></a>
                        <a href="app/posts/delete.php?id=<?php echo $post['id']; ?>"><i class="far fa-trash-alt"></i></a>
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
