<?php
// ob_start();
// session_start();
// require_once "../../config/konekcija.php";
// header("Content-type:application/json");
// if(isset($_SESSION['user']) && $_SESSION['user']->role==='user'):
//     $user=$_SESSION['user'];
//     $idUser=$user->id_user;

    
//    $upitKomentari = "SELECT * FROM user u INNER JOIN user_review ur ON u.id_user=ur.id_user INNER JOIN review r ON r.id_review=ur.id_review ORDER BY r.id_review DESC"; 

//     $statement = $konekcija->prepare($upitKomentari);
//     $statement->execute();
   
//     try{
//             $reviews = $statement->fetchAll();
//             echo json_encode($reviews);
//             $code=201;
//     }
//     catch(PDOException $e){
//         echo json_encode(['message'=> $e->getMessage()]);
//         $code=500;
//         upisGresaka($e->getMessage());
//     }
//     http_response_code($code);
// endif; 


    session_start();
    ob_start();
    header("Content-type:application/json");
    // echo json_encode($data);
    require_once("../../config/konekcija.php");
    require_once("functions.php");
    $data=null;
    $code=404;

        if(isset($_SESSION['user']) && $_SESSION['user']->role==='user'):
        try{
            $data=get_all_reviews();
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