<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }
include '../db.php';
// Handle add/update/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $logo = '';
    if (!empty($_FILES['logo']['name'])) {
        $logo = time().'_'.$_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/'.$logo);
    }
    if (isset($_POST['id']) && $_POST['id']) {
        $id = intval($_POST['id']);
        $sql = "UPDATE homepage_header SET title='$title', subtitle='$subtitle'" . ($logo ? ", logo='$logo'" : "") . " WHERE id=$id";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO homepage_header (title, subtitle, logo) VALUES ('$title', '$subtitle', '$logo')";
        mysqli_query($conn, $sql);
    }
    header('Location: header.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM homepage_header WHERE id=$id");
    header('Location: header.php'); exit;
}
$headers = mysqli_query($conn, "SELECT * FROM homepage_header ORDER BY id DESC");
?>
<html><head><title>Manage Header</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<button class="back-btn" onclick="window.history.back()">&#8592; Back</button>
<div class="form-container">
    <h2>Header Values</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="">
        <label>Title:</label>
        <input type="text" name="title" required>
        <label>Subtitle:</label>
        <input type="text" name="subtitle">
        <label>Logo:</label>
        <input type="file" name="logo" accept="image/*">
        <button type="submit">Add Header</button>
    </form>
    <h3>Existing Headers</h3>
    <table border="1" width="100%"><tr><th>Title</th><th>Subtitle</th><th>Logo</th><th>Action</th></tr>
    <?php while ($row = mysqli_fetch_assoc($headers)): ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['subtitle']; ?></td>
            <td><?php if ($row['logo']) echo '<img src="../uploads/'.$row['logo'].'" height="30">'; ?></td>
            <td><a href="?delete=<?php echo $row['id']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
    </table>
</div></body></html>
