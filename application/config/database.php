<?php defined('BASEPATH') OR exit('No direct script access allowed');
$active_group="default";
$query_builder=TRUE;
$active_record=TRUE;
/*$configBD=array(
    "hostname"=>"127.0.0.1",
    "username"=>"root",
    "password"=>"123456",
    "database"=>"waiter_mobile"
);*/
$configBD=array(
    "hostname"=>"db4free.net",
    "username"=>"waitermobile",
    "password"=>"waitermobile2019",
    "database"=>"dbwaitermobile"
);
$db[$active_group]=array(
    "hostname"=>$configBD["hostname"],
    "username"=>$configBD["username"],
    "password"=>$configBD["password"],
    "database"=>$configBD["database"],
    "dbdriver"=>"mysqli",
    "dbprefix"=>"",
    "pconnect"=>TRUE,
    "db_debug"=>TRUE,
    "cache_on"=>TRUE,
    "cachedir"=>"",
    "char_set"=>"utf8",
    "dbcollat"=>"utf8_general_ci",
    "swap_pre"=>"",
    "autoinit"=>TRUE,
    "stricton"=>FALSE
);
/*
Correo electrónico: gquintanillaparedes@gmail.com
MySQL 8.0 de db4free.net. 
HOST: db4free.net
PORT:   3306
USERNAME: waitermobile
BD: dbwaitermobile
pass: waitermobile2019
*/