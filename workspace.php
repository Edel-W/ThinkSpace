<?php
session_start();

// Require login
if (!isset($_SESSION['user_id'])) {
    header('Location: /ThinkSpace/logIn.html');
    exit;
}

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : 'User';
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ThinkSpace - Workspace</title>
  <link rel="stylesheet" href="Style/main.css" />
  <link rel="stylesheet" href="Style/workspace.css" />
</head>
<body>
  <header class="site-header">
    <h1>ThinkSpace</h1>
    <div class="header-actions">
      <span>Signed in as <?php echo $username; ?></span>
      <a class="btn" href="dashboard.php">Dashboard</a>
    </div>
  </header>

  <?php if ($status === 'empty'): ?>
    <div class="flash error">Please provide both a title and content.</div>
  <?php elseif ($status === 'saved'): ?>
    <div class="flash success">Note saved successfully.</div>
  <?php endif; ?>

  <main class="workspace-main">
    <form action="PHP/save_note.php" method="POST" class="workspace-form">
      <textarea name="title" placeholder="Title" id="title"></textarea>
      <textarea name="content" placeholder="Write your note..." id="note"></textarea>
      <input type="submit" name="save" id="save_btn" value="Save" />
    </form>
  </main>

  <script src="JS/workspace.js"></script>
</body>
</html>
