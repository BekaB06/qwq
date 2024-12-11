<?php
session_start();
 include 'connect.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to homepage.</h1>
    <h1>User information</h1>

    <p>
        <a class="ta" href="logout.php" ><input type="button" class="redbtn" value="Log Out"></a>
        <a class="ta" href="reset.php" ><input type="button" class="bluebtn" value="Reset Password"></a>
    </p>
    
    <table border="1px">
        <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Subscription</th>
            <th>edit</th>
        </tr>
        </thead>
        <?php
        $username = $_SESSION["username"];
        $sql = "SELECT username, name, surname, email, subscribe FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            echo "<tr><td>".$row['username']."</td><td>".$row['name']."</td><td>".$row['surname']."</td><td>".$row['email']."</td><td>".$row['subscribe']."</td>";
        }
        ?>
        <td><a class="ta" href="edituser.php?username=<?php echo $row['username']; ?>"><input type="button" class="bluebtns" value="Edit"></a></td>
        </tr>
    </table>
    </div>
    <div class="container">
    <h1>Billing information</h1>
    <p>
        <a class="ta" href="addbilling.php" >Add new Billing</a>
    </p>
    
    <table border="1px">
        <thead>
        <tr>
            <th>Billing ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Cardtype</th>
            <th>Cardnumber</th>
            <th>Expiry</th>
            <th>Action</th>
        </tr>
        </thead>
        <?php
        $username = $_SESSION["username"];
        $sql = "SELECT  id, billid, name, address, city, state, zip, cardtype, numer, dat FROM billing WHERE billid = '$username'";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row['billid']."</td><td>".$row['name']."</td><td>".$row['address']."</td><td>".$row['city']."</td><td>".$row['state']."</td><td>".$row['zip']."</td><td>".$row['cardtype']."</td><td>".$row['numer']."</td><td>".$row['dat']."</td>";
            echo '<td><a class="ta" href="editbilling.php?id='.$row['id'].'"><input type="button" class="bluebtns" value="Edit"></a><a class="td" href="deletebilling.php?id='.$row['id'].'"><input type="button" class="redbtns" value="Delete"></a></td>';
            echo "</tr>";
        }
        ?>
    </table>
    </div>
    <div class="container">
    <h1>Shipping information</h1>
    <p>
        <a class="ta" href="addshipping.php" >Add new Shipping</a>
    </p>
    
    <table border="1px">
        <thead>
        <tr>
            <th>Shipping ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Action</th>
        </tr>
        </thead>
        <?php
        $username = $_SESSION["username"];
        $sql = "SELECT  id, shipid, name, address, city, state, zip FROM shipping WHERE shipid = '$username'";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row['shipid']."</td><td>".$row['name']."</td><td>".$row['address']."</td><td>".$row['city']."</td><td>".$row['state']."</td><td>".$row['zip']."</td>";
            echo '<td><a class="ta" href="editshipping.php?id='.$row['id'].'"><input type="button" class="bluebtns" value="Edit"></a><a class="td" href="deleteshipping.php?id='.$row['id'].'"><input type="button" class="redbtns" value="Delete"></a></td>';
            echo "</tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>