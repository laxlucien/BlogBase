<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: graphDes.php");
        header("Location: need_to_sign_in.php");
        exit();
    }

?>
