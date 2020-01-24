<?php

if (isset($_POST['pay-submit'])) {
    require '../../includes/dbh.inc.php';
    //echo $_POST['pay-submit'];
    $rxNum = $_POST['pay-submit'];

    $sql = "UPDATE rx SET paidStatus=1 WHERE rxNumber=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../prescriptions.php?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $rxNum);
        mysqli_stmt_execute($stmt);
        header("Location: ../prescriptions.php?pay=success");
        exit();
    }
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../prescriptions.php");
	exit();
}
?>