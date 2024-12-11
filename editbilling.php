<?php
include 'connect.php';

if (isset($_POST['cancel'])) {header('Location: show.php');die('');}

if(isset($_POST["update"])){
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $cardtype = $_POST["cardtype"];
    $numer = $_POST["numer"];
    $dat = $_POST["dat"] . "/" . substr($_POST["year"], 2);
    $sql = "UPDATE billing SET name = '$name', address = '$address', city = '$city', state = '$state', zip = '$zip', cardtype = '$cardtype', numer = '$numer', dat = '$dat' WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)){
        header("Location: show.php");
    } else{
        echo "Error updating record: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

$id = $_GET['id'];

$sql = "SELECT * FROM billing WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Billing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h2>Edit Billing</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?php echo $row["name"]; ?>"><br><br>
        <label for="address">Address:</label><br>
        <input type="text" name="address" value="<?php echo $row["address"]; ?>"><br><br>
        <label for="city">City:</label><br>
        <input type="text" name="city" value="<?php echo $row["city"]; ?>"><br><br>
        <label for="state">State:</label><br>
        <input type="text" name="state" value="<?php echo $row["state"]; ?>"><br><br>
        <label for="zip">Zip:</label><br>
        <input type="text" name="zip" value="<?php echo $row["zip"]; ?>"><br><br>
        <label for="cardtype">Card Type:</label><br>
        <select name="cardtype">
            <option value="Visa" <?php if($row["cardtype"] == "Visa") echo "selected"; ?>>Visa</option>
            <option value="MasterCard" <?php if($row["cardtype"] == "MasterCard") echo "selected"; ?>>MasterCard</option>
            <option value="American Express" <?php if($row["cardtype"] == "American Express") echo "selected"; ?>>American Express</option>
            <option value="Discover" <?php if($row["cardtype"] == "Discover") echo "selected"; ?>>Discover</option>
        </select><br><br>
        <label for="numer">Card Number:</label><br>
        <input type="text" name="numer" value="<?php echo $row["numer"]; ?>"><br><br>
        <label for="dat">Expiry:</label><br>
        <select name="dat">
            <?php
            for($i = 1; $i <= 12; $i++){
                $month = str_pad($i, 2, "0", STR_PAD_LEFT);
                echo "<option value='$month'";
                if($row["dat"] == $month) echo "selected";
                echo ">$month</option>";
            }
            ?>
        </select>
        <select name="year">
            <?php
            for($i = date("Y"); $i < date("Y") + 11; $i++){
                echo "<option value='$i'";
                if($row["dat"] == $i) echo "selected";
                echo ">$i</option>";
            }
            ?>
        </select><br><br><br>
        <input class="greenbtn" type="submit" name="update" value="Update">
        <br>
        <input class="redbtn" type="submit" value="Cancel" name="cancel">
    </form>
    </div>
</body>
</html>
