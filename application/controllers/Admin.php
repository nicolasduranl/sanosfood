<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

//---------------------------------------------------------Index
	public function index() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Productos_model');
		$data = $this->Productos_model->listar();
		$data["cual"] = "Todos";
		$this->load->view('admin/productos',$data,FALSE); 
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------login
	public function login() {
		$this->load->view('admin/login');
	}

//---------------------------------------------------------logout
	public function logout() {
        $this->session->set_userdata('logeado_admin',false);
        $this->session->set_userdata('usuario',"");
        $this->session->set_userdata('tipo',"");
		$this->load->view('admin/login');
	}

//---------------------------------------------------------validarusuario
	public function validarusuario() {
		$this->load->model('Admin_model');
		$this->load->view('admin/validarusuario', array('resultado'=>$this->Admin_model->validarUsuario()), FALSE);
	}

//---------------------------------------------------------home
	public function home() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->view('admin/home');
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------crearproducto
	public function crearproducto(){
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Estadosproductos_model');
		$data['estados'] = $this->Estadosproductos_model->listar();
		$this->load->model('Caracteristicas_model');
		$data['caracteristicas'] = $this->Caracteristicas_model->listar();
		$this->load->model('Categorias_model');
		$data['categorias'] = $this->Categorias_model->listar();
		$this->load->model('Marcas_model');
		$data['marcas'] = $this->Marcas_model->listar();
		$this->load->view('admin/crearproducto',$data,FALSE);
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------productos
	public function productos($estadopro = null) {
		if($estadopro == null){ show_404();
		}
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Productos_model');
		if ($estadopro == "Todos") {
			$data = $this->Productos_model->listar();}
		else {
			$data = $this->Productos_model->getProductosPorEstado($estadopro);
		}
		$this->load->view('admin/productos',$data,FALSE); 
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------producto
	public function producto($id = null) {
		if($id == null){ show_404();
		}
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Productos_model');
		$this->load->model('Estadosproductos_model');
		$this->load->model('Marcas_model');
		$data['marcas'] = $this->Marcas_model->listar();
		$this->load->model('Caracteristicas_model');
		$data['caracteristicas'] = $this->Caracteristicas_model->listar();
		$this->load->model('Categorias_model');
		$data['categorias'] = $this->Categorias_model->listar();
		$data['producto'] = $this->Productos_model->producto($id);
		$data['estados'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/producto', $data, FALSE); 
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------caracteristicas
	public function caracteristicas() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Caracteristicas_model');
		$data['caracteristicas'] = $this->Caracteristicas_model->listar();
		$this->load->view('admin/caracteristicas', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------categorias
	public function categorias() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Categorias_model');
		$data['categorias'] = $this->Categorias_model->listar();
		$this->load->view('admin/categorias', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------estadosproductos
	public function estadosproductos() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Estadosproductos_model');
		$data['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/estadosproductos', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------estadospedidos
	public function estadospedidos() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$data['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->view('admin/estadospedidos', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------marcas
	public function marcas() {
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Marcas_model');
		$data['marcas'] = $this->Marcas_model->listar();
		$this->load->view('admin/marcas', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------usuarios
	public function usuarios($id = null){
		if($id==null){ show_404();
		}
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Usuarios_model');
		$data['usuario'] = $this->Usuarios_model->get($id);
		if(!$data['usuario']){ show_404();
		}
		$this->load->model('Pedidos_model');
		$data['usuario']->pedidos = $this->Pedidos_model->pedidosUsuario($data['usuario']->id);
		$this->load->view('admin/usuario', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------pedido
	public function pedido($id = null){
		if($id==null){ show_404();
		}
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Pedidos_model');
		$data['pedido'] = $this->Pedidos_model->getPedido($id);
		$this->load->view('admin/pedido', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------pedidos
	public function pedidos($estado = null, $pag = 1){
		if($estado==null){ show_404();}

		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->model('Pedidos_model');
		$data['pedidos'] = $this->Pedidos_model->getPedidosPorEstado($estado,$pag);
		$data['estados'] = $dataencabezado['estadospedidos'];

		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/pedidos/'.$estado.'/';
		$config['total_rows'] = $this->Pedidos_model->contarPedidos($estado);
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<nav class="text-center"><ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="disabled"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['next_link'] = '&rsaquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&lsaquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$this->load->view('admin/pedidosxestado', $data, FALSE);
		$this->load->view('admin/piedepagina');
	}

//---------------------------------------------------------crearusuario
	public function crearusuario(){
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->view('admin/crearusuario');
		$this->load->view('admin/piedepagina');
	}
	
//---------------------------------------------------------buscarusuarios
	public function buscarusuarios(){
		$this->load->model('Estadospedidos_model');
		$dataencabezado['estadospedidos'] = $this->Estadospedidos_model->listar();
		$this->load->model('Estadosproductos_model');
		$dataencabezado['estadosproductos'] = $this->Estadosproductos_model->listar();
		$this->load->view('admin/encabezado',$dataencabezado,FALSE);
		$this->load->view('admin/buscarusuarios');
		$this->load->view('admin/piedepagina');
	}
}