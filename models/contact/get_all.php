<?php
    session_start();
    ob_start();
    header("Content-type:application/json");
    // echo json_encode($data);
    require_once("../../config/konekcija.php");
    require_once("functions.php");
    $data=null;
    $code=404;

        if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        try{
            $data=get_all_messages();
            $code=200;
        }
        catch(PDOException $e){
            $code=500;
            $data=["greska"=>$e->getMessage()];
            echo $e->getMessage();
        }
        echo json_encode($data);
        http_response_code($code);
    endif;