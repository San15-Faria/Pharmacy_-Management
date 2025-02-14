<?php
// Include the database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Plain text password (not secure in this example)

    // SQL query to select the user from the database
    $sql = "SELECT * FROM admins WHERE username = :username LIMIT 1";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters using bindValue()
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Check if the username exists
    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password (plain text comparison)
        if ($admin['password'] == $password) {
            // Password matches
            echo "Login successful!";
            header("Location: admin.php"); // Redirect to the admin page
            exit();
        } else {
            // Password does not match
            echo "Invalid password!";
        }
    } else {
        // Username not found
        echo "Invalid username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pharmacy Management</title>
    <style>
        /* General Body and Layout Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('admin.avif');  /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container for the form */
        .login-container {
            background-color: rgba(255, 255, 255, 0.85); /* Slight transparency */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            margin-left: 10px;
        }

        form input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            margin: 0 auto;
        }

        form button {
            padding: 12px;
            font-size: 16px;
            background-color: #2f7b58;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #3c9f72;
        }

        /* Error messages */
        .error {
            color: #e74c3c;
            font-size: 16px;
            margin-top: 10px;
        }

        /* Back button style */
        .back-button {
            padding: 12px;
            font-size: 16px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .back-button:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <!-- HTML Form for Admin Login -->
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

            <!-- Display error messages if any -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->rowCount() == 0) {
                    echo '<div class="error">Invalid username!</div>';
                } elseif ($stmt->rowCount() > 0 && $admin['password'] != $password) {
                    echo '<div class="error">Invalid password!</div>';
                }
            }
            ?>
        </form>

        <!-- Back Button -->
        <a href="index.html">
            <button class="back-button">Back to Home</button>
        </a>
    </div>

</body>
</html>
