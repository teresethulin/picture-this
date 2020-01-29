<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$avatar = $user['avatar'];

$posts = getPostsByUser((int) $userID, $pdo);

?>

<div class="profile-top-container">
<div class="dummy-user-div" id="<?= $userID; ?>"><?= $_SESSION['user']['username']; ?></div>

    <img class="profile-avatar" src="<?php echo ($avatar !== null) ? "/uploads/avatar/" . $avatar : "/uploads/avatar/placeholder.png"; ?>">

    <div class="profile-user">

        <h1 class="profile-username">
            <?php echo $user['username']; ?>
        </h1>

        <p class="profile-date-created">
            Member since:
            <?php $memberSince = explode(" ", $user['date_created']);
            $date = date_create_from_format("Y-m-d", "$memberSince[0]");
            echo date_format($date, "F d, Y");
            ?>
        </p>

        <button class="edit-profile-button" type="button">Edit profile</button>

    </div>

</div>

<p class="profile-bio">
    <?php echo $user['biography']; ?>
</p>

<hr>

<section class="image-grid">

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
                            <a href="edit-post.php?id=<?php echo $post['id']; ?>&return=my-profile.php"><i class="far fa-edit"></i></a>
                            <a href="app/posts/delete.php?id=<?php echo $post['id']; ?>&return=my-profile.php"><i class="far fa-trash-alt"></i></a>
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
