<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
Class Mesas extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("mesa_model");
        $this->load->helper("jwt");
        $this->load->helper("utilitarios");
    }
    public function index_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $mesas=$this->mesa_model->listar_mesas();
            $datos["mesas"]=$mesas;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
}