<?php
    // ob_start();
    session_start();
    header("Content-type:application/json");
    if(isset($_SESSION['user']) && $_SESSION['user']->role=='admin'):
        require_once("../../config/konekcija.php");
        require_once("functions.php");
        $code=404;
        $data=null;
        if(isset($_POST['id'])){
            $id=$_POST['id'];
                
                try{
                    $data=getOneNavLink($id);
                    $code=200;
                }catch(PDOException $e){
                    $code=500;
                    $data=["greska"=>$e->getMessage()];
                    echo $e->getMessage();
                }
            http_response_code($code);
            echo json_encode($data);
        }
    endif;