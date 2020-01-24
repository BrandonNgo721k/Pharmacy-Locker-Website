<?php
//page after "profile" link is clicked, gets inputs and displays profile errors
// add past data after fail attempt
//add isset
    require "header.php";
    require '../includes/dbh.inc.php';
?>

	<main>
		<h1>Profile</h1>
		<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] == "emptyfields") {
					echo '<p>No changes made!</p>';
				}
				else if ($_GET['error'] == "first") {
					echo '<p>Invalid first name!</p>';
				}
				else if ($_GET['error'] == "last") {
					echo '<p>Invalid last name!</p>';
				}
				else if ($_GET['error'] == "phone") {
					echo '<p>Invalid phone number!</p>';
				}
				else if ($_GET['error'] == "postal") {
					echo '<p>Invalid postal code!</p>';
                }
                /*
				else if ($_GET['error'] == "usertaken") {
					echo '<p>Username is taken!</p>';
				}
				else if ($_GET['error'] == "emailregistered") {
					echo '<p>Email is already registered!</p>';
				}*/
			}
			else if (isset($_GET['profile'])){
				if ($_GET['profile'] == "success") {
					echo '<p>Profile changes saved!</p>';
				}
			}
            
            $userID = $_SESSION['userID'];
            $sql = "SELECT * FROM users WHERE idUsers=?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            //
            else {
                mysqli_stmt_bind_param($stmt, "i", $userID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                //show user info
                echo "<h4>Account Info</h4>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['uidUsers'] . " | " . $row['emailUsers'] . "<br>";
                }
                
                //link to users table by primary key
                $sql = "SELECT * FROM profiles WHERE idUsers=?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                }
                //
                else {
                    mysqli_stmt_bind_param($stmt, "s", $userID);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    //show profile
                    echo "<h4>Personal Info</h4>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo $row['firstName'] . " | " . $row['lastName'] . " | " . $row['bday'] . " | " . $row['phone'] . "<br>";
                        echo $row['address'] . " | " . $row['city'] . " | " . $row['country'] . " | " . $row['postalCode'] . "<br><br>";
                        $_SESSION['firstName'] = $row['firstName'];
                        $_SESSION['lastName'] = $row['lastName'];
                        echo  $_SESSION['firstName']. " | " .  $_SESSION['lastName'];
                    }
                }
            }
		?>
		
		<form action="includes/profile.inc.php" method="post">
			<input type="text" name="first" placeholder="First Name">
			<input type="text" name="last" placeholder="Last Name">
			<input type="date" name="bday" placeholder="Birthday">
			<input type="tel" name="phone" placeholder="Phone Number">
            <br>
            <input type="text" name="address" placeholder="Street Address">
            <input type="text" name="city" placeholder="City">
            <input type="text" name="country" placeholder="Country">
            <input type="text" name="postalCode" placeholder="Postal Code">
            <br>
			<button type="submit" name="profile-submit">Save Profile</button>
		</form>
	</main>
	
<?php
    exit();
	require "footer.php";
?>