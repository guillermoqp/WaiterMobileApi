<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cliente_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function listar_clientes() {
        $sql="CALL listar_clientes()" ;
        $query=$this->db->query($sql); 
        $clientes=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $clientes;
    }
    public function insertar_cliente($nombres,$apellidos,$tipoDoc,$nroDoc) {
        $sql="CALL insertar_cliente(?,?,?,?)";
        $this->db->trans_begin();
        $query=$this->db->query($sql,array($nombres,$apellidos,$tipoDoc,$nroDoc));
        $query->next_result();
        $query->free_result();
        $query=$this->db->query('SELECT @id_salida as id_salida');
        $id_salida=$query->row_array();
        $id_cliente=$id_salida["id_salida"];
        $status=$this->db->trans_status();
        if ($status===FALSE) {
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
        return $id_cliente;
    }
}