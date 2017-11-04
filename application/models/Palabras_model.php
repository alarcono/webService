<?php

class Palabras_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Description :  Verifica existencia de palabra buscada en bd
     * Attributes  :  keyWord
     *
     **/

    public function get_palabras($keyWord)
    {
        $this->db->select('*')
                 ->from('palabra')
                 ->where('palabra',$keyWord);
                 
        $query = $this->db->get();
        if( $query->num_rows() > 0){
             return $query->row();
        }

        return false;
    }

    /**
     * Description :  Verifica si existe relación entre palabra y producto
     * Attributes  :  keyWordID , productID
     *
     **/

    public function get_palabra_producto($keyWordId , $productId)
    {
        $this->db->select('*')
                 ->from('palabra_producto')
                 ->where('id_palabra',$keyWordId)
                 ->where('id_producto',$productId);
                 
        $query = $this->db->get(); 
        if( $query->num_rows() > 0){
             return $query->row();
        }

        return false;
    }

    /**
     * Description :  Obtiene las x palabras más buscada según id producto
     * Attributes  :  productID , limit
     *
     **/

    public function get_popular_palabra($productId , $limit)
    {
        $this->db->select('sum(pp.busquedas) busquedas, pa.*')
                 ->from('palabra_producto pp')
                 ->join('palabra pa','pa.id_palabra  = pp.id_palabra')
                 ->where('pp.id_producto',$productId)
                 ->group_by('pp.id_palabra')
                 ->order_by('pp.busquedas DESC')
                 ->limit($limit);
                 
        $query = $this->db->get(); 
        if( $query->result() > 0){
             return $query->result();
        }

        return false;
    }

    /**
     * Description :  Inserta nueva palabra
     * Attributes  :  keyWord
     *
     **/

    public function insert_palabra($keyWord)
    {
        $data = array(
        'palabra' => $keyWord,

        );

        $this->db->insert('palabra', $data);
        return $this->db->insert_id();
    }

    /**
     * Description :  Inserta asociación entre palabra y producto
     * Attributes  :  keyWord
     *
     **/

    public function insert_palabra_producto($keyWordId , $productId)
    {
        $data = array(
        'id_palabra' => $keyWordId,
        'id_producto'=> $productId,
        'busquedas'   => 1 

        );

        $this->db->insert('palabra_producto', $data);
        return $this->db->insert_id();
    }

    /**
     * Description :  actualiza el número de busqueda por palabra/producto
     * Attributes  :  keyWordId , productId , $busquedas
     *
     **/

    public function update_palabra_producto($keyWordId , $productId , $busquedas)
    {
        $this->db->set('busquedas', $busquedas)
                 ->where('id_palabra', $keyWordId)
                 ->where('id_producto', $productId)
                 ->update('palabra_producto'); 
    }

}
