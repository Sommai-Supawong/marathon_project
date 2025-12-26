<?php
// Script to update plain text passwords to hashed passwords
session_start();
include 'config/db.php';

echo "Starting password update process...\n";

// Select all users to update their passwords
$sql = "SELECT user_id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");

    while($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        $current_password = $row['password'];
        
        // Check if password is already hashed (by checking if it starts with $, which is typical for PHP password_hash)
        if (substr($current_password, 0, 1) !== '$') {
            // This is a plain text password, need to hash it
            $hashed_password = password_hash($current_password, PASSWORD_DEFAULT);
            
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($update_stmt->execute()) {
                echo "Updated password for user ID: $user_id\n";
            } else {
                echo "Error updating password for user ID: $user_id - " . $conn->error . "\n";
            }
        } else {
            echo "Password for user ID: $user_id is already hashed, skipping...\n";
        }
    }
    
    $update_stmt->close();
    echo "Password update process completed!\n";
} else {
    echo "No users found in the database.\n";
}

$conn->close();
?>