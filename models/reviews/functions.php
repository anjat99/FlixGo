<?php

// function getReviews($idM){
//     global $konekcija;
//     require_once "models/catalog/calculate_rating.php";

//     $upit = "SELECT * FROM user u INNER JOIN user_review ur ON u.id_user=ur.id_user INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN movie m ON m.id_movie=ur.id_movie WHERE m.id_movie=$idM ORDER BY r.id_review DESC";
//     $rez = $konekcija -> query($upit)->fetchAll();


//     $ispis = " ";
      
//         foreach($rez as $item){
//             $ispis .= '<li class="reviews__item">
//             <div class="reviews__autor">
//                 <img class="reviews__avatar" src="assets/images/user.png" alt="">
//                 <span class="reviews__name">'.$item->title.'</span>
//                 <span class="reviews__time">';
//             $ispis .= obradaDatuma($item->date, $konekcija);
//             $ispis .= ' by '.$item->username.'</span>';
//             $ispis .= '<span class="reviews__rating"><i class="icon ion-ios-star"></i>';
//             if($item->prosek != null){
//                  $ispis .= $item->prosek;
//              }else{
//                 $ispis .= "0 votes";
//              }
//             $ispis .= '</span>
//                         </div>
//                         <p class="reviews__text">'.$item->message.'</p>
//                     </li>';
//         }
    
//         return $ispis;
    
    
// }

function obradaDatuma($datum){
    global $konekcija;
    return date("d.m.Y, H:i:s", strtotime($datum));
}

function brojReviews($idM){
    return izvrsiUpit("SELECT COUNT(*) FROM user u INNER JOIN user_review ur ON u.id_user=ur.id_user INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN movie m ON m.id_movie=ur.id_movie WHERE m.id_movie=$idM ORDER BY r.id_review DESC");
}


function get_all_reviews(){
    return izvrsiUpit("SELECT m.id_movie, m.name as film, ur.date as datumReview, r.title as title, r.message as tekstReview FROM movie m INNER JOIN user_review ur ON ur.id_movie=m.id_movie INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN user u ON u.id_user=ur.id_user WHERE u.id_user=:id");

 }

//  function delete_review($idM,$idU,$idR){
//    global $konekcija;
//    $send=$konekcija->prepare("DELETE FROM review AS r INNER JOIN user_review as ur ON ur.id_review = r.id_review INNER JOIN movie AS m ON m.id_movie=ur.id_movie INNER JOIN user AS u ON u.id_user=ur.id_user WHERE m.id_movie=? AND u.id_user=? AND r.id_review=?");
//    $send->execute([$idM,$idU,$idR]);
//  }


//  function get_one_review($id){
//     global $konekcija;
//     $send=$konekcija->prepare("SELECT m.id_movie, m.name as film, ur.date as datumReview, r.title as title, r.message as tekstReview FROM movie m INNER JOIN user_review ur ON ur.id_movie=m.id_movie INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN user u ON u.id_user=ur.id_user WHERE r.id_review=?");
//     $send->execute([$id]);
//     return $send->fetch();
//  }