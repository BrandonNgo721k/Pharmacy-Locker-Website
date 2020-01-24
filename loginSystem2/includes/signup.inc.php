<?php

if (isset($_POST['signup-submit'])){
	
	require 'dbh.inc.php';
	
	$username = $_POST['uid'];
	$email = $_POST['mail'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];
	
	//empty
	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
		header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
		exit();
	}
	//invalid email and username
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signup.php?error=invalidmailuid");
		exit();
	}
	//check valid email
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../signup.php?error=invalidmail&uid=".$username);
		exit();
	}
	//check valid username
	else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signup.php?error=invaliduid&mail=".$email);
		exit();
	}
	//check matching passwords
	else if ($password !== $passwordRepeat){
		header("Location: ../signup.php?error=pwdcheck&uid=".$username."&mail=".$email);
		exit();
	}
	//start sql
	else{
		$sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../signup.php?error=sqlerror");
			exit();
		}
		else {//check username dupe
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$userCheck = mysqli_stmt_num_rows($stmt);
			
			//check for dupe email
			$sql = "SELECT uidUsers FROM users WHERE emailUsers=?;";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$sql)){
				header("Location: ../signup.php?error=sqlerror");
				exit();
			}
			else {//check username dupe
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$emailCheck = mysqli_stmt_num_rows($stmt);
			}
			if($userCheck > 0){
				header("Location: ../signup.php?error=usertaken&mail=".$email);
				exit();
			}
			else if($emailCheck > 0){
				header("Location: ../signup.php?error=emailregistered&uid=".$username);
				exit();
			}
			//insert in db
			else {
				$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?);";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else {
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
					
					mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
					mysqli_stmt_execute($stmt);
					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
}
else {
	header("Location: ../signup.php");
	exit();
}