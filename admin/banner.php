<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }
include '../db.php';
// Handle add/update/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alt = mysqli_real_escape_string($conn, $_POST['alt_text']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
    }
    if (isset($_POST['id']) && $_POST['id']) {
        $id = intval($_POST['id']);
        $sql = "UPDATE homepage_banners SET alt_text='$alt', link='$link'" . ($image ? ", image='$image'" : "") . " WHERE id=$id";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO homepage_banners (image, link, alt_text) VALUES ('$image', '$link', '$alt')";
        mysqli_query($conn, $sql);
    }
    header('Location: banner.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM homepage_banners WHERE id=$id");
    header('Location: banner.php'); exit;
}
$banners = mysqli_query($conn, "SELECT * FROM homepage_banners ORDER BY id DESC");
?>
<html><head><title>Manage Banners</title><link rel="stylesheet" href="../assets/dashboard.css"></head><body>
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
    <h2>Banner Section</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="">
        <label>Banner Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <label>Alt Text:</label>
        <input type="text" name="alt_text" required>
        <label>Link (optional):</label>
        <input type="text" name="link">
        <button type="submit">Add Banner</button>
    </form>
    <h3>Existing Banners</h3>
    <table border="1" width="100%"><tr><th>Image</th><th>Alt Text</th><th>Link</th><th>Action</th></tr>
    <?php while ($row = mysqli_fetch_assoc($banners)): ?>
        <tr>
            <td><?php if ($row['image']) echo '<img src="../uploads/'.$row['image'].'" height="30">'; ?></td>
            <td><?php echo $row['alt_text']; ?></td>
            <td><?php echo $row['link']; ?></td>
            <td><a href="?delete=<?php echo $row['id']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
    </table>
</div></body></html>
