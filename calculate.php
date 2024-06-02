
<?php
if(isset($_POST['num1']) && isset($_POST['num2'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    
    // Perform the calculation
    $product = $num1 * $num2;
    
    // Send the product back to the client
    echo $product;
} else {
    echo "Error: Invalid input";
}
?>