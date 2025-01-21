<?php

require_once 'connection.php'; // Database connection

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch the user data
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email exists in the database
    if ($result->num_rows > 0) {
        // Fetch the user record
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session and redirect to dashboard
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "Login successful!";

            header("Location: index.php");
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

} else {
    die("Invalid request method. Please submit the form correctly.");
}
?>