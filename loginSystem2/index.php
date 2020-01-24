<?php
//changed based on which user is logged in
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
						<option value="admin/locker_space.php">Place/Remove</option>
					</select>';
				}
				else {
					echo '<p>You are logged in as : ' .$_SESSION['userUid'];
					echo '</p>';
					echo '<select name="page" onchange="window.location=this.value">
						<option value="users/profile.php">Profile</option>
						<option value="users/prescriptions.php">Manage Prescriptions</option>
					</select>';
					echo '<a href="users/profile.php">Profile</a>';
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
	require "footer.php";
?>