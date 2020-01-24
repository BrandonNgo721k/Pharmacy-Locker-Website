<?php
//page after "profile" link is clicked, gets inputs and displays profile errors
// add past data after fail attempt
    require "header.php";
    require '../includes/dbh.inc.php';
?>

	<main>
		<h1>Prescriptions</h1>
		<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] == "emptyfields") {
					echo '<p>empty fields!</p>';
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
			}
			else if (isset($_GET['profile'])){
				if ($_GET['profile'] == "success") {
					echo '<p>Profile changes saved!</p>';
				}
			}
            
            $userID = $_SESSION['userID'];
            
            $sql = "SELECT * FROM rx WHERE idUsers=?;";
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
                //show user info
                //echo "<h4>Account Info</h4>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>RX number</p>";
                    echo $row['rxNumber'] . "<br>";
                    
                    echo "<p> paidStatus | fillStatus | pickupStatus</p>";
                    echo $row['paidStatus'] . " | " . $row['fillStatus'] . " | " . $row['pickupStatus']. "<br>";
                    if ($row['paidStatus'] == 0){
                        echo '<form action="includes/pay.inc.php" method="post">
                        <button type="submit" name="pay-submit" value ='. $row['rxNumber']. '>Pay</button>
                    </form>';
                    }
                        
                    echo "<p> Name </p>";                 
                    echo $row['firstName'] . " | " . $row['lastName'] . "<br>";
                    echo "<p> Prescription | Stength | Quantity | supplyDuration</p>"; 
                    echo $row['drugName'] . " | " . $row['strength'] . " | " . $row['quantity'] . " | " . $row['supplyDuration'] . "<br>";
                    echo "<p> Doctor | Notes </p>"; 
                    echo $row['drName'] . " | " . $row['notes'] . "<br>";
                    echo "<p> refillDate | expDate |</p>"; 
                    echo $row['refillDate'] . " | " . $row['expDate'] . " | " . "<br><br>";
                }
            }
            //might default first and last name to user profile name
		?>
		
		<form action="includes/prescriptions.inc.php" method="post">
			<input type="text" name="firstName" placeholder="First Name">
			<input type="text" name="lastName" placeholder="Last Name">
            <br>
			<input type="text" name="drugName" placeholder="Prescription Name">
            <input type="number" name="strength" placeholder="Prescription Strength (mg)">
            <input type="number" name="quantity" placeholder="Prescription Quantity">
            <br>
            <input type="number" name="supplyDuration" placeholder="Supply Duration (days)">
            <input type="text" name="drName" placeholder="Prescribing Dr">
            <br>
            <input type="text" name="notes" placeholder="Prescription Notes/Instructions">
            <br>
			<button type="submit" name="prescription-submit">Submit</button>
		</form>
	</main>
	
<?php
    exit();
	require "footer.php";
?>