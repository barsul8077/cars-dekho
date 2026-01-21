<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }
include '../db.php';
// Handle add/update/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    if (isset($_POST['id']) && $_POST['id']) {
        $id = intval($_POST['id']);
        $sql = "UPDATE homepage_footer SET content='$content' WHERE id=$id";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO homepage_footer (content) VALUES ('$content')";
        mysqli_query($conn, $sql);
    }
    header('Location: footer.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM homepage_footer WHERE id=$id");
    header('Location: footer.php'); exit;
}
$footers = mysqli_query($conn, "SELECT * FROM homepage_footer ORDER BY id DESC");
?>
<html><head><title>Manage Footer</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<button class="back-btn" onclick="window.history.back()">&#8592; Back</button>
<div class="form-container">
    <h2>Footer Section</h2>
    <form method="post">
        <input type="hidden" name="id" value="">
        <label>Footer Content:</label>
        <textarea name="content" required></textarea>
        <button type="submit">Add Footer</button>
    </form>
    <h3>Existing Footers</h3>
    <table border="1" width="100%"><tr><th>Content</th><th>Action</th></tr>
    <?php while ($row = mysqli_fetch_assoc($footers)): ?>
        <tr>
            <td><?php echo $row['content']; ?></td>
            <td><a href="?delete=<?php echo $row['id']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
    </table>
</div></body></html>
