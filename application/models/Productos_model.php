<?php

class Productos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Description :  Realiza búsqueda de producto según palabra clave
     * Attributes  :  keyWord
     *
     **/

    public function get_productos_like($keyWord)
    {
        $this->db->select('*')
                 ->from('producto')
                 ->like('tags',$keyWord);
                 
        $query = $this->db->get(); 
        if( $query->result() > 0){
             return $query->result();
        }

        return false;
    }


}
