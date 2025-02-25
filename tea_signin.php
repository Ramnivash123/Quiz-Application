<?php
session_start();

include 'db.php';

// Initialize variables
$email = '';
$password = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and execute SQL statement to fetch user data from the "signup" table
    $stmt = $conn->prepare("SELECT * FROM tea_signup WHERE em = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if (password_verify($password, $result['pass'])) {
            // Password is correct, redirect to teacher.html
            $_SESSION['teacher_name'] = $result['na'];
            header("Location: teacherr.php");
            exit();
        } else {
            $error_message = "Invalid email or password";
        }
    } else {
        $error_message = "Invalid email or password";
    }
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #1a73e8;
            font-size: 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            background-color: #f1f3f4;
            border: none;
            border-radius: 4px;
            color: #3c4043;
            font-size: 16px;
            padding: 12px;
            margin-bottom: 16px;
            transition: background-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            background-color: #e8f0fe;
            outline: none;
        }

        input[type="submit"] {
            background-color: #1a73e8;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            padding: 12px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #1765cc;
        }

        .error {
            color: #d93025;
            font-size: 14px;
            margin-top: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Teacher Sign In</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Sign In">

            <?php
            if ($error_message) {
                echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
            }
            ?>
        </form>
    </div>
</body>
</html>