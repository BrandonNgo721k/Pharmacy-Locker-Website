<?php
//admin header (image and dbh links are modified)
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="This is an example of a meta description. This will often show up in search results.">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<title></title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

		<header>
			<nav>
				<a href="#">
					<img src="../images/locker.png" alt="locker" height="150" width ="200">
				</a>
				<ul>
					<li><a href="../index.php">Home</a></li>
                    <li><a href="locker_space.php">Manage Locker</a></li>
				</ul>
				<div>
					<?php
						if (isset($_SESSION['userID'])) {
							echo '<form action="../includes/logout.inc.php" method="post">
						<button type="submit" name="logout-submit">Logout</button>
                        </form><br>';
						}
						else {
							header("Location: ../index.php?error=nonadmin");
				            exit();
			            }
					?>
				</div>
			</nav>
		</header>