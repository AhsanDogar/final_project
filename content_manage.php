<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Handle add new content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_content'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $sql = "INSERT INTO content (title, body) VALUES ('$title', '$body')";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='text-success'>Content added successfully.</p>";
    } else {
        echo "<p class='text-danger'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Handle delete content
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM content WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: content_manage.php");
    exit();
}

// Fetch all content
$result = mysqli_query($conn, "SELECT * FROM content ORDER BY id ASC");
?>

<main class="container my-5">
    <h1>Manage Website Content</h1>

    <!-- Add new content form -->
    <h2>Add New Content</h2>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body:</label>
            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
        </div>
        <input type="submit" name="add_content" value="Add Content" class="btn btn-primary">
    </form>

    <!-- Existing content list -->
    <h2>Existing Content</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($content = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($content['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($content['body'])); ?></td>
                        <td>
                            <a href="content_edit.php?id=<?php echo $content['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="content_manage.php?delete=<?php echo $content['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No content found.</p>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
