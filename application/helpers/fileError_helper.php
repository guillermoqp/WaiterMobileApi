<?php defined('BASEPATH') OR exit('No direct script access allowed');
function escribirArchivoLog($nombreArchivo,$datos) {
    $CI=&get_instance();
    $CI->load->helper("file");
    $CI->load->helper("utilitarios");
    $file_path=$CI->config->item("carpetaLogs").$nombreArchivo;
    write_file($file_path,dateTimeNowToString()." -- ".$datos."\r\n",'a');
}