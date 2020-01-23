<?php

declare(strict_types=1);

require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

if(isset($_POST['profileID'])) {
    if($_POST['profileID']===$_SESSION['user']['id']) {
        redirect('/myProfile.php');
    }
    $profileID = (int) trim(filter_var($_POST['profileID'], FILTER_SANITIZE_NUMBER_INT));
} else {
    redirect('/');
}

$user = getUserById((int) $profileID, $pdo);
$avatar = $user['avatar'];
$posts = getPostsByUser((int) $profileID, $pdo);
$followers = getNumFollowers($profileID, $pdo);
$followings = getNumFollowings($profileID, $pdo);
$isFollowing = FollowByID($profileID, (int) $_SESSION['user']['id'], $pdo); ?>

<div class="profile-top-container">
    <img class="profile-avatar" src="<?php echo ($avatar !== null) ? "/uploads/avatar/" . $avatar : "/uploads/avatar/placeholder.png"; ?>">

    <div class="profile-user">

        <h1 class="profile-username" id="<?= $profileID; ?>">
            <?php echo $user['username']; ?>
        </h1>

        <p class="profile-date-created">
            Member since:
            <?php $memberSince = explode(" ", $user['date_created']);
            $date = date_create_from_format("Y-m-d", "$memberSince[0]");
            echo date_format($date, "F d, Y");
            ?>
        </p>

    </div>

</div>

<div class="follow-div">
    <?php if($isFollowing) : ?>
        <h6 class="following">Following</h6>
        <button class="follow-buttons" onclick="unfollowUser()">Unfollow</button>
    <?php else : ?>
        <button class="follow-buttons" onclick="followUser()">Follow</button>
    <?php endif; ?>
</div>

<p class="profile-bio">
    <?php echo $user['biography']; ?>
</p>

<div class="post-follow-items">
    <div class="post-follow-item">
        <h5><?= count($posts); ?></h5>
        <h6>POSTS</h6>
    </div>
    <div class="post-follow-item">
        <h5 class="numFollowers"><?= $followers; ?></h5>
        <h6>FOLLOWERS</h6>
    </div>
    <div class="post-follow-item">
        <h5><?= $followings; ?></h5>
        <h6>FOLLOWING</h6>
    </div>
</div>

<hr>

<section class="image-grid">

    <?php if (!$posts) {
        echo "No posts yet.";
    }; ?>

    <?php foreach ($posts as $post) : ?>
        <?php $postID = $post['id'];
        $likes = numberOfLikes((int) $postID, $pdo);
        $isLiked = isLiked((int) $profileID, (int) $postID, $pdo);
        // $comments = getCommentsByPostID($postID); ?>

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

                        <button class="comment-button">
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
                <?php //foreach ($comments as $comment) : ?>
                    <!-- <p><?= $comment['text']; ?></p> -->
                <?php //endforeach; ?>

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
