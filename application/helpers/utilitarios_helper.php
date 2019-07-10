<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function desactivar_errores() {
    ini_set("display_errors",0);
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	//error_reporting(E_ALL & ~E_NOTICE);
}
function setHeaders() {
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Content-Type");
	header("Content-Type: application/x-json; charset=utf-8;");
}
function getNoAutorizadoResponse() {
	return array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Usuario no Autorizado.");
}
function dateTimeToString($formatoFecha,$date,$time) {
	$fechaFormat=DateTime::createFromFormat($formatoFecha,$date." ".$time.":00");
	return $fechaFormat->format($formatoFecha);
}
function dateTimeToStringFormat($formatoFecha,$fecha) {
	$fechaDate=new DateTime($fecha);
	return $fechaDate->format($formatoFecha);
}
function dateTimeNowToString() {
	$now=new DateTime();
	return $now->format("Y-m-d H:i:s");
}