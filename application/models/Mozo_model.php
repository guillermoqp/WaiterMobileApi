<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mozo_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function login_mozo($usuario,$password) {
        $sql="CALL login_mozo(?,?)" ;
        $query=$this->db->query($sql,array($usuario,$password)); 
        $mozo=$query->row_array();/* una sola FILA , ->result_array() https://www.codeigniter.com/user_guide/database/queries.html */
        $query->next_result(); 
        $query->free_result();
        return $mozo;
    }
}