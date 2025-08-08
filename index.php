<?php
include 'config/db.php';
include 'includes/header.php';

// Fetch the first content item from the content table
$result = mysqli_query($conn, "SELECT * FROM content ORDER BY id ASC LIMIT 1");
$content = mysqli_fetch_assoc($result);
?>

<!-- Main content area -->
<main>
  <?php if ($content): ?>
    <h2><?php echo htmlspecialchars($content['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($content['body'])); ?></p>
  <?php else: ?>
    <p>No content found. Please add some content to the database.</p>
  <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
