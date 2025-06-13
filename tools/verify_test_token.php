<?php

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'rentals');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fungsi untuk mengambil token terakhir di database
function getLatestToken($conn) {
    $result = $conn->query("SELECT * FROM password_reset_tokens ORDER BY created_at DESC LIMIT 1");
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Ambil token terakhir
$tokenData = getLatestToken($conn);

if ($tokenData) {
    echo "Token found:\n";
    echo "ID: " . $tokenData['id'] . "\n";
    echo "Email: " . $tokenData['email'] . "\n";
    echo "Token: " . $tokenData['token'] . "\n";
    echo "Created at: " . $tokenData['created_at'] . "\n";
    echo "Expires at: " . $tokenData['expires_at'] . "\n";
    
    // Cek apakah token masih valid (belum expired)
    $now = new DateTime();
    $expires = new DateTime($tokenData['expires_at']);
    $isValid = ($now < $expires);
    
    echo "\nToken valid: " . ($isValid ? 'Yes' : 'No') . "\n";
    
    // Simulasi reset password jika token valid
    if ($isValid) {
        // Cek apakah email dari token ada di database users
        $email = $tokenData['email'];
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "\nUser found with email $email:\n";
            echo "ID: " . $user['id'] . "\n";
            echo "Name: " . $user['name'] . "\n";
            
            // Simulasi update password
            $newPassword = 'newpassword123';
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            echo "\nSimulated password update:\n";
            echo "New password: $newPassword\n";
            echo "Hashed password: $hashedPassword\n";
            
            // Uncomment baris ini untuk benar-benar mengupdate password
            // $conn->query("UPDATE users SET password = '$hashedPassword' WHERE id = " . $user['id']);
            // echo "Password was updated successfully!\n";
        } else {
            echo "\nNo user found with email: $email\n";
        }
    }
} else {
    echo "No token found in database.\n";
}

$conn->close(); 