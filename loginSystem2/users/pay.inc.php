<?php
//page after "profile" link is clicked, gets inputs and displays profile errors
// add past data after fail attempt
    require "header.php";
    require '../includes/dbh.inc.php';
?>
<?php
if (isset($_GET['pay-submit'])) {
    echo $_POST['pay-submit'];
}

?>
<?php
    exit();
	require "footer.php";
?>