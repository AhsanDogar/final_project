<?php
include 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Simple validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Invalid email format.</p>";
    } elseif ($password !== $confirm_password) {
        echo "<p>Passwords do not match.</p>";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "<p>Email already registered.</p>";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Handle image upload
            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $target_file = $target_dir . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            }

            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO admins (email, password, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $hashed_password, $imageName);
            if ($stmt->execute()) {
                echo "<p>Registration successful. <a href='login.php'>Login here</a>.</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
        }
        $stmt->close();
    }
}
?>

<h2>Register</h2>
<form method="POST" enctype="multipart/form-data">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Confirm Password: <input type="password" name="confirm_password" required><br><br>
    Profile Image: <input type="file" name="image" accept="image/*"><br><br>
    <input type="submit" value="Register">
</form>

<?php include 'includes/footer.php'; ?>
