<?php

session_start();

require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, name, email, created_at
     FROM users
     WHERE id = ?"
);

$stmt->execute([$_SESSION["user_id"]]);

$user = $stmt->fetch();

if (!$user) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Welcome, <?php echo htmlspecialchars($user["name"]); ?>!</h1>

        <div class="profile-info">

            <p>
                <strong>Name:</strong>
                <?php echo htmlspecialchars($user["name"]); ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo htmlspecialchars($user["email"]); ?>
            </p>

            <p>
                <strong>Account Created:</strong>
                <?php echo htmlspecialchars($user["created_at"]); ?>
            </p>

        </div>

        <div class="buttons">
            <a href="logout.php" class="btn">Logout</a>
            <a href="index.php" class="btn secondary">Home</a>
        </div>

    </div>

</div>

</body>
</html>
