<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database conection parameters
    require '../db/dbconn.php';

    // Function to sanitize input
    function sanitizeInput($input) {
        global $con;
        return mysqli_real_escape_string($con, $input);
    }

    // Check if keys exist in $_POST array before accessing them
    $username = isset($_POST['username']) ? sanitizeInput($_POST['username']) : '';
    $password = isset($_POST['password']) ? sanitizeInput($_POST['password']) : '';

    $sql = "SELECT * FROM users WHERE (username = '$username' or email = '$username') AND deleted = 0";

    // Execute the SQL statement
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $_SESSION['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Fetch current settings from the database
            $sqlFetchSettings = "SELECT system_name, system_profile FROM system_settings WHERE settings_id = 1";
            $result = $con->query($sqlFetchSettings);

            $currentSettings = null;
            if ($result->num_rows > 0) {
                $currentSettings = $result->fetch_assoc();
            }

            $_SESSION['system_profile'] = $currentSettings['system_profile'];
            $_SESSION['system_name'] = $currentSettings['system_name'];

            echo json_encode(['success' => true, 'role' => $row['role']]);
            exit();
        } else {
            // Password does not match
            echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
            exit();
        }
    } else {
        // User not found
        echo json_encode(['success' => false, 'message' => 'Username does not exist.']);
        exit();
    }

    // Close conection
    $con->close();
}
?>
