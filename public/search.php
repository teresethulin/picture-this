<?php require __DIR__ . '/views/header.php';

if (!isLoggedIn()) {
    redirect('/login.php');
} ?>
<div class="feed-container">

    <h1>Search</h1>
    <form class="search-input column" method="post" action="/app/posts/search.php">
        <input type="text" class="rounded" name="search" placeholder="Please enter a username">
        <i id="search-icon" class="fas fa-search"></i>
    </form>
    <div class="search-list"></div>

</div>








<?php require __DIR__ . '/views/footer.php'; ?>
