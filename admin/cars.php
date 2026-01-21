<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }
include '../db.php';
// Handle add/update/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
    }
    if (isset($_POST['id']) && $_POST['id']) {
        $id = intval($_POST['id']);
        $sql = "UPDATE cars SET name='$name', type='$type', description='$desc'" . ($image ? ", image='$image'" : "") . " WHERE id=$id";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO cars (name, image, type, description) VALUES ('$name', '$image', '$type', '$desc')";
        mysqli_query($conn, $sql);
    }
    header('Location: cars.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM cars WHERE id=$id");
    header('Location: cars.php'); exit;
}
$cars = mysqli_query($conn, "SELECT * FROM cars ORDER BY id DESC");
?>
<html><head><title>Manage Cars</title><link rel="stylesheet" href="../assets/dashboard.css"></head><body>
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
    <h2>Car Section</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="">
        <label>Car Name:</label>
        <input type="text" name="name" required>
        <label>Type:</label>
        <select name="type" required>
            <option value="most_searched">Most Searched</option>
            <option value="latest">Latest</option>
        </select>
        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <label>Description:</label>
        <textarea name="description"></textarea>
        <button type="submit">Add Car</button>
    </form>
    <h3>Existing Cars</h3>
    <table border="1" width="100%"><tr><th>Name</th><th>Type</th><th>Image</th><th>Description</th><th>Action</th></tr>
    <?php while ($row = mysqli_fetch_assoc($cars)): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php if ($row['image']) echo '<img src="../uploads/'.$row['image'].'" height="30">'; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><a href="?delete=<?php echo $row['id']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
    </table>
</div></body></html>
