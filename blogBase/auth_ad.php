<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: ad_design.php");
        header("Location: need_to_sign_in.php");
        exit();
    }
?>
