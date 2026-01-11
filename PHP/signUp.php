<?php
session_start();
require_once "config.php"; // <--- just include this file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["fullName"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Input validation
    if (empty($fullName) || empty($password)) {
        echo "All fields are required!<br>";
    } elseif (empty($confirm_password)) {
        echo "Please confirm your password.<br>";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match!<br>";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $fullName);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username already taken. Please choose another.<br>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insertStmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insertStmt->bind_param("ss", $fullName, $hashedPassword);

            if ($insertStmt->execute()) {
                $_SESSION['user_id'] = $insertStmt->insert_id;
                $_SESSION['username'] = $fullName;
                echo "Sign Up Successful! Redirecting to dashboard...";
                header("Refresh:2; url=../dashboard.php");
                exit();
            } else {
                echo "Error: " . $insertStmt->error . "<br>";
            }
            $insertStmt->close();
        }

        $stmt->close();
    }
}

$conn->close();
?>
