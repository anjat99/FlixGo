<?php
    ob_start();
    if(isset($_POST['btnRegistracija'])){
        //  echo "Kliknuto";
        require_once "../../config/konekcija.php";
    }else{
        echo "NIje kliknuto na taster";
   }