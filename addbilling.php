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
    
    $cardtype = trim($_POST["cardtype"]);
    if(empty($cardtype)){
        $input_errors['cardtype'] = "Please select your card type.";
    }
    
    $numer = trim($_POST["numer"]);
    if(empty($numer)){
        $input_errors['numer'] = "Please enter your card number.";
    }
    
    $dat = trim($_POST["dat"]);
    if(empty($dat)){
        $input_errors['dat'] = "Please enter your card expiry date.";
    }
    
    if(empty($input_errors)){
        $sql = "INSERT INTO billing (billid, name, address, city, state, zip, cardtype, numer, dat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_billid, $param_name, $param_address, $param_city, $param_state, $param_zip, $param_cardtype, $param_numer, $param_dat);
            
            $param_billid = $_SESSION["username"];
            $param_name = $name;
            $param_address = $address;
            $param_city = $city;
            $param_state = $state;
            $param_zip = $zip;
            $param_cardtype = $cardtype;
            $param_numer = $numer;
            $dat = $_POST["dat"] . "/" . substr($_POST["year"], 2);
            $param_dat = $dat;
            
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
    <title>Add Billing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add Billing</h1>
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
            <div>
                <label>Card Type:</label>
                <select name="cardtype">
                    <option value="Visa" <?php if(isset($_POST["cardtype"]) && $_POST["cardtype"] == "Visa") echo "selected"; ?>>Visa</option>
                    <option value="MasterCard" <?php if(isset($_POST["cardtype"]) && $_POST["cardtype"] == "MasterCard") echo "selected"; ?>>MasterCard</option>
                    <option value="American Express" <?php if(isset($_POST["cardtype"]) && $_POST["cardtype"] == "American Express") echo "selected"; ?>>American Express</option>
                    <option value="Discover" <?php if(isset($_POST["cardtype"]) && $_POST["cardtype"] == "Discover") echo "selected"; ?>>Discover</option>
                </select>
            </div>
            <div>
                <label>Card Number:</label>
                <input type="text" name="numer" value="<?php echo isset($_POST["numer"]) ? $_POST["numer"] : ''; ?>">
            </div>
            <div>
            <label for="dat">Expiry:</label><br>
        <select name="dat">
            <?php
            for($i = 1; $i <= 12; $i++){
                $month = str_pad($i, 2, "0", STR_PAD_LEFT);
                echo "<option value='$month'";
                echo ">$month</option>";
            }
            ?>
        </select>
        <select name="year">
            <?php
            for($i = date("Y"); $i < date("Y") + 11; $i++){
                echo "<option value='$i'";
                echo ">$i</option>";
            }
            ?>
        </select><br><br><br>
            </div>
            <br>
            <div>
                <input type="submit" class="greenbtn" value="Add Billing">
                <br>
                <input class="redbtn" type="submit" value="Cancel" name="cancel">
            </div>
        </form>
    </div>
</body>
</html>
