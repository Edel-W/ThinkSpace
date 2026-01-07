<?php
// Accept search query via POST and redirect to dashboard with query param
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = isset($_POST['query']) ? trim($_POST['query']) : '';
    $url = '/ThinkSpace/dashboard.php';
    if ($q !== '') {
        $url .= '?query=' . urlencode($q);
    }
    header('Location: ' . $url);
    exit;
}

// If accessed directly, redirect to dashboard
header('Location: /ThinkSpace/dashboard.php');
exit;
?>