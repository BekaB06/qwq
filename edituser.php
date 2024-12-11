<?php
session_start();
include 'connect.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if (isset($_POST['cancel'])) {header('Location: show.php');die('');}


$name = $surname = $email = $subscribe = "";
$name_err = $surname_err = $email_err = $subscribe_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    if(empty(trim($_POST["surname"]))){
        $surname_err = "Please enter a surname.";     
    } else{
        $surname = trim($_POST["surname"]);
    }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";     
    } else{
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["subscribe"]))){
        $subscribe_err = "Please select a subscribe option.";     
    } else{
        $subscribe = trim($_POST["subscribe"]);
    }
    
    if(empty($name_err) && empty($surname_err) && empty($email_err) && empty($subscribe_err)){
        $sql = "UPDATE users SET name = ?, surname = ?, email = ?, subscribe = ? WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_surname, $param_email, $param_subscribe, $param_username);
            
            $param_username = $_SESSION["username"];
            $param_name = $name;
            $param_surname = $surname;
            $param_email = $email;
            $param_subscribe = $subscribe;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: show.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
} else{
    $sql = "SELECT name, surname, email, subscribe FROM users WHERE username = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_bind_result($stmt, $name, $surname, $email, $subscribe);
            if(mysqli_stmt_fetch($stmt)){
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <p>Please fill out this form to edit your user information.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div>
                <label>Name</label>
                <input type="text" name="name" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span><?php echo $name_err; ?></span>
            </div>
            <br>
            <div>
                <label>Surname</label>
                <input type="text" name="surname" <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                <span><?php echo $surname_err; ?></span>
            </div>
            <br>
            <div>
                <label>Email</label>
                <input type="email" name="email" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span><?php echo $email_err; ?></span>
            </div>
            <br>
            <div>
                <label>Subscribe</label>
                <div>
                    <input type="radio" name="subscribe" id="Yes" value="Yes" <?php if($subscribe == "Yes") echo "checked"; ?>>
                    <label for="Yes">Yes</label>
                </div>
                <div>
                    <input type="radio" name="subscribe" id="No" value="No" <?php if($subscribe == "No") echo "checked"; ?>>
                    <label for="No">No</label>
                </div>
                <span><?php echo $subscribe_err; ?></span>
            </div>
            <br>
            <div>
                <input class="greenbtn" type="submit" value="Submit">
                <br>
                <input class="redbtn" type="submit" value="Cancel" name="cancel">
            </div>
        </form>
    </div>    
</body>
</html>
