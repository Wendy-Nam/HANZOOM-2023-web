<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['id']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$id = validate($_POST['id']);
	$pass = validate($_POST['password']);

	if (empty($id)) {
		header("Location: index.php?error=Id is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		// hashing the password
        $pass = md5($pass);
        //echo $id;
        //echo $pass;
		$sql = "SELECT * FROM user WHERE id='$id' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['id'] === $id && $row['password'] === $pass) {
                
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
                
                $_SESSION['user_id'] = $row['user_id'];
				header("Location: home.php");
		        exit();
                
            }else{
				header("Location: index.php?error= Something's wrong with your account information");
		        exit();
			}
		}else{
			header("Location: index.php?error= ID or Password Incorrect.");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}