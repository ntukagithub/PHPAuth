<?php
include("connection.php");

session_start(); // Start the session

$usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    $sql = "SELECT id, username, password FROM regtb WHERE username=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row["password"];
            // echo $hashedPassword;

            if ($password == $hashedPassword) {
                $_SESSION["username"] = $username; // Store username in session

                header("location: dashboard.php");
                exit;
            } else {
                $passwordErr = "Invalid password.";
            }
        } else {
            $usernameErr = "Username not found.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <style>
         .login{
            text-align: center;
            padding-top: 2px;
            margin-top: 10px;
            font-size: 15px;

        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            /* display: flex; */
            /* justify-content: center;
            align-items: center; */
            /* height: 100vh; */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
        }
        .error {color: #FF0000;}
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            text-align: center;
            
        }

        form{
            width: 300px;
            margin: auto;
            /* border: 1px green solid; */
            padding: 20px;
            margin-top: 100px;
            border-radius: 7px;
            padding-bottom: 30px;
            box-shadow: 0px 0px 4px;
            background-color: white;

        }
    </style>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Login Form</h2>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <span class="error"><?php echo $usernameErr; ?></span>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <span class="error"><?php echo $passwordErr; ?></span>
    </div>
    <input type="submit" name="submit" value="Login">
    <div class="login">
        Don't have an account? <a href="regform.php">Register Here</a>
    </div>
</form>

</body>
</html>
