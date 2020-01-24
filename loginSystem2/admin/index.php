<?php
//admin index
//what is dependant on this?
//not neccesarily needed
	require "header.php";
?>

	<main>
		<?php
			if (isset($_SESSION['userID'])) {
				//echo '<p>You are logged in!</p>';
				//add locker stuff
				//add ability to change locker status, rx,
				if ($_SESSION['userUid'] == "Admin") {//admin
					echo '<p>You are logged in as : Admin</p>';
					echo '<select name="page" onchange="window.location=this.value">
						<option value="admin/locker_space.php">Manage Lockers</option>
						<option value="locker_space.php">Place/Remove</option>
						<option value="locker_space.php">Place/Remove</option>
					</select>';
				}
				else {
					header("Location: ../index.php?error=nonadmin");
				    exit();
				}
			}
			else {
				if (isset($_GET['error'])){
					if ($_GET['error'] == "wrongpwd" || $_GET['error'] == "nouser" ) {
						echo '<p>Wrong password or no user!</p>';
					}
				}
				else {
					echo '<p>You are logged out!</p>';
				}
			}
		?>
	</main>
	
<?php
	require "../footer.php";
?>