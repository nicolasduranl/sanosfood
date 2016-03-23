<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get($id=null){
        $this->db->where('id', $id);
        $query = $this->db->get('usuarios', 1, 0);
        if($query->num_rows()!=1){
            return false;
        }
        return $query->row();
    }

    function encontrar($usuario = null){
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios', 1, 0);
        if($query->num_rows()!=1){
            return false;
        }
        return $query->row();
    }

    function listar(){
        $this->db->order_by('nombres', 'asc');
    	$query = $this->db->get('usuarios');
    	return $query->result();
    }
    function editar($id = NULL, $atributo = NULL, $valor = NULL){
        if($id != NULL AND $atributo != NULL AND $valor != NULL){
            $this->db->trans_start();
            $object = array($atributo => $valor);
            $this->db->where('id', $id);
            $this->db->update('usuarios', $object);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return array('res'=>'bad','msj'=>'Error en la edición.'); }
            else {return array('res'=>'ok'); }
        }
    }
    function eliminar($id = null){
        if($id == null){
            return array('res'=>'bad','msj'=>'Error en la inserción.'); }
        $this->db->where('id', $id);
        $this->db->delete('usuarios');
        return array('res'=>'ok');
    }


    function web_logear($usuario = null, $clave = null) {
        $this->db->select('clave')->from('usuarios')->where('usuario', $usuario)->limit(1, 0);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            $data['res'] = 'bad';
            $data['msj'] = 'No existe este nombre de usuario';
            return $data;
        }
        
        $row = $query->row();

//        if($row->clave == sha1(sha1($usuario).'sal sanosfood'.sha1($clave))) {
        if($row->clave == $clave) {
            $this->session->set_userdata('logeado',true);
            $this->session->set_userdata('usuario',$usuario);
            $data['res'] = 'ok';
            return $data;
        }
        $data['res'] = 'bad';
        $data['msj'] = 'Usuario o Clave invalido';
        return $data;

    }

    function crear($email = null, $usuario = null, $clave = null) {

        $this->db->where('usuario', $usuario);
        if($this->db->count_all_results('usuarios') > 0) {
            $data['res'] = 'bad';
            $data['msj'] = 'Ya existe un Usuario con este nombre';
            return $data;
        }

        $object = array('correo' => $email, 'usuario' => $usuario, 'clave' => $clave);

        $this->db->insert('usuarios', $object);

        $this->session->set_userdata('logeado',true);
        $this->session->set_userdata('usuario',$usuario);

        $data['res'] = 'ok';
        return $data;
    }

    function buscar($query = ''){
        if($query ==""){ $data['usuarios'] = array(); }
        
        if($query =="*") {
            $query = $this->db->query(" SELECT id,nombres,apellidos,usuario,correo,ciudad
                                        FROM usuarios;");
            return $query->result();
        }

        $palabras = preg_split("/ (.| ) /", $query);
        $against = "";
        foreach ($palabras as $palabra) {
            $against .= $palabra.'* ';
        }
        $query = $this->db->query(" SELECT id,nombres,apellidos,usuario,correo,ciudad
                                    FROM usuarios
                                    WHERE MATCH(nombres,apellidos,usuario,correo,ciudad) AGAINST ('$against' IN BOOLEAN MODE);");
        return $query->result();
    }
}

/* End of file Caracteristicas_model.php */
/* Location: ./application/models/Caracteristicas_model.php */