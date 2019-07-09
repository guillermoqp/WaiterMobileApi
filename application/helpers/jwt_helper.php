<?php defined('BASEPATH') OR exit('No direct script access allowed');
Class jwt_helper extends CI_Controller {
    public static function create($userid) {
        $CI=&get_instance();
        $CI->load->library("JWT");
        $token=$CI->jwt->encode(array(
            "consumerKey"=>$CI->config->item("CONSUMER_KEY"),
            "userId"=>$userid,
            "issuedAt"=>date(DATE_ISO8601,strtotime("now")),
            "ttl"=>$CI->config->item("CONSUMER_TTL")
        ), $CI->config->item("CONSUMER_SECRET"));
        return $token;
    }
    public static function validate($token) {
        $CI=&get_instance();
        $CI->load->library("JWT");
        try {
            $decodeToken=$CI->jwt->decode($token,$CI->config->item("CONSUMER_SECRET"));
            // validar si el token no ha expirado
            $ttl_time=strtotime($decodeToken->issuedAt);
            $now_time=strtotime(date(DATE_ISO8601,strtotime("now")));
            if(($now_time-$ttl_time)>$decodeToken->ttl) {
                throw new Exception('Expired');
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public static function decode($token)  {
        $CI=&get_instance();
        $CI->load->library("JWT");
        try {
            $decodeToken=$CI->jwt->decode($token,$CI->config->item("CONSUMER_SECRET"));
            return $decodeToken;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function tokenIsExist($headers) {
        return (array_key_exists("Authorization",$headers) && !empty($headers["Authorization"]));
    }
    public static function tokenValido($headers) {
        $valido=FALSE;
        if (self::tokenIsExist($headers)) {
            $token=self::validate($headers["Authorization"]);
            if ($token!=false) {
                $valido=TRUE;
            }
        }
        return $valido;
    }
}