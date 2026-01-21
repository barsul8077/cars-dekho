<?php
session_start();
include '../db.php';
// Simple login check
if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if ($user === 'admin' && $pass === 'admin123') {
            $_SESSION['admin'] = true;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    }
    ?>
    <html><head><title>Admin Login</title><link rel="stylesheet" href="../assets/style.css"></head><body>
    <div class="form-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div></body></html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/dashboard.css">
</head>
<body>
    <div class="dashboard-header">
        <div class="logo">Admin Dashboard</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="header.php">Header</a>
            <a href="banner.php">Banners</a>
            <a href="cars.php">Cars</a>
            <a href="footer.php">Footer</a>
            <a href="index.php?logout=1">Logout</a>
        </nav>
    </div>
    <div class="dashboard-container">
        <h2 class="dashboard-title">Manage Homepage Content</h2>
        <ul>
            <li><a href="header.php">Header</a></li>
            <li><a href="banner.php">Banners</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="footer.php">Footer</a></li>
        </ul>
    </div>
</body>
</html>
<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
