<?php

function dohvati_sve_zanrove(){
    return izvrsiUpit("SELECT * from genre ");
}

function dohvati_sve_limitage(){
    return izvrsiUpit("SELECT * from limit_age");
}

function dohvati_sve_quality(){
    return izvrsiUpit("SELECT * from quality ");
}

function dohvati_sve_drzave(){
    return izvrsiUpit("SELECT * from country");
}
