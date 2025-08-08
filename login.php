<?php
include 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>Email not found.</p>";
    }
    $stmt->close();
}
?>

<h2>Login</h2>
<form method="POST">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<?php include 'includes/footer.php'; ?>
