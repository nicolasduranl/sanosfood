<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadosproductos_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function listar(){
        $this->db->order_by('nombre', 'asc');
    	$query = $this->db->get('estadosproductos');
    	return $query->result();
    }	
	function editar($id = NULL, $atributo = NULL, $valor = NULL){
        if($id != NULL AND $atributo != NULL AND $valor != NULL){
            $this->db->trans_start();
            $object = array($atributo => $valor);
            $this->db->where('id', $id);
            $this->db->update('estadosproductos', $object);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return array('res'=>'bad','msj'=>'Error en la edición.'); }
            else { return array('res'=>'ok'); }
        }
    }
    function crear($nombre = null, $descripcion = null){
        if($nombre == NULL OR $descripcion == null){
            return array('res'=>'bad','msj'=>'Error en la creación.'); }

        if(strlen($nombre)<3){
            return array('res'=>'bad','msj'=>'Ingresa un nombre adecuado'); }

        $this->db->where('nombre', $nombre);
        if($this->db->count_all_results('estadosproductos')>0){
            return array('res'=>'bad','msj'=>'Ya existe un estado con este nombre'); }

        $object = array('nombre' => $nombre, 'descripcion' => $descripcion);
        $this->db->insert('estadosproductos', $object);
        return array('res'=>'ok','id'=>$this->db->insert_id());
    }
    function eliminar($id = null){
        if($id == null){
            return array('res'=>'bad','msj'=>'Error en la inserción.'); }
        $this->db->where('id', $id);
        $this->db->delete('estadosproductos');
        return array('res'=>'ok');
    }
}

/* End of file Estados_model.php */
/* Location: ./application/models/Estados_model.php */