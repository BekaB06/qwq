<?php
require_once "connect.php";
 
$username = $password = $confirm_password = $name = $surname = $email = "";
$username_err = $password_err = $confirm_password_err = $name_err = $surname_err = $email_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $subscribe = $_POST['subscribe'];

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

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
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($surname_err) && empty($email_err) ){
        
        $sql = "INSERT INTO users (username, password, name, surname, email, subscribe ) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_name, $param_surname, $param_email, $subscribe);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_name = $name;
            $param_surname = $surname;
            $param_email = $email;
            $param_subscribe = $subscribe;
            
            
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            <br>
            <div>
                <label>Name</label>
                <input type="text" name="name" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
            </div>
            <br>
            <div>
                <label>Surname</label>
                <input type="text" name="surname" <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
            </div>    
            <br>
            <div>
                <label>Email</label>
                <input type="email" name="email" <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            </div>
            <br>
            <div>
                <label>Password</label>
                <input type="password" name="password" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span><?php echo $password_err; ?></span>
            </div>
            <br>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <br>
            <div>
                <label>Subscription</label>
                <br>
                <input type="radio" name="subscribe" id="subscribe" value="Yes" checked>Yes
                <br>
                <input type="radio" name="subscribe" id="subscribe" value="No">No
                <br>
                <br>
            </div>
            <div>
                <input class="greenbtn" type="submit" value="Submit">
            </div>
            <p>Already have an account? <a class="ta" href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>