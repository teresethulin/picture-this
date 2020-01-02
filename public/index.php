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
        <img class="avatar" src="<?php echo ($post['avatar'] !== null) ? "/uploads/avatar/" . $post['avatar'] : "/uploads/avatar/placeholder.png"; ?>">
        <h3><?php echo $post['username']; ?></h3>
        <img class="post-img" src="<?php echo '/uploads/posts/' . $post['filename']; ?>" id="<?php echo $post['id']; ?>">
        <button class="like">
            <i class="far fa-heart"></i>
            <i class="fas fa-heart"></i>
        </button>
        <button class="comment">
            <i class="far fa-comment-alt"></i>
        </button>
        <?php if (($_SESSION['user']['id'] === $post['user_id'])) : ?>
            <a href="../../edit-post.php?id=<?php echo $post['id']; ?>"><i class="far fa-edit"></i></a>
            <a href="../posts/delete.php?id=<?php echo $post['id']; ?>"><i class="far fa-trash-alt"></i></a>
        <?php endif; ?>
        <p><?php echo $post['caption']; ?></p>
        <br>
    <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
