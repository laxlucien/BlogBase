<?php
include_once('logic.php');
$sql = "UPDATE social_follow SET follow_id=0 WHERE unique_number='" . $_GET["unique_number"] . "'";
if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";
    header("Location: social.php");
} else {
    echo "Error updating record: " . mysqli_error($con);
}
//this is to update someone from follow to following
?>
