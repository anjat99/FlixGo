<?php

require_once "config.php";

zabeleziPristupStranici();

try {
    $konekcija = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $konekcija->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo $ex->getMessage();
}

function izvrsiUpit($query){
    global $konekcija;
    return $konekcija->query($query)->fetchAll();
}

function izvrsiUpitJedanRed($query){
    global $konekcija;
    return $konekcija->query($query)->fetch();
}

function zabeleziPristupStranici(){
    @$open = fopen(LOG_FAJL, "a");
    if($open){
        $date = date('d-m-Y H:i:s');
        @fwrite($open, "{$_SERVER['PHP_SELF']}\t{$date}\t{$_SERVER['REQUEST_URI']}\t{$_SERVER['REMOTE_ADDR']}\t\n");
        @fclose($open);
    }
}

   function upisGresaka($greska){
    @$open=fopen(GRESKE_FAJL,"a");
    $unos=$greska."\t".date('d-m-Y H:i:s')."\n";
    @fwrite($open,$unos);
    @fclose($open);
   }


   ?>