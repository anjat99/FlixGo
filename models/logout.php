<?php
    ob_start();
    session_start();
    require_once("../config/config.php");
    require_once("functions.php");

    izbrisiLogovanje($_SESSION['user']->id_user);
    unset($_SESSION['user']);
    header("Location: ../index.php?page=home");

?>
