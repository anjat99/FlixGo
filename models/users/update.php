<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmena'])){
        require_once("../../config/konekcija.php");
    
        $id = $_POST['skrivenoPolje'];
        $name=$_POST['tbIme'];
        $surname=$_POST['tbPrezime'];
        $username=$_POST['tbUsername'];
        $email=$_POST['tbEmail'];
        $role=$_POST['ddlUloga'];
     
        $greske=[];
        $reimeprez="/^[A-Z][a-z]{2,14}(\s[A-Z][a-z]{2,20})*$/";
        $reuser="/^[\d\w\_\-\.]{4,30}$/";

        if($role==0){
            array_push($greske, "Role of user is required");
        }
        if(!preg_match($reimeprez, $name)){
            array_push($greske, "Surname is not in good forma");
        }else if($name==""){
            array_push($greske, "The field of  name can't be empty!");
        }

        if(!preg_match($reimeprez, $surname)){
            array_push($greske, "Surname is not in good format");
        }else if($surname==""){
            array_push($greske, "The field of  surname can't be empty!");
        }

        if(!preg_match($reuser, $username)){
            array_push($greske, "USername is not in good format");
        }else if($username==""){
            array_push($greske, "The field of  username can't be empty!");
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
             array_push($greske, "Email is not in good format");
        }else if($email==""){
            array_push($greske, "The field of  email can't be empty!");
        }

        if(count($greske)){
            $_SESSION['poruka']="Not valid data";
            upisGresaka("Not valid data");
        }else{
             global $konekcija;
                $upit="UPDATE user u INNER JOIN person_role pr ON pr.id_person_role=u.id_person_role INNER JOIN person p ON p.id_person=pr.id_person INNER JOIN role r ON r.id_role=pr.id_role SET p.name=:name, p.surname=:surname, u.email=:email, r.id_role=:id_role, u.username=:username WHERE id_user=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":name",$name);
                $send->bindParam(":surname",$surname);
                $send->bindParam(":username",$username);
                $send->bindParam(":email",$email);
                $send->bindParam(":id_role",$role);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="User is successfully updated!";
                    }else{
                        $_SESSION['poruka']="Something went wrong, user is not updated!";
                        upisGresaka("Something went wrong, user is not updated!");
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    upisGresaka( $e->getMessage());
                    $_SESSION['poruka']="Error, user is not updated";
                  }
           
        }
        // echo "Nije uspoelo";
        header("Location:../../views/pages/admin.php?page=users");
    }
    endif;