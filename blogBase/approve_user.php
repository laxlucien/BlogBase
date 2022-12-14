<?php
include_once('logic.php');
$sql = "UPDATE users SET is_approved=1 WHERE userid='" . $_GET["userid"] . "'";
if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";
    header("Location: admin.php");
} else {
    echo "Error updating record: " . mysqli_error($con);
}
?>
