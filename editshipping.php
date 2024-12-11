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
    $sql = "UPDATE shipping SET name = '$name', address = '$address', city = '$city', state = '$state', zip = '$zip' WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)){
        header("Location: show.php");
    } else{
        echo "Error updating record: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

$id = $_GET['id'];

$sql = "SELECT * FROM shipping WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Shipping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h2>Edit Shipping</h2>
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
        <input class="greenbtn" type="submit" name="update" value="Update">
        <br>
        <input class="redbtn" type="submit" value="Cancel" name="cancel">
    </form>
    </div>
</body>
</html>
