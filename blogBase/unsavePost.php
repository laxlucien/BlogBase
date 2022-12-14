<?php
include_once('logic.php');
$realSaveID = $_GET["saveID"];
$sql = "UPDATE save SET is_saved=0 WHERE saveID='" . $_GET["saveID"] . "'";
if (mysqli_query($con, $sql)) {
    $info = "SELECT postID FROM save WHERE saveID='$realSaveID'";
    $getInfo = $con->query($info);
    $realPostID = $getInfo->fetch_assoc();
    header("Location: viewpost.php?id=" . $realPostID["postID"] . "");
} else {
    echo "Error updating record: " . mysqli_error($con);
}
?>
