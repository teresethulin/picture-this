<nav class="navbar">

    <ul>
        <?php if (isLoggedIn()) : ?>

            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/index.php' ? 'active' : ''; ?>" href="/index.php"><i class="fas fa-camera-retro"></i></a>
            </li>

            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/upload.php' ? 'active' : ''; ?>" href="/upload.php"><i class="fas fa-plus"></i></a>
            </li>

            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/profile.php' ? 'active' : ''; ?>" href="/../app/users/profile.php"><i class="far fa-user"></i></a>
            </li>

        <?php endif; ?>

    </ul>
</nav>
