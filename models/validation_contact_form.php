<?php 
    ob_start();
    session_start(); 
    require_once("../config/konekcija.php");

    if(isset($_POST['btnKontakt'])){ 
        $subj = $_POST['subj']; 
        $email = $_POST['email']; 
        $message = $_POST['message']; 

        $reSubject = "/^[A-ZČĆŠĐŽa-zšđžčć\.\d\s\-]{1,299}$/"; 
        $reEmail = "/^[a-z]{3,}(\.)?[a-z\d]{1,}(\.[a-z0-9]{1,})*\@[a-z]{2,7}\.[a-z]{2,3}(\.[a-z]{2,3})?$/"; 
        $reMessage = "/^[A-ZZŠĐŽČĆ][a-zšđžčć\.\d\s\-]{1,999}$/";
        $greske = []; 

        if(!$subj){ 
            $greske[] =  "Field for subject can't be empty!"; 
        }elseif(!preg_match($reSubject,$subj)){ 
            $greske[] = "*The subject is not validate --:  Max: 300 characters, FIrst letter can to be uppercase or lowercase"; 
        } 

        if(!$email){ 
            $greske[] = "Field for email can't be empty!"; 
        }elseif(!preg_match($reEmail,$email)){ 
            $greske[] = "*The email is not validate. It has to be written with small letters in format like: something@gmail.com ."; 
        } 
        
        if(!$message){ 
            $greske[] = "Field for message can't be empty!"; 
        } elseif(!preg_match($reMessage,$message)){ 
            $greske[] = "*The message is not validate - The first letter needs to be uppercase, and after that can be anything. Max length of characters is 1000."; 
        } 
        
        if(count($greske)!=0){ 
            $_SESSION['greskeKontakt'] = $greske; 
        }else{ 
            $upit = "INSERT INTO kontakt_info VALUES(NULL,:email,:title,:message)"; 
            $rez = $konekcija->prepare($upit); 
            $rez->bindParam(':email',$email); 
            $rez->bindParam(':title',$subj); 
            $rez->bindParam(':message',$message);
            
            try { 
                $izvrsi = $rez->execute(); 
                if($izvrsi){ 
                    $_SESSION['uspehPoruka'] = ["You successfuly sent a message!"]; 
                    header("Location: ../index.php?page=contact"); 
                }else{ 
                    $_SESSION['greskeKontakt'] = ["Error sending a message."]; 
                    header("Location: ../index.php?page=contact"); 
                } 
            } catch (PDOException $e) { 
                $_SESSION['greskeKontakt'] = [$e->getMessage()]; 
                header("Location: ../index.php?page=contact"); 
            } 
        } 
    } 
?>
