<?php
// Connect to MySQL server (without selecting DB yet)
$host = "localhost";
$dbUser = "root";   // your MySQL username
$dbPass = "";       // your MySQL password
$dbName = "thinkspace_db";

$conn = new mysqli($host, $dbUser, $dbPass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbName");

// Select the database
$conn->select_db($dbName);

// Create 'users' table if it doesn't exist
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)");

// Create 'notes' table if it doesn't exist
$conn->query("
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");


?>
