<?php
$dbh = new PDO('sqlite:database/database.db');
$pepper = "my_secret_pepper";
$password = "my_password";

// Generate a random salt
$salt = random_bytes(22);

// Combine the password and the pepper
$peppered_password = $password . $pepper;

// Add the salt to the peppered password
$hash_input = $salt . $peppered_password;

// Hash the input using bcrypt with a cost of 12
$hashed_password = password_hash($hash_input, PASSWORD_BCRYPT, ['cost' => 12]);

// Store the salt and hashed password in the database
$stored_password = $salt . $hashed_password;

// To verify the password, retrieve the salt from the database and repeat the process
$retrieved_salt = substr($stored_password, 0, 22);
$retrieved_hashed_password = substr($stored_password, 22);

$peppered_password = $password . $pepper;
$hash_input = $retrieved_salt . $peppered_password;
$computed_hashed_password = password_hash($hash_input, PASSWORD_BCRYPT, ['cost' => 12]);

// Compare the computed hash with the stored hash to verify the password
if ($computed_hashed_password === $retrieved_hashed_password) {
    echo "Password is valid!";
} else {
    echo "Invalid password.";
}
?>