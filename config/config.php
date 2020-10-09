<?php

// Osnovna podesavanja
define("BASE_PATH", "https://flix-go4movies.000webhostapp.com/sajt-flixGo/");
define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"]."/sajt-flixGo");


// Ostala podesavanja
define("ENV_FAJL", ABSOLUTE_PATH."/config/.env");
define("LOG_FAJL", ABSOLUTE_PATH."/data/log.txt");
define("LOGOVANJE_KORISNIKA_FAJL", ABSOLUTE_PATH."/data/logovanje.txt");
define("GRESKE_FAJL", ABSOLUTE_PATH."/data/greske.txt");

// Podesavanja za bazu
define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

define("EMAIL", env("EMAIL"));
define("SIFRA_EMAIL", env("SIFRA_EMAIL"));

function env($naziv){
    $podaci = file(ENV_FAJL);
    $vrednost = "";
    foreach($podaci as $key=>$value){
        $konfig = explode("=", $value);
        if($konfig[0]==$naziv){
            $vrednost = trim($konfig[1]); // trim() zbog \n
        }
    }
    return $vrednost;
}
