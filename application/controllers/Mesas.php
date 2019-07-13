<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
Class Mesas extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("mesa_model");
        $this->load->model("pedido_model");
        $this->load->helper("jwt");
        $this->load->helper("utilitarios");
    }
    public function index_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $mesas=$this->mesa_model->listar_mesas();
            for ($i=0;$i<count($mesas);$i++) { 
                $mesas[$i]["pedidos"]=$this->pedido_model->listar_pedidos_by_mesa($mesas[$i]["idMesa"]);
            }
            $datos["mesas"]=$mesas;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    public function pedidos_pendientes_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $mesas=$this->mesa_model->listar_mesas();
            for ($i=0;$i<count($mesas);$i++) {
                $mesas[$i]["pedidosPendientes"]=$this->pedido_model->listar_pedidos_pendientes_by_mesa($mesas[$i]["idMesa"]);
            }
            $datos["mesas"]=$mesas;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    public function pedidos_entregados_get() {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $mesas=$this->mesa_model->listar_mesas();
            for ($i=0;$i<count($mesas);$i++) {
                $mesas[$i]["pedidosEntregados"]=$this->pedido_model->listar_pedidos_entregados_by_mesa($mesas[$i]["idMesa"]);
            }
            $datos["mesas"]=$mesas;
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
    public function importeByMesa_get($idMesa) {
        if(jwt_helper::tokenValido($this->input->request_headers())) {
            $importe=$this->mesa_model->getImportebyMesa($idMesa);
            $datos["importe"]=$importe["importe"];
            $response=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al ejecutar servicio","datos"=>$datos);
            $this->set_response($response,REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(getNoAutorizadoResponse(),REST_Controller::HTTP_OK);
        return;
    }
}