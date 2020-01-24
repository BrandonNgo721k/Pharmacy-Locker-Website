<?php
//alters locker space
if (isset($_POST['locker-submit'])){
	
	require '../../includes/dbh.inc.php';
	
	$lockerNumber = $_POST['lockerNumber'];
	$rx = $_POST['rx'];
	$action = $_POST['actionDo'];
	
	//check for emtpy locker field
	if (empty($lockerNumber)){
		header("Location: ../locker_space.php?error=emptyfields&rx=".$rx);
		exit();
	}
	//start sql
	else{
        if ($action == "put") {
            $sql = "UPDATE locker_space SET status=1, rx=?, time=CURRENT_TIMESTAMP WHERE lockerNumber=? AND status=0;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../locker_space.php?error=sqlerror");
                exit();
            }
            else {//get locker info
                mysqli_stmt_bind_param($stmt, "ii", $rx, $lockerNumber);
                //add if execute doesnt work
                mysqli_stmt_execute($stmt);
                $rowsChanged = mysqli_stmt_affected_rows($stmt);
                echo "<p>".$rowsChanged."hello</p>";
                if ($rowsChanged == 0){
                    header("Location: ../locker_space.php?put=failed");
                    exit();
                }
                else {
                    header("Location: ../locker_space.php?put=success");
                    exit();
                }     
            }
        }
        else if ($action == "remove") {
            $sql = "UPDATE locker_space SET status=0, rx=0, time=0 WHERE lockerNumber=? AND status=1 AND rx=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../locker_space.php?error=sqlerror");
                exit();
            }
            else {//get locker info
                mysqli_stmt_bind_param($stmt, "ii", $lockerNumber, $rx);
                //add if execute doesnt work
                mysqli_stmt_execute($stmt);
                $rowsChanged = mysqli_stmt_affected_rows($stmt);
                if ($rowsChanged == 0){
                    header("Location: ../locker_space.php?remove=failed");
                    exit();
                }
                else {
                    header("Location: ../locker_space.php?remove=success");
                    exit();
                };
            }
        }
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
}
else {
	header("Location: ../locker_space.php");
	exit();
}