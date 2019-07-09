<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mesa_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function listar_mesas() {
        $sql="CALL listar_mesas()" ;
        $query=$this->db->query($sql); 
        $mesas=$query->result_array();
        $query->next_result(); 
        $query->free_result();
        return $mesas;
    }
}