<?php require __DIR__ . '/../../views/header.php'; ?>

<h1>
    <?php echo $_SESSION['user']['username']; ?>
</h1>

<p>
    <?php echo $_SESSION['user']['full_name']; ?>
</p>

<p>
    <?php echo $_SESSION['user']['biography']; ?>
</p>

<?php require __DIR__ . '/../../views/footer.php'; ?>
