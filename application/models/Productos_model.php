<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos_model extends CI_Model {

	function __construct() { parent::__construct(); }

//---------------------------------------------------------crear
    function crear( $nombre = null, $descripcion = null, $ingredientes = null){
        if(strlen($nombre) < 5){
            $data['res'] = 'bad';
            $data['msj'] = 'El nombre del producto debe tener al menos 5 caracteres';
            return $data;
        }
        $this->db->where('nombre', $nombre);
        if($this->db->count_all_results('productos')>0){
            $data['res'] = 'bad';
            $data['msj'] = 'ERROR, Ya existe un Producto con este nombre';
            return $data;
        }
/*
        $slug = url_title(limpiarString($nombre),'dash',TRUE);
        $this->db->select('id');
        $this->db->where('nombre', PRODUCTO_INACTIVO);
        $query = $this->db->get('estadosproductos', 1, 0);
        $idinactivo = $query->row()->id;
*/
        $object = array('nombre' => $nombre, 
                        'descripcion' => $descripcion,
                        'descripcioncorta' => "",
                        'ingredientes' => $ingredientes,
                        'idmarca' => "",
                        'precio' => 0,
                        'peso' => 0,
                        'pesoneto' => 0,
                        'largo' => 0,
                        'ancho' => 0,
                        'alto' => 0,
                        'existencias' => 0,
                        'slug' => $slug,
                        'estado' => PRODUCTO_INACTIVO);

        $this->db->insert('productos', $object);
        $id = $this->db->insert_id();
        $data['res'] = 'ok';
        $data['id'] = $id;
        return $data;
    }

//---------------------------------------------------------devuelve todos los productos con un estado especifico
    function getProductosPorEstado($estadopro = null, $cant = 10, $pag = 1, $cat = null, $car = null){
        $this->db->where('estado', $estadopro);
        $data['cant'] = $this->db->count_all_results('productos');
        
        $this->db->where('estado', $estadopro);
        $this->db->from('productos');
        $this->db->limit($cant,$cant*($pag-1));
        $query = $this->db->get();

/*        foreach ($query->result() as $row) {
            $this->db->select('nombre');
            $this->db->where('id', $row->estado);
            $row->nombreestado = $this->db->get('estadosproductos', 1, 0)->row()->nombre;
        }

        $this->db->select('nombre');
        $this->db->where('id', $estadopro);
        $data["nombreestado"] = $this->db->get('estadosproductos', 1, 0)->row()->nombre;
*/        
        $data['productos'] = $query->result();
        return $data;
    }

//---------------------------------------------------------devuelve todos los productos con palabra buscada
    function buscarProductosWeb($quebuscar = null, $pag = 1, $ppp = 3){
        $estado = PRODUCTO_DISPONIBLE;
        $pagina = $ppp * ($pag - 1);
        if($quebuscar == "*"){
            $query = $this->db->query("SELECT * FROM productos 
                                        WHERE estado = '$estado' 
                                        LIMIT $ppp offset $pagina");
        }
        else {
            $palabras = preg_split("/ (.| ) /", $quebuscar);
            $against = "";
            foreach ($palabras as $palabra) {
                $against .= $palabra.'* ';
            }

            $query = $this->db->query("SELECT * FROM productos 
                        WHERE MATCH (nombre,descripcion,ingredientes) AGAINST ('$against' IN BOOLEAN MODE) and estado = '$estado' 
                        LIMIT $ppp offset $pagina");
        }
        
        foreach ($query->result() as $row) {
            $this->db->select('imagen');
            $this->db->where('idproducto', $row->id);
            $row->imagen = $this->db->get('imagenes', 1, 0)->row()->imagen;
        }
        return $query->result();
    }
//---------------------------------------------------------Obtiene cantidad total de productos por la busqueda
    function contarProductosBuscar($quebuscar = null){
        $estado = PRODUCTO_DISPONIBLE;
        if($quebuscar == "*"){
            $query = $this->db->query("SELECT * FROM productos 
                        WHERE estado = '$estado';");
        }
        else {
            $palabras = preg_split("/ (.| ) /", $quebuscar);
            $against = "";
            foreach ($palabras as $palabra) {
                $against .= $palabra.'* ';
            }
            $query = $this->db->query("SELECT * FROM productos 
                        WHERE MATCH (nombre,descripcion,ingredientes) AGAINST ('$against' IN BOOLEAN MODE) and estado = '$estado';");
        }
        return $query->num_rows();
    }

//---------------------------------------------------------ListarxCategoriaWeb
    function listarxCategoriaWeb($cat = null, $pag = 1, $ppp = 1){
        $estado = PRODUCTO_DISPONIBLE;
        $pagina = $ppp * ($pag - 1);
        $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                            WHERE pc.idcategoria = $cat and pc.idproducto = p.id and p.estado = '$estado'
                            LIMIT $ppp OFFSET $pagina;");
        foreach ($query->result() as $row) {
//            $this->db->select('nombre');
//            $this->db->where('id', $row->estado);
//            $row->nombreestado = $this->db->get('estadosproductos', 1, 0)->row()->nombre;
            $this->db->select('imagen');
            $this->db->where('idproducto', $row->id);
            $row->imagen = @$this->db->get('imagenes', 1, 0)->row()->imagen;
        }
        return $query->result();
    }

//---------------------------------------------------------Obtiene cantidad total de productos por la categoria
    function contarProductosCategoria($cat = null){
        $estado = PRODUCTO_DISPONIBLE;
        $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                            WHERE pc.idcategoria = $cat and pc.idproducto = p.id and p.estado = '$estado'");
        return $query->num_rows();
    }

//---------------------------------------------------------ListarxMarcaiaWeb
    function listarxMarcaWeb($mar = null, $pag = 1, $ppp = 1){
        $estado = PRODUCTO_DISPONIBLE;
        $pagina = $ppp * ($pag - 1);
        $query = $this->db->query(" SELECT * FROM productos 
                                    WHERE idmarca = $mar and estado = '$estado' 
                                    LIMIT $ppp OFFSET $pagina;");
        foreach ($query->result() as $row) {
            $this->db->select('imagen');
            $this->db->where('idproducto', $row->id);
            $row->imagen = @$this->db->get('imagenes', 1, 0)->row()->imagen;
        }
        return $query->result();
    }

//---------------------------------------------------------Obtiene cantidad total de productos por la marca
    function contarProductosMarca($mar = null){
        $this->db->where('idmarca', $mar);
        $this->db->where('estado', PRODUCTO_DISPONIBLE);    
        $query = $this->db->get('productos');
//        $query = $this->db->query(" SELECT * FROM productos 
//                                    WHERE idmarca = $mar and estado = '$estado';");
        return $query->num_rows();
    }

//---------------------------------------------------------Obtiene un producto
    function producto($id = null){
        $this->db->where('id', $id);
        $query = $this->db->get('productos', 1, 0);
        $producto = $query->row();
        $this->db->select('nombre');
        $this->db->where('id', $producto->idmarca);
        $producto->marca = @$this->db->get('marcas', 1, 0)->row()->nombre;
        $this->db->where('idproducto', $producto->id);
        $producto->caracteristicas = $this->db->get('pro_car')->result();
        $this->db->where('idproducto', $producto->id);
        $producto->categorias = $this->db->get('pro_cat')->result();

        $this->db->where('idproducto', $producto->id);
        $producto->imagenes = $this->db->get('imagenes')->result();
        return $producto;
    }
    
//---------------------------------------------------------ListarWeb
    function listar($cant = 10, $pag = 1, $cat = null, $mar = null){
        $data['cant'] = $this->db->count_all_results('productos');
        
        $pagina = $cant * ($pag - 1);
        if($cat!= null && $mar != null){
            $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                                        WHERE pc.idcategoria = $cat and pc.idproducto = p.id and p.idmarca = $mar
                                        LIMIT $cant OFFSET $pagina;");
        } else { 
            if($mar != null){
                $query = $this->db->query(" SELECT * FROM productos WHERE idmarca = $mar and LIMIT $cant OFFSET $pagina;");
            } else { 
                if($cat != null){
                    $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                                        WHERE pc.idcategoria = $cat and pc.idproducto = p.id 
                                        LIMIT $cant OFFSET $pagina;");
                } else {
                    $this->db->from('productos');
                    $this->db->limit($cant, $cant*($pag - 1));
                    $query = $this->db->get();
                }
            } 
        }
        foreach ($query->result() as $row) {
            $this->db->select('imagen');
            $this->db->where('idproducto', $row->id);
            $row->imagen = @$this->db->get('imagenes', 1, 0)->row()->imagen;
        }
        $data["estado"] = "Todos";
        $data['productos'] = $query->result();
        $data['res'] = 'ok'; 

        return $data;
    }

//--------------------------------ListarWeb----------------OBSOLETA
    function listarWeb($cant = 10, $pag = 1, $cat = null, $mar = null){
        $estado = PRODUCTO_DISPONIBLE;
        $data['cant'] = $this->db->count_all_results('productos');
        
        $pagina = $cant * ($pag - 1);
        if($cat!= null && $mar != null){
            $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                                        WHERE pc.idcategoria = $cat and pc.idproducto = p.id and p.idmarca = $mar and p.estado = '$estado'
                                        LIMIT $cant OFFSET $pagina;");
        } else { 
            if($mar != null){
                $query = $this->db->query(" SELECT * FROM productos WHERE idmarca = $mar and estado = '$estado' LIMIT $cant OFFSET $pagina;");
            } else { 
                if($cat != null){
                    $query = $this->db->query(" SELECT * FROM pro_cat AS pc, productos AS p 
                                        WHERE pc.idcategoria = $cat and pc.idproducto = p.id and p.estado = '$estado'
                                        LIMIT $cant OFFSET $pagina;");
                } else {
                    $this->db->from('productos');
                    $this->db->where('estado', PRODUCTO_DISPONIBLE);
                    $this->db->limit($cant, $cant*($pag - 1));
                    $query = $this->db->get();
                }
            } 
        }
        foreach ($query->result() as $row) {
            $this->db->select('imagen');
            $this->db->where('idproducto', $row->id);
            $row->imagen = @$this->db->get('imagenes', 1, 0)->row()->imagen;
        }
        $data['productos'] = $query->result();
        $data['res'] = 'ok'; 

        return $data;
    }

//---------------------------------------------------------Valida campos de Producto con estado diferente de DISPONIBLE
    function editar($dataproducto = null){
        if(json_decode($dataproducto) == null && json_last_error() !== JSON_ERROR_NONE){
            $data['res'] = 'bad';
            $data['msj'] = 'Ha ocurrido un error enviando los datos del producto.';
            return $data;
        }
        $dataproducto = json_decode($dataproducto);
        $datacategorias = $dataproducto->categorias;
        $datacaracteristicas = $dataproducto->caracteristicas;

        $data['est'] = ''; 
        $data['cmp'] = ''; 
        $data['res'] = ''; 

        $objeto = array();
        if (array_key_exists('nombre', $dataproducto)) {
            $nombre = $dataproducto->nombre;
            if ($nombre !== "" AND strlen($nombre) < 8) {
                $data['msj'] = 'El nombre del producto debe tener al menos 8 caracteres';
                $data['res'] = 'bad'; $data['cmp'] = 'nombre'; return $data; 
            } else { $objeto['nombre'] = $nombre;
                     $slug = url_title(limpiarString($nombre),'dash',TRUE);
                     $objeto['slug'] = $slug; }
        }    
        if (array_key_exists('descripcion', $dataproducto)) {
            $descripcion = $dataproducto->descripcion;
            if ($descripcion !== "" AND strlen($descripcion) < 10) {
                $data['msj'] = 'La descripcion del producto debe tener al menos 10 caracteres';
                $data['res'] = 'bad'; $data['cmp'] = 'descripcion'; return $data; 
            } else { $objeto['descripcion'] = $descripcion; }
        } 
        if (array_key_exists('descripcioncorta', $dataproducto)) {
            $descripcioncorta = $dataproducto->descripcioncorta;
            if ($descripcioncorta !== "" AND strlen($descripcioncorta) < 5) {
                $data['msj'] = 'La descripcion corta del producto debe tener al menos 5 caracteres';
                $data['res'] = 'bad'; $data['cmp'] = 'descripcioncorta'; return $data; 
            } else { $objeto['descripcioncorta'] = $descripcioncorta; }
        } 
        if (array_key_exists('ingredientes', $dataproducto)) {
            $ingredientes = $dataproducto->ingredientes;
            if ($ingredientes !== "" AND strlen($ingredientes) < 10) {
                $data['msj'] = 'Ingredientes del producto debe tener al menos 10 caracteres';
                $data['res'] = 'bad'; $data['cmp'] = 'ingredientes'; return $data; 
            } else { $objeto['ingredientes'] = $ingredientes; }
        }
        if (array_key_exists('peso', $dataproducto)) {
            $peso = $dataproducto->peso;
            if ($peso !== "" AND filter_var($peso, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'El Peso del producto debe ser un número entero';
                $data['res'] = 'bad'; $data['cmp'] = 'peso'; return $data; 
            } else { $objeto['peso'] = $peso; }
        }
        if (array_key_exists('pesoneto', $dataproducto)) {
            $pesoneto = $dataproducto->pesoneto;
            if ($pesoneto !== "" AND filter_var($pesoneto, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'El Peso Neto del producto debe ser un número entero';
                $data['res'] = 'bad'; $data['cmp'] = 'pesoneto'; return $data; 
            } else { $objeto['pesoneto'] = $pesoneto; }
        }
        if (array_key_exists('largo', $dataproducto)) {
            $largo = $dataproducto->largo;
            if ($largo !== "" AND filter_var($largo, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'El Largo del producto debe ser un número entero';
                $data['res'] = 'bad'; $data['cmp'] = 'largo'; return $data; 
            } else { $objeto['largo'] = $largo; }
        }
        if (array_key_exists('ancho', $dataproducto)) {
            $ancho = $dataproducto->ancho;
            if ($ancho !== "" AND filter_var($ancho, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'El Ancho del producto debe ser un número entero';
                $data['res'] = 'bad'; $data['cmp'] = 'ancho'; return $data; 
            } else { $objeto['ancho'] = $ancho; }
        }
        if (array_key_exists('alto', $dataproducto)) {
            $alto = $dataproducto->alto;
            if ($alto !== "" AND filter_var($alto, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'El Alto del producto debe ser un número entero';
                $data['res'] = 'bad'; $data['cmp'] = 'alto'; return $data; 
            } else { $objeto['alto'] = $alto; }
        }
        if (array_key_exists('idmarca', $dataproducto)) {
            $idmarca = $dataproducto->idmarca;
            $objeto['idmarca'] = $idmarca; 
        }
        if (array_key_exists('precio', $dataproducto)) {
            $precio = $dataproducto->precio;
            if ($precio !== "" AND filter_var($precio, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'Ingresa un Precio válido';
                $data['res'] = 'bad'; $data['cmp'] = 'precio'; return $data; 
            } else { $objeto['precio'] = $precio; }
        }
        if (array_key_exists('existencias', $dataproducto)) {
            $existencias = $dataproducto->existencias;
            if ($existencias !== "" AND filter_var($existencias, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) == null) {
                $data['msj'] = 'Ingresa un valor de Existencias válido';
                $data['res'] = 'bad'; $data['cmp'] = 'existencias'; return $data; 
            } else { $objeto['existencias'] = $existencias; }
        }

        $this->db->select('estado');
        $this->db->where('id', $dataproducto->id);
        $query = $this->db->get('productos', 1, 0);
        $estado = $query->row()->estado;

        $this->db->trans_start();

        if (count($objeto) > 0) {
            if ($estado == PRODUCTO_DISPONIBLE) {
                $objeto['estado'] = PRODUCTO_INACTIVO;
                $data['est'] = PRODUCTO_INACTIVO; 
            }
            $this->db->where('id', $dataproducto->id);
            $this->db->update('productos', $objeto);
        }

        //--------------------------------Borrado y grabado de nuevas categorias del producto
        $this->db->where('idproducto', $dataproducto->id);
        $this->db->delete('pro_cat');
        foreach ($datacategorias as $categoria) {
            $object = array('idproducto' => $dataproducto->id,
                            'idcategoria' => $categoria->idcategoria);
            $this->db->insert('pro_cat', $object);
        }

        //--------------------------------Borrado y grabado de nuevas caracteristicas del producto
        $this->db->where('idproducto', $dataproducto->id);
        $this->db->delete('pro_car');
        foreach ($datacaracteristicas as $caracteristica) {
            $object = array('idproducto' => $dataproducto->id,
                            'idcaracteristica' => $caracteristica->idcaracteristica,
                            'tipo' => $caracteristica->valor);
            $this->db->insert('pro_car', $object);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $data['msj'] = 'hay errores en la actualizacion de la Base de Datos.';
            $data['res'] = 'bad'; 
            return $data; 
        }

        $data['res'] = 'ok'; 
        return $data; 

    }

//---------------------------------------------------------Valida campos de Producto con estado DISPONIBLE
    function editarestado( $id = null, $estado = null){
        $this->db->where('id', $id);
        $query = $this->db->get('productos', 1, 0);
        $producto = $query->row();
 
        if (strlen($producto->nombre) < 5) {
            $data['msj'] = 'El nombre del producto debe tener al menos 5 caracteres';
            $data['res'] = 'bad'; $data['cmp'] = 'nombre';
            return $data; 
        }    
        if (strlen($producto->descripcion) < 10) {
            $data['msj'] = 'La descripcion del producto debe tener al menos 10 caracteres';
            $data['res'] = 'bad'; $data['cmp'] = 'descripcion';
            return $data; 
        } 
        if (strlen($producto->descripcioncorta) < 5) {
            $data['msj'] = 'La descripcion corta del producto debe tener al menos 5 caracteres';
            $data['res'] = 'bad'; $data['cmp'] = 'descripcioncorta';
            return $data; 
        } 
        if (strlen($producto->ingredientes) < 10) {
            $data['msj'] = 'Ingredientes del producto debe tener al menos 10 caracteres';
            $data['res'] = 'bad'; $data['cmp'] = 'ingredientes'; 
            return $data; 
        }
        if (filter_var($producto->peso, FILTER_VALIDATE_INT) == null) {
            $data['msj'] = 'El Peso del producto debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'peso'; 
            return $data; 
        }
        if (filter_var($producto->pesoneto, FILTER_VALIDATE_INT) == null) {
            $data['msj'] = 'El Peso Neto del producto debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'pesoneto'; 
            return $data; 
        }
        if (filter_var($producto->idmarca, FILTER_VALIDATE_INT) == null OR $producto->idmarca == 0) {
            $data['msj'] = 'La marca del producto debe ser una de las opciones';
            $data['res'] = 'bad'; $data['cmp'] = 'idmarca';
            return $data; 
        }
        if (filter_var($producto->largo, FILTER_VALIDATE_INT) == null) {
            $data['msj'] = 'El Largo del producto debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'largo';
            return $data; 
        }    
        if (filter_var($producto->ancho, FILTER_VALIDATE_INT) == null) {
            $data['msj'] = 'El Ancho del producto debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'ancho'; 
            return $data; 
        }
        if (filter_var($producto->alto, FILTER_VALIDATE_INT) == null) {
            $data['msj'] = 'El Alto del producto debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'alto'; 
            return $data; 
        }
        if (filter_var($producto->precio, FILTER_VALIDATE_INT, 1) == null) {
            $data['msj'] = 'Ingresa un Precio válido';
            $data['res'] = 'bad'; $data['cmp'] = 'precio'; 
            return $data; 
        }
        if (filter_var($producto->existencias, FILTER_VALIDATE_INT, 1) == null) {
            $data['msj'] = 'Existencias debe ser un número entero';
            $data['res'] = 'bad'; $data['cmp'] = 'existencias'; 
            return $data; 
        }

        $this->db->where('idproducto', $producto->id);
        if($this->db->count_all_results('pro_cat') == 0){
            $data['msj'] = 'El Producto debe pertenecer a alguna Categoria';
            $data['res'] = 'bad'; $data['cmp'] = ''; 
            return $data; 
        }

        if($estado != null) {
            $objeto = array();
            $objeto['estado'] = $estado;
            $this->db->where('id', $producto->id);
            $this->db->update('productos', $objeto);
            $data['res'] = 'ok'; 
            return $data; 
        }
    }

//---------------------------------------------------------modificar Stock
    function modificarStock( $id = null, $unidades = null) {
        $this->db->where('id', $id);
        $query = $this->db->get('productos', 1, 0);
        $producto = $query->row();
 
        $this->db->where('id', $id);


        if ($producto->existencias < $unidades) {
            $data['res'] = 'bad'; 
            $data['msj'] = 'no hay producto disponible';
            return FALSE;
        } elseif ($producto->existencias == $unidades) {
                $objeto = array('existencias'=>0,
                                'estado'=>PRODUCTO_AGOTADO);
            } elseif ($producto->existencias > $unidades) {
                    $objeto = array('existencias'=>$producto->existencias - $unidades,
                                    'estado'=>PRODUCTO_DISPONIBLE);
                }

        $this->db->update('productos', $objeto);
        $data['res'] = 'ok'; 
        return $data; 
    }

//---------------------------------------------------------GuardarImagen
    function guardarImagen($idproducto = null, $extencion = null){
        if($idproducto == null){
            $data['res'] = 'bad';
            $data['msj'] = 'Error, producto sin id';
            return $data; 
        }
        if($extencion == null){
            $data['res'] = 'bad';
            $data['msj'] = 'Error, no hay extencion de la imagen';
            return $data; 
        }

        $object = array('idproducto' => $idproducto, 'imagen' => $extencion);
        $this->db->insert('imagenes', $object);

        $id = $this->db->insert_id();
        $objeto['imagen'] = base_url() . "images/" . $id . "." . $extencion;
        $objeto['titulo'] = $id . "." . $extencion;
        
        $this->db->where('id', $id);
        $this->db->update('imagenes', $objeto);

        $data['res'] = 'ok';
        $data['id'] = $id;
        return $data; 
    }

//---------------------------------------------------------borrarImagen
    function borrarImagen($tituloimagen = null){
        if($tituloimagen == null){
            $data['res'] = 'bad';
            $data['msj'] = 'Error, no hay extencion de la imagen';
            return $data; 
        }
        $idimagen = substr($tituloimagen, 0, strpos($tituloimagen, "."));
        $this->db->where('id', $idimagen);
        $data['imagen'] = @$this->db->get('imagenes', 1, 0)->row()->imagen;

        $this->db->where('id', $idimagen);
        $this->db->delete('imagenes');

        $imagen = FCPATH.'images/' . $tituloimagen;

        unlink($imagen);

        $data['res'] = 'ok';
        return $data; 
    }

//---------------------------------------------------------reemplaza caracteres raros
    function buscar($query=null){
        $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 
                                'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 
                                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'B', 'à'=>'a', 'á'=>'a', 
                                'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 
                                'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 
                                'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y','"'=>'',"'"=>"","¿"=>"" );
        $query_filtrado = strtr( $queryInput, $unwanted_array );
        $query_filtrado = trim(preg_replace("/\b[^\s]{1,2}\b/", "", $query_filtrado));

        $this -> db -> where('MATCH (nombre,descripcion) AGAINST ("' . utf8_encode($query_filtrado) . '")', NULL, FALSE);
        $query = $this -> db -> get('productos');
        return $query->result();
    }
} 

// End of file Productos_model.php 
// Location: ./application/models/Productos_model.php