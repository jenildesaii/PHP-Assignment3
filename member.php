<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('templates/header.php'); ?>

    <div class="container">
        <h2>Welcome <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>!</h2>
        <p>Your email address: <?php echo $_SESSION['email']; ?></p>
        <p>This is the member-only page.</p>
    </div>

    <?php include('templates/footer.php'); ?>
</body>
</html>
