<?php
    ob_start();
    session_start();
    require_once "../config/konekcija.php";
    header("Content-type:application/json");
    $code=404;
    $data=null;

    if(isset($_POST['send'])){
            $ime=$_POST['ime'];
            $prezime=$_POST['prezime'];
            $email=$_POST['email'];
            $lozinka=$_POST['lozinka'];
            $username=$_POST['username'];
            $datum = $_POST['datum'];

            $greske=[];

            $reIme = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,29}(\s[A-Z][a-z]{2,29})*$/";
            $rePrezime = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,49}(\s[A-Z][a-z]{2,49})*$/";
            $reEmail = "/^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/";
            $reLozinka = "/^\S{5,50}$/";
            $reUsername = "/^[\d\w\_\-\.]{4,30}$/";


            if(!preg_match($reIme, $ime)){
                $greske[] =  "Ime nije u dobrom formatu";
            }

            if(!preg_match($rePrezime, $prezime)){
                $greske[] =  "Prezime nije u dobrom formatu";
            }
               
            if(!preg_match($reEmail, $email)){
                $greske[] =  "Email nije u dobrom formatu";
            }

            if(!preg_match($reLozinka, $lozinka)){
                $greske[] =  "Lozinka nije u dobrom formatu";
            }
            if(!preg_match($reUsername, $username)){
                $greske[] =  "Username nije u dobrom formatu";
            }

            if(count($greske)){
                $data=$greske;
                $code=422;
            }
            else{
                $upit="INSERT INTO person VALUES(NULL,:ime, :prezime)";
                    $rez=$konekcija->prepare($upit);
                    $rez->bindParam(":ime",$ime);
                    $rez->bindParam(":prezime",$prezime);
                
                $upit1="INSERT INTO person_role VALUES(NULL,:idP, 1)";
                    $rez1=$konekcija->prepare($upit1);
                    $rez1->bindParam(":idP",$idP);
                
                $upit2="INSERT INTO user (id_person_role, username, email, password, active, birth_date)VALUES(:idPr, :username, :email, :password, 1, :datum)";
                    $rez2=$konekcija->prepare($upit2);
                    $rez2->bindParam(":idPr",$idPr);
                    $rez2->bindParam(":username",$username);
                    $rez2->bindParam(":email",$email);
                    $lozinka = md5($lozinka);
                    $rez2->bindParam(":password",$lozinka);
                    $rez2->bindParam(":datum",$datum);

                    try{
                        $konekcija->beginTransaction();
                        $rez->execute();
                        $idP = $konekcija->lastInsertId();
                        $rez1->execute();
                        $idPr = $konekcija->lastInsertId();
                        $rez2->execute();
                        $konekcija->commit();
                       
                        $code=202;
                        $data="uspelo";
                        // header("Location:../index.php?page=login");
                        header("Refresh:0; url=https://flix-go4movies.000webhostapp.com/sajt-flixGo/index.php?page=login");
                         echo json_encode(['message'=> 'User successfully registred']);
                    }
                    catch(PDOException $e){
                        $konekcija->rollback();
                        echo json_encode(['message'=> $e->getMessage()]);
                        $code=409;
                        upisGresaka($e->getMessage());
                    }
            }
        http_response_code($code);
    }
?>