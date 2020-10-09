<?php
    

    function get_all_users(){
        return izvrsiUpit("SELECT COUNT(r.id_review)as broj, u.id_user as id_user, u.username as username, u.email as email, u.dateReg as datumReg, p.name as ime, p.surname as prezime, rol.name as uloga FROM user u INNER JOIN person_role pr on u.id_person_role=pr.id_person_role INNER JOIN role rol ON rol.id_role=pr.id_role INNER JOIN person p ON p.id_person=pr.id_person LEFT OUTER JOIN user_review ur ON ur.id_user=u.id_user LEFT OUTER JOIN review r ON r.id_review=ur.id_review GROUP BY u.id_user");
    }

    function get_one_user($id){
        global $konekcija;
        $korisnik=$konekcija->prepare("SELECT COUNT(r.id_review)as broj, u.id_user as id_user, u.username as username, u.email as email, u.dateReg as datumReg, p.name as name, p.surname as surname, rol.name as uloga, rol.id_role as id_role FROM user u INNER JOIN person_role pr on u.id_person_role=pr.id_person_role INNER JOIN role rol ON rol.id_role=pr.id_role INNER JOIN person p ON p.id_person=pr.id_person LEFT OUTER JOIN user_review ur ON ur.id_user=u.id_user LEFT OUTER JOIN review r ON r.id_review=ur.id_review WHERE u.id_user=? GROUP BY u.id_user");
        $korisnik->execute([$id]);
        return $korisnik->fetch();
    }

    function get_roles(){
        return izvrsiUpit("SELECT * FROM role");
    }


    function delete_user($id){
        global $konekcija;
        $brisanje=$konekcija->prepare("DELETE FROM user WHERE id_user=$id");
        return $brisanje->execute();
    }



    function output_json_message($message, $code){
        http_response_code($code);
        echo json_encode(["message" => $message]);
    }
       