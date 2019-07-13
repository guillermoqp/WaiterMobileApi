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
                $resultado=$this->pedido_model->cambiar_pedido($request["idMesa"],$request["id_plato"],$request["cantidad"]);
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
    public function insertar_pedido_post() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $request=json_decode(file_get_contents('php://input'),true);
            if( (isset($request)&&isset($request["id_mozo"])&&isset($request["idMesa"])&&isset($request["id_plato"])&&isset($request["cantidad"]))&&
                (is_int($request["id_mozo"])&&is_int($request["idMesa"])&&is_int($request["id_plato"])&&is_int($request["cantidad"])) ) {
                $resultado=$this->pedido_model->insertar_pedido($request["id_mozo"],$request["idMesa"],$request["id_plato"],$request["cantidad"]);
                if ($resultado["codigoRespuesta"]==0) {
                    $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al insertar pedido.");
                }else{
                    $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Ocurrió algun error al insertar pedido, detalle: ".$resultado["mensajeRespuesta"]);
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
    public function entregar_pedido_get($id_pedido) {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $resultado=$this->pedido_model->entregarPedido($id_pedido);
            if ($resultado["codigoRespuesta"]==0) {
                $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al entregar pedido.");
            }else{
                $response=array("codigoRespuesta"=>1,"mensajeRespuesta"=>"Ocurrió algun error al entregar pedido, detalle: ".$resultado["mensajeRespuesta"]);
            }
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
}