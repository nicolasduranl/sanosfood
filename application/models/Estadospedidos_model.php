<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadospedidos_model extends CI_Model {

	function __construct() { parent::__construct(); }

//---------------------------------------------------------listar
    function listar(){
        $this->db->order_by('id', 'asc');
    	$query = $this->db->get('estadospedidos');
    	return $query->result();
    }	
    
//---------------------------------------------------------traerid
    function traerid($nombre = null){
        $this->db->select('id');
        $this->db->where('nombre', $nombre);
        $idestado = $this->db->get('estadospedidos', 1, 0)->row()->id;
        return $idestado;
    }   

//---------------------------------------------------------editar
	function editar($id = null, $atributo = null, $valor = null){
         if($id != null AND $atributo != null AND $valor != null){
            if($atributo =="nombre"){
                $this->db->where('nombre', $valor);
                if($this->db->count_all_results('estadospedidos')>0){
                    return array('res'=>'bad','msj'=>'ERROR en edición. Ya existe un Estado con ese nombre.'); }
            }
            $this->db->trans_start();
            $object = array($atributo => $valor);
            $this->db->where('id', $id);
            $this->db->update('estadospedidos', $object);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return array('res'=>'bad','msj'=>'ERROR en edición.'); }
            else {return array('res'=>'ok'); }
        }
    }

//---------------------------------------------------------crear
    function crear($nombre = null, $descripcion = null){
        if($nombre == null OR $descripcion == null){
            return array('res'=>'bad','msj'=>'ERROR en la creación.'); }

        if(strlen($nombre)<3){
            return array('res'=>'bad','msj'=>'ERROR, Ingresa un nombre adecuado'); }

        $this->db->where('nombre', $nombre);
        if($this->db->count_all_results('estadospedidos')>0){
            return array('res'=>'bad','msj'=>'ERROR, Ya existe un estado con este nombre'); }

        $object = array('nombre' => $nombre, 'descripcion' => $descripcion);
        $this->db->insert('estadospedidos', $object);
        return array('res'=>'ok','id'=>$this->db->insert_id());
    }

//---------------------------------------------------------eliminar
   function eliminar($id = null){
        if($id == null){
            return array('res'=>'bad','msj'=>'ERROR en la inserción.'); }
        $this->db->where('idestadopedido', $id);
        if($this->db->count_all_results('pedidos')>0){
            return array('res'=>'bad','msj'=>'ERROR no se puede eliminar. Hay pedidos asociados a este estado.'); }
        $this->db->where('id', $id);
        $this->db->delete('estadospedidos');
        return array('res'=>'ok');
    }
}


// End of file Estadospedidos_model.php 
// Location: ./application/models/Estadospedidos_model.php