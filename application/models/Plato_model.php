<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Plato_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function listar_platos() {
        $sql="CALL listar_platos()" ;
        $query=$this->db->query($sql); 
        $platos=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $platos;
    }
}