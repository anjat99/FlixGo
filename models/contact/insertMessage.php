<?php
 session_start();
 ob_start();
 header("Content-type:application/json");
 require_once("../../config/konekcija.php");
 require_once("functions.php");
//  require '../../PHPMailer/src/PHPMailer.php';
//  require '../../PHPMailer/src/SMTP.php';
//  require '../../PHPMailer/src/Exception.php';
//  use PHPMailer\PHPMailer\PHPMailer;
//  use PHPMailer\PHPMailer\Exception;
$code=404;
$data=null;
        if(isset($_POST['send'])){
            $subj=$_POST['subj'];
            $email=$_POST['email'];
            $message=$_POST['message'];

        $greske=[];
        $ispis='';
            
                if($subj==""){
                    $greske[]="Morate da unesete svrhu poruke";
                }

                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $greske[]="Email nije u dobrom formatu";
                }
                if($message==""){
                    $greske[]="Morate da unsete poruku";
                }

            if(count($greske)){
                for($i=0; $i<count($greske) ; $i++) {
                    $ispis+=$greske[$i]."<br>";
                }
                $data=['greska'=>$ispis];
                $code=422;
            }else{
              
                try{
                    if(insertMessage($email,$subj,$message)){
                        $code=201;
                        try {
                            $data=["success"=>"You have successfully sent the mail"];
                             $to="flixgo4movies@gmail.com";
                             $text="<b>From website FlixGo:</b>"."\n".$message;
                             $header="From: $email";
                             mail($to, $subj, $text, $header);
                        }catch(Exception $e){
                            echo $e->getMessage();
                            upisGresaka($e->getMessage());
                        }
                    }else{
                        $code=500;
                    }
                }catch(PDOException $e){
                    $code=409;
                    $data=['greska'=>$e->getMessage()];
                    upisGresaka($e->getMessage());
                    echo $e->getMessage();
                }
            }
            http_response_code($code);
            echo json_encode($data);
        }