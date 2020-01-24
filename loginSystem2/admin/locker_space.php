<?php
//locker space interface to put/remove in locker
	require "header.php";
?>

<main>
	<?php
		if (isset($_SESSION['userID'])) {
			
			if ($_SESSION['userUid'] == "Admin") {//admin
				require '../includes/dbh.inc.php';

				if (isset($_GET['remove'])) {
					if ($_GET['remove'] == "success") {
						echo '<p>Remove sucessful!</p>';
					}
					else if ($_GET['remove'] == "failed") {
						echo '<p>Remove Failed!</p>';
					}
				}
				else if (isset($_GET['put'])){
					if ($_GET['put'] == "success") {
						echo '<p>Put successful!</p>';
					}
					if ($_GET['put'] == "failed") {
						echo '<p>Put failed!</p>';
					}
				}

				echo '<form action="includes/locker_space.inc.php" method="post">';
				echo '<input type="number" name="lockerNumber" placeholder="Locker Number">
						<input type="number" name="rx" placeholder="Rx"><br>
						<input type="radio" name="actionDo" value="put" checked> Put
						<input type="radio" name="actionDo" value="remove"> Remove <br>
						<button type="submit" name="locker-submit">Submit</button>
					</form>';

				$sql = "SELECT * FROM locker_space;";
			
				$result = mysqli_query($conn, $sql);

				//show locker info
				echo "<p>LockeerNumber Status Rx TimeOccupied</p>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo $row['lockerNumber'] . " | " . $row['status'] . " | " . $row['rx'] . " | " . $row['time'] . "<br>";
					}

				exit();
			}
			else {
				header("Location: ../index.php?error=nonadmin");
				exit();
			}
		}
		else {
			header("Location: ../index.php");
			exit();
		}
	?>
</main>
<?php
	require "../footer.php";
?>