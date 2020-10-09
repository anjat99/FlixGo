<?php
    header("Content-Type: application/json");
  
    require_once "../../config/konekcija.php";
    require_once "functions.php";

    if(!isset($_POST["send"])){
        output_json_message("Access forbidden.", 403);
        exit;
    }

    $email = $_POST["email"];
    // if(!preg_match("/^\w([\.-]?\w+\d*)*\@\w+\.\w{2,7}\.\w{2,4}$/", $email)){
    //     output_json_message("Server message: Email must contain only lowercase letters and numbers and dots(.)", 406); // 406 - Not acceptable
    //     exit;
    // }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        output_json_message("Server message: Email must contain only lowercase letters and numbers and dots(.)", 406); // 406 - Not acceptable
        exit;
    }

    if(checkIfSubscriberExists($email)){
        output_json_message("You have already subscribed for newsletter.", 409); // 409 -Conflict
        exit;
    }
    try{
        $upit = "INSERT INTO newsletter VALUES(NULL, ?)";
        $priprema = $konekcija->prepare($upit);
        $priprema->bindParam(1, $email);

        if(!$priprema->execute()){
            output_json_message("Internal server error", 500);
            exit;
        }

        $mail_body = "<h4>Thank you for subscribing to our newsletter.</h4>";
        mail($email, "FlixGo - Newsletter Subscription", $mail_body);
        output_json_message("You have subscribed successfuly", 200);
        exit;

    }catch(Exception $e){
        output_json_message("Internal server error", 500);
        upisGresaka("Error registering subscriber. Exception: {$e->getMessage()}");
        exit;
    }


    function checkIfSubscriberExists($email){
        global $konekcija;
        try{
            $upit = "SELECT * FROM newsletter WHERE email=?";
            $priprema = $konekcija->prepare($upit);
            $priprema->bindParam(1,$email);

            if(!$priprema->execute()){
            return false;
            }
            return $priprema->rowCount() > 0;
        }catch(Exception $e){
            return false;
        }
    }
?>