<?php

declare(strict_types=1);

if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pdo = new PDO('sqlite:picture-this.db');
    $query = sprintf("INSERT INTO user (email) VALUES ('%s')", $email);
    $statement = $pdo->query($query);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up</title>
    <style>
        input {
            display: block;
            margin-bottom: 10px;
            min-width: 200px;
        }
    </style>
</head>

<body>

    <h1>
        Picture This
    </h1>
    <form action="signup.php" method="post">
        <h2>
            Sign up to see photos from your friends.
        </h2>
        <div>
            <input type="text" name="email" id="email" placeholder="Email" required>
            <input type="text" name="full-name" id="full-name" placeholder="Full name" required>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="text" name="password" id="password" placeholder="Password" required>
        </div>

        <button type="submit">Sign up</button>
    </form>
    <section>
        <h2>
            Have an account? <a href="login.php">Log in</a>
        </h2>
    </section>
</body>

</html>
