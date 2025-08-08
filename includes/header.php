<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta tags for responsiveness and encoding -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Final Project</title>
  <!-- Link to external CSS stylesheet -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<!-- Header section with logo and navigation menu -->
<header>
  <div class="logo">
    <h1>My Website</h1>
  </div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <?php if (isset($_SESSION['email'])): ?>
      <a href="users.php">Manage Users</a>
      <a href="content_manage.php">Manage Content</a>
      <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['email']); ?>)</a>
    <?php else: ?>
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
</header>

<!-- Separator line -->
<hr>
