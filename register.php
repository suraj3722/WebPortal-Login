<?php

require_once "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Server-side validation
    if ($name === "" || $email === "" || $password === "") {

        $error = "All fields are required.";

    } elseif (mb_strlen($name) < 2) {

        $error = "Name must be at least 2 characters long.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters long.";

    } else {

        // Check duplicate email
        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1"
        );

        $stmt->execute([$email]);

        if ($stmt->fetch()) {

            $error = "An account with this email already exists.";

        } else {

            // Hash password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert user
            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $name,
                strtolower($email),
                $hashedPassword
            ]);

            $success = "Registration successful! You can now login.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="form-card">

        <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()" autocomplete="off">

            <div class="form-group">
                <label for="name">Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    autocomplete="off"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    autocomplete="off"
                    autocapitalize="none"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="btn">
                Register
            </button>

        </form>

        <p class="center">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

        <p class="center">
            <a href="index.php">Back to Home</a>
        </p>

    </div>

</div>

<script>

function validateForm() {

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

    if (name === "" || email === "" || password === "") {
        alert("Please fill in all fields.");
        return false;
    }

    if (name.length < 2) {
        alert("Name must be at least 2 characters long.");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    return true;
}

</script>

</body>
</html>
