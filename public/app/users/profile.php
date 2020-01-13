<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);
$avatar = $user['avatar'];

$posts = getPostsByUser((int) $userID, $pdo);

?>

<div class="profile-top-container">

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
            ?></p>

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

    <?php $post = $posts[0]; ?>

    <?php foreach ($posts as $post) : ?>

        <a href="post.php?id=<?php echo $post['id']; ?>">

            <img class="post-thumbnail" src="<?php echo "/uploads/posts/" . $post['filename']; ?>" id="<?php echo $post['id']; ?>">

        </a>

    <?php endforeach; ?>

</section>

<?php require __DIR__ . '/../../views/footer.php'; ?>
