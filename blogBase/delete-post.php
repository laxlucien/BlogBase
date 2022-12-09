<?php
include_once('db.php');
$sql = "DELETE FROM blog_posts WHERE postID='" . $_GET["postID"] . "'";
if (mysqli_query($con, $sql)) {
    header("Location: graphDes.php");
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>
