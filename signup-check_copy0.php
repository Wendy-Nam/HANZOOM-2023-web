<?php
session_start();
include "db_conn.php";

if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = validate($_POST['name']);
    $id = validate($_POST['id']);
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['repassword']); // Modified this line

    $user_data = 'id=' . $id . '&name=' . $name . '&email=' . $email;

    if (empty($id)) {
        header("Location: signup.php?error=User ID is required&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($re_pass)) {
        header("Location: signup.php?error=Re-enter Password is required&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data");
        exit();
    } else if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
        exit();
    } else {

        // Hashing the password
        $pass = md5($pass);

        $sql = "SELECT * FROM user WHERE name='$name' ";
        $result = mysqli_query($conn, $sql);


            $sql2 = "INSERT INTO user(id, password, email, name) VALUES('$id', '$pass', '$email','$name')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                header("Location: signup.php?success=Successfully registered.");
                exit();
            } else {
                header("Location: signup.php?error=An unknown error occurred.&$user_data");
                exit();
            }
        }
    
} else {
    header("Location: home.php");
    exit();
}
?>
