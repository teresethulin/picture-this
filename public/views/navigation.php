<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <ul class="navbar-nav">
        <?php if (isLoggedIn()) : ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/index.php' ? 'active' : ''; ?>" href="/index.php"><i class="fas fa-camera-retro"></i></a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/profile.php' ? 'active' : ''; ?>" href="/../app/users/profile.php"><i class="far fa-user"></i></a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/upload.php' ? 'active' : ''; ?>" href="/upload.php"><i class="fas fa-plus"></i></a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/app/users/logout.php"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        <?php else : ?>
            <li>
                <a class="nav-link" href="/../login.php">Login</a>
            <?php endif; ?>
            </li><!-- /nav-item -->
    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
