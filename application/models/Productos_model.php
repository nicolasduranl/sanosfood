<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function listar($cant = 10, $pag = 1, $cat = null, $car = null){
    	if($cat!= null){
    			}

		if($car != null){
				}

		$this->db->from('productos');
		$this->db->limit($cant,$cant*($pag-1));
		$query = $this->db->get();
		return $query->result();
    }
    function producto($id = null){
    	$this->db->where('id', $id);
    	$query = $this->db->get('productos', 1, 0);
    	return $query->result();
    }

}

/* End of file Productos_model.php */
/* Location: ./application/models/Productos_model.php */