<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarsDekho - Home</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/home.css">
</head>
<body>
    <?php
    // Fetch header
    $header = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM homepage_header ORDER BY id DESC LIMIT 1"));
    // Fetch banners
    $banners = mysqli_query($conn, "SELECT * FROM homepage_banners ORDER BY id DESC");
    // Fetch most searched cars
    $most_searched = mysqli_query($conn, "SELECT * FROM cars WHERE type='most_searched' ORDER BY id DESC LIMIT 6");
    // Fetch latest cars
    $latest = mysqli_query($conn, "SELECT * FROM cars WHERE type='latest' ORDER BY id DESC LIMIT 6");
    // Fetch footer
    $footer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM homepage_footer ORDER BY id DESC LIMIT 1"));
    ?>
    <button class="back-btn" onclick="window.history.back()">&#8592; Back</button>
    <!-- Header -->
    <header class="main-header">
        <div class="logo">
            <?php if (!empty($header['logo'])): ?>
                <img src="uploads/<?php echo $header['logo']; ?>" alt="Logo" height="40">
            <?php endif; ?>
            <span><?php echo $header['title'] ?? 'CarsDekho'; ?></span>
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="form.php">Car Selection</a>
            <a href="admin/">Admin</a>
        </nav>
    </header>
    <!-- Banner Section -->
    <section class="banner-section">
        <?php while ($banner = mysqli_fetch_assoc($banners)): ?>
            <div class="banner">
                <img src="uploads/<?php echo $banner['image']; ?>" alt="<?php echo $banner['alt_text']; ?>">
            </div>
        <?php endwhile; ?>
    </section>
    <!-- Most Searched Cars -->
    <section class="car-section">
        <h2>Most Searched Cars</h2>
        <div class="car-list">
            <?php while ($car = mysqli_fetch_assoc($most_searched)): ?>
                <div class="car-card">
                    <img src="uploads/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
                    <h3><?php echo $car['name']; ?></h3>
                    <p><?php echo $car['description']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <!-- Latest Cars -->
    <section class="car-section">
        <h2>Latest Cars</h2>
        <div class="car-list">
            <?php while ($car = mysqli_fetch_assoc($latest)): ?>
                <div class="car-card">
                    <img src="uploads/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>">
                    <h3><?php echo $car['name']; ?></h3>
                    <p><?php echo $car['description']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <!-- Footer -->
    <footer class="main-footer">
        <div><?php echo $footer['content'] ?? '© 2026 CarsDekho. All rights reserved.'; ?></div>
    </footer>
</body>
</html>
