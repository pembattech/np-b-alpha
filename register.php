<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 28px;
            color: #1976d2;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 90%;
            max-width: 400px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #424242;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            font-size: 14px;
            padding: 10px;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #1976d2;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-top: 20px;
        }

        input[type="submit"] {
            font-size: 14px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #1976d2;
            color: #ffffff;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }

        p.error {
            color: #f44336;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label for="staff_id">Staff ID:</label>
                <input type="text" id="staff_id" name="staff_id" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <input type="submit" value="Register">

        </form>
        <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
    </div>
</body>
</html>