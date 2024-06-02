<?php
  include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
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
    <script>
        function validateForm() {
            var username = document.forms["registration"]["username"].value;
            var email = document.forms["registration"]["email"].value;
            var password = document.forms["registration"]["password"].value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var errors = [];

            if (username === "") {
                errors.push("Username must be filled out");
            }
            if (email === "") {
                errors.push("Email must be filled out");
            } else if (!emailPattern.test(email)) {
                errors.push("Invalid email format");
            }
            if (password === "") {
                errors.push("Password must be filled out");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<?php
$usernameErr = $emailErr = $passwordErr = "";
$username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $isValid = false;
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $isValid = false;
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $isValid = false;
    } else {
        $password = test_input($_POST["password"]);
    }

    if ($isValid) {
        if(isset($_POST["submit"])) {
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $sql="INSERT INTO regtb(username,email,password) VALUES('$username','$email','$password')";
            $result = mysqli_query($conn,$sql);
            if($result)
            {
                setcookie("username",$username,time()+ 0*24*0);
                setcookie("email",$email,time()+ 0*24*0);

                echo "the data is succesfull inserted into the datbse table";
                $username = $email = $password = "";
            }

            else{
                echo "fail to insert data into the daabse so tr again";
            }
        }
      
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>



<form name="registration" method="post" action="regform.php" onsubmit="return validateForm()">
<h2>Registration Form</h2>
    Username: <input type="text" name="username" value="<?php echo $username;?>">
    <span class="error"> <?php echo $usernameErr;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error"> <?php echo $emailErr;?></span>
    <br><br>
    Password: <input type="password" name="password" value="<?php echo $password;?>">
    <span class="error"> <?php echo $passwordErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Register">
    <div class="login">I have an account?<a href="login.php"> LOgin</a></div>
    
</form>

</body>
</html>
