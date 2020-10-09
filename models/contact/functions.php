<?php
    function insertMessage($email,$title,$message){
        global $konekcija;
        $date=date("Y-m-d H:i:s");
        $send=$konekcija->prepare("INSERT INTO contact_info (email, title, message, date) VALUES (:email,:title,:message,:date)");
        $send->bindParam(":email",$email);
        $send->bindParam(":title",$title);
        $send->bindParam(":message",$message);
        $send->bindParam(":date",$date);
        return $send->execute();
    }



 function get_all_messages(){
    return izvrsiUpit("SELECT * FROM `contact_info`");

 }

 function delete_message($id){
   global $konekcija;
   $send=$konekcija->prepare("DELETE FROM `contact_info` WHERE id_contact=?");
   $send->execute([$id]);
 }


 function get_one_message($id){
    global $konekcija;
    $send=$konekcija->prepare("SELECT * FROM `contact_info` WHERE id_contact=?");
    $send->execute([$id]);
    return $send->fetch();
 }