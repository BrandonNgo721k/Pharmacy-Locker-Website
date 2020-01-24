<?php
// no edit check yet,m need to add seperate edit or add
//this one will be add
session_start();
if (isset($_POST['prescription-submit'])){
	
	require '../../includes/dbh.inc.php';

	$userID = $_SESSION['userID'];
	
	//$prName = $_POST['prName'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$drugName = $_POST['drugName'];
	$strength = $_POST['strength'];
	$quantity = $_POST['quantity'];
	$supplyDuration = $_POST['supplyDuration'];
	$drName = $_POST['drName'];
	$notes = $_POST['notes'];
	$dropOffDate = date("m/d/y, g:i a"); // 03.10.01, 5:16 pm

	//empty
	if (empty($firstName) || empty($lastName) || empty($drugName) || empty($strength) || empty($quantity) || empty($supplyDuration) || empty($drName) || empty($notes)){
		header("Location: ../prescriptions.php?error=emptyfields");
		exit();
	}
	//invalid drug name
	else if (!preg_match("/^[a-zA-Z]*$/", $firstName)){
		header("Location: ../prescriptions.php?error=first");
		exit();
	}
	//check valid strength
		else if (!preg_match("/^[a-zA-Z]*$/", $lastName)){
		header("Location: ../prescriptions.php?error=last");
		exit();
	}
	//invalid doctor name
	/*else if (!preg_match("/^[a-zA-Z]*$/", $drName)){
		header("Location: ../prescriptions.php?error=drName");
		exit();
	}*/
	//check valid strength
		else if (!preg_match("/^[0-9]*$/", $strength)){
		header("Location: ../prescriptions.php?error=strength");
		exit();
	}
	//check valid quantity
	else if (!preg_match("/^[0-9]*$/", $quantity)){
		header("Location: ../prescriptions.php?error=quantity");
		exit();
	}
	//check valid supply duration
	else if (!preg_match("/^[0-9]*$/", $supplyDuration)){
		header("Location: ../prescriptions.php?error=duration");
		exit();
	}
	//check valid dr name
	/*else if (!preg_match("/^[a-zA-Z0-9]*$/", $add)){
		//placeholder
		header("Location: ../prescriptions.php?error=pwdcheck&uid=".$username."&mail=".$email);
		exit();
	}*/
	//check valid notes
	/*else if (!preg_match("/^[a-zA-Z]*$/", $city)){
		header("Location: ../prescriptions.php?error=city");
		exit();
	}*/
	//start sql
	else{
		//
		$sql = "SELECT * FROM rx WHERE idUsers=?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../prescriptions.php?error=sqlerror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "i", $userID);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			//query first and last name from session['userID']

			//query drug info like expdate and authorization
			//make another drug table

			//query insert
			$sql = "INSERT INTO rx (firstName, lastName, idUsers, drugName, strength, quantity, supplyDuration, drName,
			notes, dropOffDate, refillDate, expDate, refillFlag, paidStatus, fillRequest, fillStatus, pickupStatus, pickupTime) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$sql)){
				header("Location: ../prescriptions.php?error=sqlerror");
				exit();
			}
			else {//insert
				$refillDate = date("m/d/y, g:i a");
				$expDate = date("m/d/y, g:i a");
				$refillFlag = 0; //no refills
				$paidStatus = 0; //not paid
				$fillRequest = 0;
				$fillStatus = 0;
				$pickupStatus = 0;
				$pickupTime = 0; //amy need to change to date format
				
				//first and last name may vary ie if parent uses acc for kids
				mysqli_stmt_bind_param($stmt, "ssisiiisssssiiiiis", $firstName, $lastName, $userID, $drugName, $strength, $quantity, $supplyDuration, 
				$drName, $notes, $dropOffDate, $refillDate, $expDate, $refillFlag, $paidStatus, $fillRequest, $fillStatus, $pickupStatus, $pickupTime);
				//mysqli_stmt_bind_param($stmt, "ssisiiisssssiiiiis", $refillDate, $refillDate, $expDate, $refillDate, $expDate, $expDate, $expDate, 
				//$refillDate, $refillDate, $refillDate, $refillDate, $refillDate, $expDate, $expDate, $expDate, $expDate0, $expDate);
				mysqli_stmt_execute($stmt);
				
				header("Location: ../prescriptions.php?prescriptions=success");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
}
else {
	header("Location: ../prescriptions.php");
	exit();
}