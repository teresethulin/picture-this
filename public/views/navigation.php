<nav class="navbar">

    <ul>
        <?php if (isLoggedIn()) : ?>

            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/index.php' ? 'active' : ''; ?>" href="/index.php"><i class="fas fa-glasses"></i></a>
            </li>
            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/search.php' ? 'active' : ''; ?>" href="/search.php"><i class="fas fa-search"></i></a>
            </li>
            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/upload.php' ? 'active' : ''; ?>" href="/upload.php"><i class="fas fa-plus"></i></a>
            </li>
            <li>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/my-profile.php' ? 'active' : ''; ?>" href="/my-profile.php"><i class="far fa-user"></i></a>
            </li>

        <?php endif; ?>

    </ul>
</nav>
