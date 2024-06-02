<?php

include("connection.php");

?>

<?php
session_start(); // Start the session

if (!isset($_SESSION["username"])) {
    header("location: login.php"); // Redirect if not logged in
    exit;
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>

        body{
            padding: 0;
            margin: 0;
        }
        .welcome{
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            /* background-color: green;
             */
            background-color: #4CAF50;
            color: white;
            padding: 2px;
            width: 100%;
            margin-top: 0px;
            height: 10vh;
            font-family: Arial, Helvetica, sans-serif;

            }
        
    </style>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            width: 250px;
            margin: auto;
            margin-top: 20px;
            padding:30px;
            /* border: 1px solid #ccc; */
            border-radius: 7px 7px 0px 0px;
            background-color: white;
            /* box-shadow: 0px 0px 4px; */
            border: #4CAF50 1px solid;

        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }

        h3{
            font-size: 20px;
            text-align: center;
        }

        .answer{
            padding:30px;
            background-color: #4CAF50;
            color: white;
            border-radius: 0px 0px 7px 7px;
            width: 250px;
            margin: auto;
            text-align: center;
            font-size: 20px;
            border: #4CAF50 1px solid;

        }
    </style>
</head>
<body>

<div class="welcome"> <h3><?php echo $username; ?></h3></div>

<form id="calculatorForm">
    <h3>Simple Calculator</h3>
    <label for="num1">Number 1:</label>
    <input type="number" id="num1" name="num1" required>
    <br>
    <label for="num2">Number 2:</label>
    <input type="number" id="num2" name="num2" required>
    <br>
    <button type="submit">Calculate Product</button>
</form>

<?php
if(isset($_POST['num1']) && isset($_POST['num2'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    
    // Perform the calculation
    $product = $num1 * $num2;
    
    // Send the product back to the client
    
    echo $product;
    
    $num1=$num2="";
} else {
    // echo "Error: Invalid input";
}
?>


<div id="result" class="answer"></div>


<script>
$(document).ready(function(){
    $('#calculatorForm').submit(function(event){
        event.preventDefault(); // Prevent form submission
        
        var num1 = $('#num1').val();
        var num2 = $('#num2').val();
        
        $.ajax({
            type: 'POST',
            url: 'calculate.php',
            data: { num1: num1, num2: num2 },
            success: function(response){
                $('#result').html('Product: ' + response);
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

</body>
</html>



