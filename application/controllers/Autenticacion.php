<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
Class Autenticacion extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("mozo_model");
        $this->load->helper("jwt");
        $this->load->helper("utilitarios");
    }
    public function index_get() {
        $this->load->view("inicio");
    }
    public function login_post() {
        $request=json_decode(file_get_contents('php://input'),true);
        if(isset($request)&&isset($request["usuario"])&&isset($request["password"])) {
            $mozo=$this->mozo_model->login_mozo($request["usuario"],sha1($request["password"]));
            if (isset($mozo)&&!empty($mozo)) {
                $datos["token"]=jwt_helper::create($mozo["id_mozo"]);
                $datos["mozo"]=$mozo;
                $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito en Login","datos"=>$datos);
            }else{
                $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Usuario o Password incorrectos, usuario no encontrado.");
            } 
        }else{
            $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Usuario o Password no se han enviado correctamente.");
        }
        $this->set_response($response,REST_Controller::HTTP_OK);
        return;
    }
    public function error404() {
        $this->load->view("inicio");
    }
}