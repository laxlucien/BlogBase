<?php
include_once('db.php');
$sql = "DELETE FROM users WHERE userid='" . $_GET["userid"] . "'";
if (mysqli_query($con, $sql)) {
    header("Location: admin.php");
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>
