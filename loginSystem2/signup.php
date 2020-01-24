<?php
//page after "signup" link is clicked, gets inputs and displays signup errors
// add past data after fail attempt
	require "header.php";
?>

	<main>
		<h1>Signup</h1>
		<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] == "emptyfields") {
					echo '<p>Fill in all fields!</p>';
				}
				else if ($_GET['error'] == "invalidmailuid") {
					echo '<p>Invalid username and email!</p>';
				}
				else if ($_GET['error'] == "invaliduid") {
					echo '<p>Invalid username!</p>';
				}
				else if ($_GET['error'] == "invalidmail") {
					echo '<p>Invalid email!</p>';
				}
				else if ($_GET['error'] == "pwdcheck") {
					echo '<p>Passwords do not match!</p>';
				}
				else if ($_GET['error'] == "usertaken") {
					echo '<p>Username is taken!</p>';
				}
				else if ($_GET['error'] == "emailregistered") {
					echo '<p>Email is already registered!</p>';
				}
			}
			else if (isset($_GET['signup'])){
				if ($_GET['signup'] == "success") {
					echo '<p>Signup successful!</p>';
				}
			}
			if (isset($_GET['uid'])) {
				echo $_GET['uid'];
			}

			//changed email type from text to email
		?>
		
		<form action="includes/signup.inc.php" method="post">
			<input type="text" name="uid" placeholder="Username" value="<?php if (isset($_GET['uid'])) {$_GET['uid'];}?>">
			<input type="email" name="mail" placeholder="Email">
			<input type="password" name="pwd" placeholder="Password">
			<input type="password" name="pwd-repeat" placeholder="Repeat password">
			<button type="submit" name="signup-submit">Signup</button>
		</form>
	</main>
	
<?php
	require "footer.php";
?>