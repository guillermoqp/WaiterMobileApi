<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pedido_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function listar_pedidos_by_mesa($idMesa) {
        $sql="CALL listar_pedidos_by_mesa(?)" ;
        $query=$this->db->query($sql,array($idMesa)); 
        $pedidos=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $pedidos;
    }
    public function listar_pedidos_pendientes_by_mesa($idMesa) {
        $sql="CALL listar_pedidos_pendientes_by_mesa(?)" ;
        $query=$this->db->query($sql,array($idMesa)); 
        $pedidos_pendientes=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $pedidos_pendientes;
    }
    public function listar_pedidos_entregados_by_mesa($idMesa) {
        $sql="CALL listar_pedidos_entregados_by_mesa(?)" ;
        $query=$this->db->query($sql,array($idMesa)); 
        $pedidos_entregados=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $pedidos_entregados;
    }
    public function cambiarPedido($idMesa,$id_plato,$cantidad) {
        $respuesta=array("codigoRespuesta"=>0,"mensajeRespuesta"=>"Exito al cambiarPedido.");
        $sql="CALL cambiarPedido(?,?,?)";
        $this->db->trans_begin();
        $query=$this->db->query($sql,array($idMesa,$id_plato,$cantidad));
        if ($this->db->trans_status()===FALSE) {
            $db_error=$this->db->error();
            if (strcmp($db_error["code"],"00000")!=0) {
                $respuesta=array("codigoRespuesta"=>1,"mensajeRespuesta"=>$db_error['message']);
                $this->db->trans_rollback();
            }
        }
        if ($this->db->trans_status()!=FALSE){
            $this->db->trans_commit();
        }
        return $respuesta;
    }
}