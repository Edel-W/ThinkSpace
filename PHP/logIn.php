<?php
session_start();
require_once "config.php";

// Show errors while developing (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Basic validation
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {

        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {

            // Login success
            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;

            // Prefer absolute path to avoid relative-path issues from this script location
            $dashboardUrl = '/ThinkSpace/dashboard.php';

            if (!headers_sent()) {
                header("Location: " . $dashboardUrl);
                exit;
            } else {
                // If headers already sent (whitespace/BOM or other output), use JS fallback
                echo "<script>window.location.href='" . $dashboardUrl . "';</script>";
                exit;
            }

        } else {
            echo "Incorrect password.";
        }

    } else {
        echo "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>
