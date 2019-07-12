<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
Class Pedidos extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("pedido_model");
        $this->load->helper("jwt");
        $this->load->helper("utilitarios");
    }
    public function index_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $datos["pedidos"]=array();
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    public function cambiar_pedido_post() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $request=json_decode(file_get_contents('php://input'),true);
            if( (isset($request)&&isset($request["idMesa"])&&isset($request["id_plato"])&&isset($request["cantidad"]))&&
                (is_int($request["idMesa"])&&is_int($request["id_plato"])&&is_int($request["cantidad"])) ) {
                $resultado=$this->pedido_model->cambiarPedido($request["idMesa"],$request["id_plato"],$request["cantidad"]);
                if ($resultado["codigoRespuesta"]==0) {
                    $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al cambiar pedido.");
                }else{
                    $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Ocurrió algun error al cambiar pedido, detalle: ".$resultado["mensajeRespuesta"]);
                }
            }else{
                $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Ingrese parametros correctos.");
            }
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
}