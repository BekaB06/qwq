<?php
require_once "connect.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM billing WHERE id = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        if(mysqli_stmt_execute($stmt)){
            header("location: show.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else{
    header("location: show.php");
    exit();
}
?>
