<?php
    echo "You are in the right file";
    if($_SERVER["REQUEST_METHOD"] == "post") {
        $fullName = $_POST["fullName"];
        $password = $_POST["password"];
        $comfirm_passowrd = $_POST["confirm_password"];
        if(empty(trim($fullName)) || empty($password)) {
            echo "All fields are required to be filled!";
        }
        if(empty($comfirm_passowrd)) {
            echo "Please confirm your password.";
        }
        else {
            echo "Sign Up Successful!";
        }
    }
?>