<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/login.php');
} ?>
<div class="feed-container">

    <h1>Search</h1>
    <form class="search-input column" method="post" action="/app/users/search.php">
        <input type="text" class="rounded" name="search" placeholder="Please enter a username">
        <i id="search-icon" class="fas fa-search"></i>
    </form>
    <div class="search-list"></div>

</div>




<hr>

<section class="image-grid">


    <?php $userID = $_SESSION['user']['id']; ?>
    <div class="dummy-user-div" id="<?= $userID; ?>"><?= $_SESSION['user']['username']; ?></div>
    <?php $posts = getAllPosts($pdo); ?>
    <?php if (!$posts) {
        echo "No posts yet.";
    }; ?>

    <?php foreach ($posts as $post) : ?>
        <div class="dummy-post-div" id="<?= $post['user_id']; ?>"></div>
        <?php $postID = $post['id'];
        $likes = numberOfLikes((int) $postID, $pdo);
        $isLiked = isLiked((int) $userID, (int) $postID, $pdo);
        $comments = getCommentsByPostID((int) $postID, $pdo); ?>

        <a href="#openModal<?php echo $post['id']; ?>">
            <img id="<?php echo $post['id']; ?>" class="post-thumbnail" src="<?php echo "/uploads/posts/" . $post['filename']; ?>" id="<?php echo $post['id']; ?>">
        </a>

        <div id="openModal<?php echo $post['id']; ?>" class="modal">

            <div class="background">

                <a href="#close" title="Close window" class="close-window">
                    <i class="fas fa-times fa-2x"></i>
                </a>

                <img class="post-img" id="<?php echo $post['id']; ?>" src="<?php echo "/uploads/posts/" . $post['filename']; ?>" id="<?php echo $post['id']; ?>">

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
                            <a href="../../edit-post.php?id=<?php echo $post['id']; ?>"><i class="far fa-edit"></i></a>
                            <a href="../posts/delete.php?id=<?php echo $post['id']; ?>"><i class="far fa-trash-alt"></i></a>
                        <?php endif; ?>

                    </div>

                </div>
                <!-- POST CAPTION -->
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
                    $date = explode(" ", $post['date_created']);
                    echo $date[0];
                    ?></p>

            </div>

        </div>

    <?php endforeach; ?>

</section>




<?php require __DIR__ . '/views/footer.php'; ?>
