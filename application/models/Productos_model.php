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

    /**
     * Description :  Obtiene los x productos más buscados
     * Attributes  :  limit
     *
     **/

    public function get_popular_productos( $limit )
    {
        $this->db->select('sum(busquedas) busquedas , pr.*')
                 ->from('palabra_producto pp ')
                 ->join('producto pr', 'pr.id_producto = pp.id_producto')
                 ->group_by('pr.id_producto')
                 ->order_by('busquedas' ,'DESC') 
                 ->limit($limit);
                 
        $query = $this->db->get();
        if( $query->result() > 0){
             return $query->result();
        }

        return false;
    }

}
