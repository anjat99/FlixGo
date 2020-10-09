<?php
    ob_start();
    session_start();
    require_once("functions.php");
  header("Content-type:application/json");
    $code=404;
    $data=null;

       if(isset($_POST['send'])){
            $email=$_POST['email'];
            $lozinka=$_POST['lozinka'];
            $reEmail = "/^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/";
            $reLozinka = "/^\S{5,50}$/";

            $greske=[];

            if(!preg_match($reLozinka,$lozinka)){
                $greske[]="Password is not in good format";
            }
            if(!preg_match($reEmail, $email)){
                $greske[] =  "Email is not in good format";
            }

            if(count($greske)>0){
                $_SESSION['greske']="Invalid email or password";
                header("Location:../index.php?page=login");
                $code=422;
            }else{
               require_once("../config/konekcija.php");
                $lozinka=md5($lozinka);

                $upit="SELECT u.*, p.name as name, p.surname as surname, r.name as role FROM user u INNER JOIN person_role pr on u.id_person_role=pr.id_person_role INNER JOIN role r ON r.id_role=pr.id_role INNER JOIN person p ON p.id_person=pr.id_person WHERE u.email=:email AND u.password=:lozinka AND u.active=1";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":email",$email);
                $send->bindParam(":lozinka",$lozinka);
                $send->execute();

                    try{
                        if($send->rowCount()==1){
                            $rezultat=$send->fetch();
                            $_SESSION['user']=$rezultat;
                             $code=202;
                                if($rezultat->role=="user"){
                                     zabeleziLogovanje($rezultat->id_user, $rezultat->email);
                                    header("Location:../index.php?page=home");
                                    $data="user";
                                }else if($rezultat->role=="admin"){
                                    // header("Location:".BASE_PATH."views/pages/admin.php");
                                     header("Location: ../../../views/pages/admin.php");
                                    $data="admin";
                                }
                        }else if ($send->rowCount()>2) {
                                $code=422;
                             $_SESSION['greske']="Wrong password/email";
                             $to=$email;
                             $text="Someone tried to login on your account.";
                             $subject="Message from website FligGo - Login ";
                             $header="From: https://flix-go4movies.000webhostapp.com/sajt-flixGo/";
                             mail($to, $subject, $text, $header);
                        }
                    
                    }catch(Exception $e){
                        echo $e->getMessage();
                        upisGresaka($e->getMessage());
                         $code=500;
                    }
                      http_response_code($code);
                echo json_encode($data);
               
                
            }
            
        }else{
            header("Location:../index.php?page=home");
        }