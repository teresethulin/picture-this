<?php

declare(strict_types=1);

require __DIR__ . '/../../views/header.php';

if (!isLoggedIn()) {
    redirect('/');
}

// Include user and userID
$userID = (int) $_SESSION['user']['id'];
$user = getUserById((int) $userID, $pdo);

$posts = getPostsByUser((int) $userID, $pdo);

?>

<h1>
    <?php echo $user['username']; ?>
</h1>

<p>
    <?php echo $user['full_name']; ?>
</p>

<p>
    <?php echo $user['biography']; ?>
</p>

<button class="edit-profile" type="button">Edit profile</button>

<section class="image-grid">
    <?php foreach ($posts as $post) : ?>
        <img src="<?php echo "/../../uploads/" . $post['filename']; ?>">
        <p><?php echo $post['caption']; ?></p>
    <?php endforeach; ?>
</section>

<?php require __DIR__ . '/../../views/footer.php'; ?>
