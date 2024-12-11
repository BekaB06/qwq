<?php
session_start();
include 'connect.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if (isset($_POST['cancel'])) {header('Location: show.php');die('');}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_errors = array();
    
    $name = trim($_POST["name"]);
    if(empty($name)){
        $input_errors['name'] = "Please enter your name.";
    }
    
    $address = trim($_POST["address"]);
    if(empty($address)){
        $input_errors['address'] = "Please enter your address.";
    }
    
    $city = trim($_POST["city"]);
    if(empty($city)){
        $input_errors['city'] = "Please enter your city.";
    }
    
    $state = trim($_POST["state"]);
    if(empty($state)){
        $input_errors['state'] = "Please enter your state.";
    }
    
    $zip = trim($_POST["zip"]);
    if(empty($zip)){
        $input_errors['zip'] = "Please enter your zip.";
    }
    

    if(empty($input_errors)){
        $sql = "INSERT INTO shipping (shipid, name, address, city, state, zip) VALUES (?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssss", $param_shipid, $param_name, $param_address, $param_city, $param_state, $param_zip);
            
            $param_shipid = $_SESSION["username"];
            $param_name = $name;
            $param_address = $address;
            $param_city = $city;
            $param_state = $state;
            $param_zip = $zip;
            if(mysqli_stmt_execute($stmt)){
                header("location: show.php");
                exit;
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Shipping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add Shipping</h1>
        <?php if(!empty($input_errors)) { ?>
        <div>
            <ul>
                <?php foreach($input_errors as $error) { echo "<li>$error</li>"; } ?>
            </ul>
        </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>">
            </div>
            <div>
                <label>Address:</label>
                <input type="text" name="address" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : ''; ?>">
            </div>
            <div>
                <label>City:</label>
                <input type="text" name="city" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>">
            </div>
            <div>
                <label>State:</label>
                <input type="text" name="state" value="<?php echo isset($_POST["state"]) ? $_POST["state"] : ''; ?>">
            </div>
            <div>
                <label>Zip:</label>
                <input type="text" name="zip" value="<?php echo isset($_POST["zip"]) ? $_POST["zip"] : ''; ?>">
            </div>
            <br>
            <div>
                <input type="submit" class="greenbtn" value="Add Shipping">
                <br>
                <input class="redbtn" type="submit" value="Cancel" name="cancel">
            </div>
        </form>
    </div>
</body>
</html>
