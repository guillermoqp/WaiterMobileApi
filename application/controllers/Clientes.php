<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
Class Clientes extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("cliente_model");
        $this->load->helper("jwt");
        $this->load->helper("utilitarios");
    }
    public function index_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $clientes=$this->cliente_model->listar_clientes();
            $datos["clientes"]=$clientes;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    public function nuevo_post() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $request=json_decode(file_get_contents('php://input'),true);
            if(isset($request)&&isset($request["apellidos"])&&isset($request["tipoDoc"])) {
                $id_cliente=$this->cliente_model->insertar_cliente($request["nombres"],$request["apellidos"],$request["tipoDoc"],$request["nroDoc"]);
                if ($id_cliente) {
                    $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al insertar cliente: ID: ".$id_cliente);
                }else{
                    $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Ocurrió algun error al insertar cliente.");
                } 
            }
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    /* Metodos Auxiliares */
    public function tiposDoc_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $tiposDoc=array('D'=>'Indica LIBRETA ELECTORAL O DNI',
                'CE'=>'Indica CARNET DE EXTRANJERIA',
                'RUC'=>'Indica REG. UNICO DE CONTRIBUYENTES',
                'P'=>'Indica PASAPORTE',
                'PN'=>'Indica PART. DE NACIMIENTO-IDENTIDAD',
                'OT'=>'Indica OTROS');
            $datos["tiposDoc"]=$tiposDoc;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
}