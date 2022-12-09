<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: user_profile.php");
        header("Location: need_to_sign_in.php");
        exit();
    }

?>
