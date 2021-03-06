<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_model extends CI_Model {

	function __construct() { parent::__construct(); }

//---------------------------------------------------------listar
    function listar() {
        $this->db->order_by('nombre', 'asc');
    	$query = $this->db->get('categorias');
    	return $query->result();
    }	

//---------------------------------------------------------listarConProductos
    function listarConProductos() {
        $estado = PRODUCTO_DISPONIBLE;
        $query = $this->db->query(" SELECT pc.idcategoria as id, c.nombre, count(pc.idcategoria) as cuentas
                                    FROM pro_cat AS pc, productos AS p, categorias AS c   
                                    WHERE p.estado = '$estado' AND p.id = pc.idproducto AND pc.idcategoria = c.id
                                    GROUP BY pc.idcategoria;");
        return $query->result();
    }   
	
//---------------------------------------------------------editar
    function editar($id = null, $atributo = null, $valor = null) {
        if($id != null AND $atributo != null AND $valor != null) {
            if($atributo =="nombre"){
                $this->db->where('nombre', $valor);
                if($this->db->count_all_results('categorias')>0){
                    return array('res'=>'bad','msj'=>'ERROR en edición. Ya existe una categoria con ese nombre.'); }
            }
            $this->db->trans_start();
            $object = array($atributo => $valor);
            $this->db->where('id', $id);
            $this->db->update('categorias', $object);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return array('res'=>'bad','msj'=>'ERROR en edición.'); }
            else {return array('res'=>'ok'); }
        }
    }
    
//---------------------------------------------------------crear
    function crear($nombre = null, $descripcion = null){
        if($nombre == null OR $descripcion == null){
            return array('res'=>'bad','msj'=>'ERROR en creación.'); }

        if(strlen($nombre)<3){
            return array('res'=>'bad','msj'=>'ERROR, Ingresa un nombre adecuado'); }

        $this->db->where('nombre', $nombre);
        if($this->db->count_all_results('categorias')>0){
            return array('res'=>'bad','msj'=>'ERROR, Ya existe una categoría con este nombre'); }

        $object = array('nombre' => $nombre, 'descripcion' => $descripcion);
        $this->db->insert('categorias', $object);
        return array('res'=>'ok','id'=>$this->db->insert_id());
    }
    
//---------------------------------------------------------eliminar
    function eliminar($id = null){
        if($id == null){
            return array('res'=>'bad','msj'=>'ERROR en inserción.'); }
        $this->db->where('idcategoria', $id);
        if($this->db->count_all_results('pro_cat')>0){
            return array('res'=>'bad','msj'=>'ERROR en inserción. Hay productos asociados a esta categoria.'); }
        $this->db->where('id', $id);
        $this->db->delete('categorias');
        return array('res'=>'ok');
    }
}

// End of file Categorias_model.php 
// Location: ./application/models/Categorias_model.php 