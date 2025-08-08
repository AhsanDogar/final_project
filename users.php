<?php
include 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Registered Users</h2>";

// Fetch users
$result = mysqli_query($conn, "SELECT id, email, image FROM admins");
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Email</th><th>Profile Image</th><th>Actions</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>";
    if ($row['image']) {
        echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' width='50'>";
    } else {
        echo "No image";
    }
    echo "</td>";
    echo "<td>";
    echo "<a href='update_user.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete_user.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

include 'includes/footer.php';
