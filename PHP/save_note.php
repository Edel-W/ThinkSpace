<?php
session_start();
require_once __DIR__ . "/config.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /ThinkSpace/logIn.html');
    exit;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ThinkSpace/workspace.php');
    exit;
}

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';

if ($title === '' || $content === '') {
    // Redirect back with an error status so the form can show feedback
    header('Location: /ThinkSpace/workspace.php?status=empty');
    exit;
}

$stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
$stmt->bind_param('iss', $_SESSION['user_id'], $title, $content);
$ok = $stmt->execute();
$stmt->close();

if ($ok) {
    header('Location: /ThinkSpace/dashboard.php');
    exit;
} else {
    // On DB error, fallback to dashboard (could be improved)
    header('Location: /ThinkSpace/dashboard.php');
    exit;
}

?>