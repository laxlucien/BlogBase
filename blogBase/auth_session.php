<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: admin.php");
        header("Location: need_to_sign_in.php");
        exit();
    }

?>
