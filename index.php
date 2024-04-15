<?php
session_start();
include('config/dbconfig.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Check if user exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Store user data in session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['email'] = $user['email'];

                    // Redirect to member page
                    header('Location: member.php');
                    exit();
                } else {
                    $error = "Invalid email or password";
                }
            } else {
                $error = "User not found";
            }
        } else {
            $error = "Invalid email format";
        }
    } else {
        $error = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('templates/header.php'); ?>

    <div class="container">
        <h2>Welcome to our website!</h2>
        <p>Here you can...</p>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <h3>Login</h3>
            <form action="index.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        <?php else: ?>
            <p>You are logged in as <?php echo $_SESSION['email']; ?></p>
        <?php endif; ?>
    </div>

    <?php include('templates/footer.php'); ?>
</body>
</html>
