<?php
include 'config/db.php';
include 'includes/header.php';

// Fetch all content (e.g., about page)
$result = mysqli_query($conn, "SELECT * FROM content");
?>

<!-- About Page Content -->
<main>
  <h1>About Page</h1>

  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <article>
      <h2><?php echo htmlspecialchars($row['title']); ?></h2>
      <p><?php echo nl2br(htmlspecialchars($row['body'])); ?></p>
    </article>
    <hr>
  <?php endwhile; ?>

  <!-- If logged in, show link to manage content -->
  <?php if (isset($_SESSION['email'])): ?>
    <p><a href="content_manage.php">Manage Website Content</a></p>
  <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
