<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: logIn.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThinkSpace - Dashboard</title>
    <link rel="stylesheet" href="Style/main.css">
    <link rel="stylesheet" href="Style/dashboard.css">
</head>
<body>
    <h2>ThinkSpace</h2>
    <p id="motto">Your thoughts, organized</p>

    <form method="post" action="PHP/search_notes.php" class="search_form">
        <input type="search" name="query" placeholder="Search your notes here..." id="search_box">
        <input type="submit" value="Search" id="search_btn">
        <a class="btn" id="addNote_btn" href="workspace.html">Add note</a>
    </form>

    <div class="notes_grid" id="notes_container">
        <?php
        require_once __DIR__ . '/PHP/config.php';
        $notes = [];
        if (isset($_GET['query']) && $_GET['query'] !== '') {
            $q = '%' . $_GET['query'] . '%';
            $stmt = $conn->prepare("SELECT id, title, content, created_at FROM notes WHERE user_id = ? AND title LIKE ? ORDER BY created_at DESC");
            $stmt->bind_param('is', $_SESSION['user_id'], $q);
        } else {
            $stmt = $conn->prepare("SELECT id, title, content, created_at FROM notes WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->bind_param('i', $_SESSION['user_id']);
        }
        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result($nid, $ntitle, $ncontent, $ncreated);
            while ($stmt->fetch()) {
                $notes[] = ['id'=>$nid,'title'=>$ntitle,'content'=>$ncontent,'created_at'=>$ncreated];
            }
            $stmt->close();
        }

        if (count($notes) === 0) {
            ?>
            <div class="empty_state" id="emptyState">
                <h3>No Notes</h3>
                <p>Add your first note by clicking the "Add" button.</p>
            </div>
            <?php
        } else {
            foreach ($notes as $note) {
                echo '<div class="notes_card">';
                echo '<h3>' . htmlspecialchars($note['title'], ENT_QUOTES, 'UTF-8') . '</h3>';
                echo '<p>' . nl2br(htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8')) . '</p>';
                echo '<p>' . date('m/d/Y', strtotime($note['created_at'])) . '</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
