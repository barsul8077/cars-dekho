<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Selection Form</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <button class="back-btn" onclick="window.history.back()">&#8592; Back</button>
    <div class="form-container">
        <h2>Choose Your Car</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            $car_options = isset($_POST['car_options']) ? implode(',', $_POST['car_options']) : '';
            $sql = "INSERT INTO customer_responses (name, phone, email, address, car_options) VALUES ('$name', '$phone', '$email', '$address', '$car_options')";
            if (mysqli_query($conn, $sql)) {
                echo '<div class="success">Thank you! Your response has been submitted.</div>';
            } else {
                echo '<div class="error">Error: ' . mysqli_error($conn) . '</div>';
            }
        }
        ?>
        <form method="post" class="car-form">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Phone Number:</label>
            <input type="text" name="phone" required pattern="[0-9]{10}">
            <label>Email Id:</label>
            <input type="email" name="email" required>
            <label>Address:</label>
            <textarea name="address" required></textarea>
            <label>Car Options:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="car_options[]" value="Hatchback"> Hatchback</label>
                <label><input type="checkbox" name="car_options[]" value="Sedan"> Sedan</label>
                <label><input type="checkbox" name="car_options[]" value="SUV"> SUV</label>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
