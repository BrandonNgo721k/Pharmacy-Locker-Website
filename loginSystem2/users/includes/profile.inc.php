<?php
session_start();
if (isset($_POST['profile-submit'])){
	
	require '../../includes/dbh.inc.php';
	
	$first = $_POST['first'];
	$last = $_POST['last'];
	$bday = $_POST['bday'];
    $phone = $_POST['phone'];
    
    $add = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
	$postalCode = $_POST['postalCode'];
	
	
	//$last = isset($_POST['last']) ? $_POST['last'] : 'anonymous';
	//echo "l ". $last . " l";
	
	//empty
	if (empty($first) && empty($last) && empty($bday) && empty($phone) && empty($address) && empty($city) && empty($country) && empty($postalCode)){
		header("Location: ../profile.php?error=emptyfields");
		exit();
	}
	//invalid first name
	else if (!preg_match("/^[a-zA-Z]*$/", $first)){
		header("Location: ../profile.php?error=first");
		exit();
	}
	//check valid last name
	else if (!preg_match("/^[a-zA-Z]*$/", $last)){
		header("Location: ../profile.php?error=last");
		exit();
	}
	//check valid phone
	else if (!preg_match("/^[0-9]*$/", $phone)){
		header("Location: ../profile.php?error=phone");
		exit();
	}
	//check valid address
	/*else if (!preg_match("/^[a-zA-Z0-9]*$/", $add)){
		//placeholder
		header("Location: ../profile.php?error=pwdcheck&uid=".$username."&mail=".$email);
		exit();
	}*/
	//check valid city
	/*else if (!preg_match("/^[a-zA-Z]*$/", $city)){
		header("Location: ../profile.php?error=city");
		exit();
	}
	//check valid country
	else if (!preg_match("/^[a-zA-Z]*$/", $country)){
		header("Location: ../profile.php?error=country");
		exit();
	}*/
	//check valid postal code
	else if (!preg_match("/^[0-9]*$/", $postalCode)){
		header("Location: ../profile.php?error=postal");
		exit();
	}
	//start sql
	else{
		//
		$sql = "SELECT * FROM profiles WHERE idUsers=?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../profile.php?error=sqlerror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)){

				$first = empty($first) ? $row['firstName'] : $first;
				$last = empty($last) ? $row['lastName'] : $last;
				$bday = empty($bday) ? $row['bday'] : $bday;
				$phone = empty($phone) ? $row['phone'] : $phone;
				
				$add = empty($add) ? $row['address'] : $add;
				$city = empty($city) ? $row['city'] : $city;
				$country = empty($country) ? $row['country'] : $country;
				$postalCode = empty($postalCode) ? $row['postalCode'] : $postalCode;
			}
			//fix
			$sql = "REPLACE INTO profiles (idUsers, firstName, lastName, bday, phone, address, city, country, postalCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$sql)){
				header("Location: ../profile.php?error=sqlerror");
				exit();
			}
			else {//replaceinto 
				mysqli_stmt_bind_param($stmt, "issssssss", $_SESSION['userID'], $first, $last, $bday, $phone, $add, $city, $country, $postalCode);
				mysqli_stmt_execute($stmt);
				
				header("Location: ../profile.php?profile=success");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
}
else {
	header("Location: ../profile.php");
	exit();
}