<link rel="stylesheet" href="https://s3.amazonaws.com/sanosfood/js/jasny/jasny-bootstrap.min.css">
<script type="text/javascript" src="https://s3.amazonaws.com/sanosfood/js/jasny/jasny-bootstrap.min.js"></script>
<script type="text/javascript">
var idproducto = <?php print $producto->id;?>;
</script>


<div class="panel panel-success">
	<div class="panel-heading text-center"><h2>Información del Producto</h2></div>
	<form class="form-horizontal form-contenedor">
		<div class="row registro">
			<div class="col-md-6">
				<span><strong>Nombre del Producto</strong></span>
				<strong><input type="text" class="form-control editable" id="nombre" readonly value="<?php print $producto->nombre;?>"/></strong>
			</div>
			<div class="col-md-6">
				<span><strong>Ingredientes</strong></span>
				<textarea type="text" class="form-control editable" id="ingredientes" readonly><?php print $producto->ingredientes;?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<span><strong>Descripción</strong></span>
				<textarea type="text" class="form-control editable" id="descripcion" readonly><?php print $producto->descripcion;?></textarea>
			</div>
			<div class="col-md-6">
				<span><strong>Descripción Corta</strong></span>
				<textarea type="text" class="form-control editable" id="descripcioncorta" readonly><?php print $producto->descripcioncorta;?></textarea>
			</div>
		</div>
	</form>
</div>

<div class="panel panel-default">
	<form class="form-horizontal form-contenedor">
		<div class="row registro">
			<div class="col-md-1 col-md-offset-1 text-center">
				<span><strong>Peso</strong></span>
				<input type="text" class="form-control editable text-center" id="peso" readonly value="<?php print $producto->peso;?>"/>
			</div>
			<div class="col-md-1 text-center">
				<span><strong>PesoNeto</strong></span>
				<input type="text" class="form-control editable text-center" id="pesoneto" name="pesoneto" readonly value="<?php print $producto->pesoneto;?>"/>
			</div>
			<div class="col-md-1 text-center">
				<span><strong>Largo</strong></span>
				<input type="text" class="form-control editable text-center" id="largo" readonly value="<?php print $producto->largo;?>"/>
			</div>
			<div class="col-md-1 text-center">
				<span><strong>Ancho</strong></span>
				<input type="text" class="form-control editable text-center" id="ancho" readonly value="<?php print $producto->ancho;?>"/>
			</div>
			<div class="col-md-1 text-center">
				<span><strong>Alto</strong></span>
				<input type="text" class="form-control editable text-center" id="alto" readonly value="<?php print $producto->alto;?>"/>
			</div>
			<div class="col-md-2 text-center">
				<span><strong>Marca</strong></span>
				<select class="form-control editable" id="marca" disabled="disabled">
					<?php foreach ($marcas as $marca) {
						if ($marca->id == $producto->idmarca) {
							print '<option value="'.$marca->id.'" selected>'.$marca->nombre.'</option>'; }
						else {
							print '<option value="'.$marca->id.'">'.$marca->nombre.'</option>'; }
					}?>
				</select>
			</div>
			<div class="col-md-1 text-center">
				<span><strong>Existencias</strong></span>
				<input type="text" class="form-control editable input-lg text-center" id="existencias" readonly value="<?php print $producto->existencias;?>"/>
			</div>
			<div class="col-md-2 text-center">
				<span><strong>Precio</strong></span>
				<input type="text" class="form-control editable input-lg text-center" id="precio" readonly value="<?php print $producto->precio;?>"/>
			</div>
		</div>
	</form>
</div>


<!------------------------------------- edicion del campo CARACTERISTICAS --> 
<div class="row registro">
	<div class="col-md-4">
        <div class="panel panel-success">
			<div class="panel-heading text-center"><h3>Características</h3></div>
			<table class="table table-condensed table-striped">
				<tbody>
<?php
foreach ($caracteristicas as $caracteristica) {
	print '<tr>';
	print '<th scope="row">'.$caracteristica->nombre.'</th>';
	$entra = 0;
	foreach ($producto->caracteristicas as $procar) {
		if ($caracteristica->id == $procar->idcaracteristica) {
			$entra = 1;
			switch ($procar->tipo) {
				case "remove":
					print '<td>
			   	        	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "chulo"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							</label>
			        	</td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="1" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "remove" checked> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</label> 
						</td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "asterisk"> <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
							</label> 
						</td>
						</tr>';
					break;
				case "asterisk":
					print '<td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "chulo"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							</label> 
			            </td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "remove"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</label> 
						</td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="1" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "asterisk" checked> <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
							</label> 
						</td>
						</tr>';
					break;
			}
		}
	}
	if ($entra == 0) {
					print '<td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="1" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "chulo" checked> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							</label> 
			            </td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "remove"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</label> 
						</td>
			            <td>
			            	<label  class= "radio-inline" > 
								<input  type= "radio" data-valor="0" data-id="'.$caracteristica->id.'" name= "car'.$caracteristica->id.'" disabled="disabled" value= "asterisk"> <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
							</label> 
						</td>
						</tr>';
	}
}			            
?>
				</tbody>
			</table> <!-- tabla--> 
		</div> <!-- Panel-->
	</div>


<!----------------------------------- edicion del campo CATEGORIAS --> 
	<div class="col-md-4">
        <div class="panel panel-success">
			<div class="panel-heading text-center"><h3>Categorias</h3></div>
			<table class="table table-condensed table-striped">
				<tbody>
<?php 
foreach ($categorias as $categoria) {
	print '<tr>';
	print '<th scope="row">'.$categoria->nombre.'</th>';
	$entra = 0;
	foreach ($producto->categorias as $procat) {
		if ($categoria->id == $procat->idcategoria) {
			$entra = 1;
			print '<td>
			     		<label  class= "checkbox" > 
							<input  type= "checkbox" data-valor="1" data-id="'.$categoria->id.'" name="cat'.$categoria->id.'" disabled="disabled" checked value="">
						</label> 
					</td>
					</tr>';
		}
	}
	if ($entra == 0) {
		print '<td>
     		<label  class= "checkbox" > 
				<input  type= "checkbox" data-valor="0" data-id="'.$categoria->id.'" name="cat'.$categoria->id.'" disabled="disabled" value="">
			</label> 
		</td>
		</tr>';
	}
}
?>
				</tbody>
			</table> <!-- tabla--> 
		</div> <!-- Panel-->
	</div>

<!----------------------------------- Botones--> 
	<div class="col-md-4">
 
       <div class="panel panel-default panel-danger">
			<div class="panel-heading text-center"><h4>Modificación de la Información</h4></div>
			<table class="table table-condensed table-striped">
				<tbody>
				<tr role="row">
					<td>
						<button type="button" class="btn btn-lg btn-primary" id="btn-editar">Editar</button>
					</td>  
					<td>
			  			<button type="button" class="btn btn-lg btn-success" id="btn-guardar">Guardar</button>
					</td>  
					<td>
				  		<button type="button" class="btn btn-lg btn-warning" id="btn-cancelar">Cancelar</button>
					</td>  
				</tr>
				</tbody>
			</table> <!-- tabla--> 
		</div> <!-- Panel-->

		<div class="panel panel-default panel-info">
			<div class="panel-heading text-center"><h4>Cambio del Estado del Producto</h4></div>
			<table class="table table-condensed table-striped">
				<tbody>
				<tr role="row">
					<td width="50%">
			    		<strong><select class="form-control input-lg" id="estado" disabled="disabled">
							<?php foreach ($estados as $estado) {
								if ($estado->nombre == $producto->estado) {
									print '<option value="'.$estado->nombre.'" selected>'.$estado->nombre.'</option>'; }
								else {
									print '<option value="'.$estado->nombre.'">'.$estado->nombre.'</option>'; }
							}?>
						</select></strong>
					</td>  
					<td>
						<button type="button" class="btn btn-xs btn-primary" id="btn-editar-est"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar</button>
					</td>  
					<td>
			  			<button type="button" class="btn btn-xs btn-success" id="btn-guardar-est">Guardar</button>
					</td>  
					<td>
				  		<button type="button" class="btn btn-xs btn-warning" id="btn-cancelar-est">Cancelar</button>
					</td>  
				</tr>
				</tbody>
			</table> <!-- tabla--> 
		</div> <!-- Panel-->
	</div>

</div>


<!----------------------------------- Explicaciones--> 
<div class="row registro">
	<div class="col-md-12">
        <div class="panel panel-default">
			<div><h6><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Indica que el producto no contiene el alérgeno o trazas del mismo.</h6></div>
			<div><h6><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Indica que el alérgeno se añade directamente o indirectamente a través de otros ingredientes. Según lo declarado en la etiqueta del producto.</h6></div>
			<div><h6><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Indica que puede contener trazas del alérgeno por contaminación cruzada, según lo declarado en la etiqueta del producto. Esta información
					es correcta en el momento de la impresión, mayo de 2013. Para más información ponerse en contacto con Orgran.</h6></div>			

	   	</div>	
  	</div>
</div>


<div class="row registro">
	<div class="col-md-12">
        <div class="panel panel-success">
        	<div class="panel-heading text-center"><h3>Imágenes</h3></div>
<?php
			$i = 0;
			foreach ($producto->imagenes as $imagen) {
				$i = $i + 1;
				print
				' <div class="col-md-2">
					<a href="javascript:void(0)"><img class="img-responsive img03 imge" id="img'.$i.'" data-id="'.$imagen->titulo.'" src="'.$imagen->imagen.'"/></a> 
					<h6 class="text-center">'.$imagen->titulo.'</h6>
				  </div>';
			};
?>
<!--							<img class="img-responsive img-thumbnail img03 imgsmall" data-id="'.$i.'" id="imgsmall'.$i.'" src="'.$imagen->imagen.'"/> -->
		</div> <!-- Panel-->
	</div>
</div>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default panel-danger">
			<div class="panel-heading text-center alert"><h4>Subida y precarga de imagenes</h4></div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<form action="<?php print base_url();?>producto/subirImagen" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-md-5">	
									<input type="file" name="userfile" class="filestyle" id="btn-escoger" data-buttonName="btn-primary"
											data-buttonText="Escojer Imagen" data-buttonBefore="true"/>
									<input type="hidden" name="idproducto" value="<?php print $producto->id;?>"/>	
								</div>
								<div class="col-md-1">		
								    <button type="submit" id="btn-subir" value="Subir" class="btn btn-success">Subir</button>
								</div>
								<div class="col-md-6">
<?php
									if (@$this->session->flashdata('error') != '') {
									    echo "<strong style='color:red;'>".$this->session->flashdata('error')."</strong>";
									}
									if (@$this->session->flashdata('ok') != ''){
									    echo "<strong style='color:green;'>".$this->session->flashdata('ok')."</strong>";
									}
?>
						    	</div>
							</div>
						</form>
					</div>
				</div>
			</div>
	    </div>	
	</div>
	<div class="col-md-3">
		<div class="panel panel-default panel-danger">
			<div class="panel-heading text-center alert"><h4>Borrar Imágenes</h4></div>
			<div class="row">
				<div class="text-center" id="textoborrar">Para borrar imagenes de click sobre la imagen que desea borrar</div>
				<div class="row">

					<form action="<?php print base_url();?>producto/borrarImagen" method="POST">
						<div class="form-group">
							<div class="col-md-7 text-right">	
								<input type="hidden" id="numproducto" name="numproducto" value="<?php print $producto->id;?>"/>	
								<input type="hidden" id="titimagen" name="titimagen" value=""/>	
								<button type="submit" id="btn-borraimg" class="btn btn-success">Desea Borrar?</button>
							</div>
						</div>
					</form>
					<div class="col-md-5">		
					    <button type="buttom text-right" id="btn-cancelaborrar" class="btn btn-warning">Cancelar</button>
					</div>

				</div>		
		    </div>	
		</div>

	</div>
</div>



<!--------------------------------------------------------------------------------------------------------------------- -->
<script type="text/javascript" src="<?php print base_url();?>js/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript">

$(document).ready(function() { 
	$('#btn-guardar').hide();
	$('#btn-cancelar').hide();
	$('#btn-guardar-est').hide();
	$('#btn-cancelar-est').hide();
	$('#btn-subir').hide();
	$('#btn-borraimg').hide();
	$('#btn-cancelaborrar').hide();


//----------------------------------------------------------------------------------SUBIR o BORRAR IMAGEN
	$('.container').on('click','#btn-escoger',function(event){
		$('#btn-subir').show();
	});
	$('.container').on('click','.imge',function(event){
		tituloimagen = $(event.target).attr("data-id");
		$("#titimagen").val(tituloimagen);
		$("#textoborrar").html("Confirme borrar imagen: " + tituloimagen);
		$('#btn-borraimg').show();
		$('#btn-cancelaborrar').show();
	});
	$('.container').on('click','#btn-cancelaborrar',function(event){
		$("#textoborrar").html("Para borrar imagenes de click sobre la imagen que desea borrar");
		$('#btn-borraimg').hide();
		$('#btn-cancelaborrar').hide();
	});

//----------------------------------------------------------------------------------EDITAR-EST
	$('.container').on('click','#btn-editar-est',function(event){
		sestado = $('#estado').val();
		$('#estado').attr('disabled', false);
		$('#btn-editar-est').hide();
		$('#btn-guardar-est').show();
		$('#btn-cancelar-est').show();
		$('#btn-editar').attr('disabled', true);
	});

//----------------------------------------------------------------------------------CANCELAR-EST
	$('.container').on('click','#btn-cancelar-est',function(event){
		$('#btn-editar-est').show();
		$('#btn-guardar-est').hide();
		$('#btn-cancelar-est').hide();
		$('#btn-editar').attr('disabled', false);

		$('#estado').val(sestado);
		$('#estado').attr('disabled', true);
	});

//----------------------------------------------------------------------------------GUARDAR-EST
	$('.container').on('click','#btn-guardar-est',function(event){
		eestado = $('#estado').val();
		$('#btn-editar-est').show();
		$('#btn-guardar-est').hide();
		$('#btn-cancelar-est').hide();
		$('#btn-editar').attr('disabled', false);

		$('#estado').attr('disabled', true);
		if (eestado == sestado) {return;}
		rta = guardarest(eestado, function(rta){
			if(rta) {
				$('#btn-editar-est').show();
				$('#btn-guardar-est').hide();
				$('#btn-cancelar-est').hide();
				$('#btn-editar').attr('disabled', false);
			} else {
				$('#estado').val(sestado);
				
			}
		});
	});

//----------------------------------------------------------------------------------EDITAR
	$('.container').on('click','#btn-editar',function(event){
		$('#btn-editar').hide();
		$('#btn-guardar').show();
		$('#btn-cancelar').show();
		$('#btn-editar-est').attr('disabled', true);

		snombre = 		$('#nombre').val();
		sdescripcion = 	$('#descripcion').val();
		sdescripcioncorta = 	$('#descripcioncorta').val();
		singredientes = $('#ingredientes').val();
		speso = 		$('#peso').val();
		spesoneto = 	$('#pesoneto').val();
		smarca = 		$('#marca').val();
		slargo = 		$('#largo').val();
		sancho = 		$('#ancho').val();
		salto = 		$('#alto').val();
		sprecio = 		$('#precio').val();
		sexistencias = 	$('#existencias').val();
		sestado = 		$('#estado').val();

		$('.editable').each(function() {$(this).attr('readonly', false);});
		$('.editable').each(function() {$(this).attr('disabled', false);});
		$('input[name*="car"]').each(function(){
			$(this).attr('disabled', false);
		});
		$('input[name*="cat"]').each(function(){
			$(this).attr('disabled', false);
		});

	});

//----------------------------------------------------------------------------------CANCELAR
	$('.container').on('click','#btn-cancelar',function(event){
		$('input[name*="car"]').each(function(){
			if ($(this).attr('data-valor') == "1") {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		});

		$('input[name*="cat"]').each(function(){
			if ($(this).attr('data-valor') == "1") {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		});

		$('#btn-editar').show();
		$('#btn-guardar').hide();
		$('#btn-cancelar').hide();
		$('#btn-editar-est').attr('disabled', false);

		$('#nombre').val(snombre);
		$('#descripcion').val(sdescripcion);
		$('#descripcioncorta').val(sdescripcioncorta);
		$('#ingredientes').val(singredientes);
		$('#peso').val(speso);
		$('#pesoneto').val(spesoneto);
		$('#marca').val(smarca);
		$('#largo').val(slargo);
		$('#ancho').val(sancho);
		$('#alto').val(salto);
		$('#precio').val(sprecio);
		$('#existencias').val(sexistencias);
		$('#estado').val(sestado);

		$('.editable').each(function() {$(this).attr('disabled', true);});
		$('.editable').each(function() {$(this).attr('readonly', true);});
		$('input[name*="car"]').each(function(){
			$(this).attr('disabled', true);
		});
		$('input[name*="cat"]').each(function(){
			$(this).attr('disabled', true);
		});

	});

//----------------------------------------------------------------------------------GUARDAR
	$('.container').on('click','#btn-guardar',function(event){
		enombre = 		$('#nombre').val();
		edescripcion = $('#descripcion').val();
		edescripcioncorta = $('#descripcioncorta').val();
		eingredientes = $('#ingredientes').val();
		epeso = 			$('#peso').val();
		epesoneto = 	$('#pesoneto').val();
		emarca = 		$('#marca').val();
		elargo = 		$('#largo').val();
		eancho = 		$('#ancho').val();
		ealto = 			$('#alto').val();
		eprecio = 		$('#precio').val();
		eexistencias = $('#existencias').val();
		eestado = 		$('#estado').val();
		rta = guardar(function(rta){
			if(rta) {
				$('#btn-editar').show();
				$('#btn-guardar').hide();
				$('#btn-cancelar').hide();
				$('#btn-editar-est').attr('disabled', false);

				$('.editable').each(function() {$(this).attr('disabled', true);});
				$('.editable').each(function() {$(this).attr('readonly', true);});
				
				$('input[name*="car"]').each(function(){
					if ($(this).prop('checked') == true) {
						$(this).attr('data-valor', "1");
					} else {
						$(this).attr('data-valor', "0");
					}
				});
				$('input[name*="car"]').each(function(){
					$(this).attr('disabled', true);
				});
				
				$('input[name*="cat"]').each(function(){
					if ($(this).prop('checked') == true) {
						$(this).attr('data-valor', "1");
					} else {
						$(this).attr('data-valor', "0");
					}
				});
				$('input[name*="cat"]').each(function(){
					$(this).attr('disabled', true);
				});
			};
		});
	});
});

//----------------------------------------------------------------------------------funcion guardar
function guardar (callback) {
	var dataproducto = {};
	dataproducto.id = <?php print $this->uri->segment(3);?>;
	if(snombre !== enombre) {dataproducto.nombre = enombre;}
	if(sdescripcion !== edescripcion) {dataproducto.descripcion = edescripcion;}
	if(sdescripcioncorta !== edescripcioncorta) {dataproducto.descripcioncorta = edescripcioncorta;}
	if(singredientes !== eingredientes)	{dataproducto.ingredientes = eingredientes;}
	if(speso !== epeso) {dataproducto.peso = epeso;}
	if(spesoneto !== epesoneto) {dataproducto.pesoneto = epesoneto;}
	if(smarca !== emarca) {dataproducto.idmarca = emarca;}
	if(slargo !== elargo) {dataproducto.largo = elargo;}
	if(sancho !== eancho) {dataproducto.ancho = eancho;}
	if(salto !== ealto) {dataproducto.alto = ealto;}
	if(sprecio !== eprecio) {dataproducto.precio = eprecio;}
	if(sexistencias !== eexistencias) {dataproducto.existencias = eexistencias;}
	if(sestado !== eestado) {dataproducto.estado = eestado;}

	var datacaracteristicas = [];
	$('input[name*="car"]:checked').each(function(){
		if($(this).val()!=='chulo'){
			var caracteristica = { "idcaracteristica" : $(this).attr('data-id') , "valor" : $(this).val() };
			datacaracteristicas.push(caracteristica);
		}
	});
	dataproducto.caracteristicas = datacaracteristicas;

	var datacategorias = [];
	$('input[name*="cat"]:checked').each(function(){
		var categoria = { "idcategoria" : $(this).attr('data-id') };
		datacategorias.push(categoria);
	});
	dataproducto.categorias = datacategorias;

  $.ajax({                                               // envio de los datos
	    url: "<?php print base_url();?>producto/editar",
	    context: document.body,
	    dataType: "json",
	    type: "POST",
	    data: {dataproducto : JSON.stringify(dataproducto) } })
   .done(function(data) {                               // respuesta del servidor
		if (data.res == "ok") {
			if (data.est !== "") {
				$('#estado').val(data.est);
			}
  			callback(true);
  		}else {
			alert(data.msj);
			$('#'+data.cmp+'').focus();
   			callback(false);
		}
    })
   .error(function(){alert('No hay conexion');callback(false);})
}

//----------------------------------------------------------------------------------funcion guardar-est
function guardarest (estado, callback) {
  $.ajax({                                               // envio de los datos
	    url: "<?php print base_url();?>producto/editarestado",
	    context: document.body,
	    dataType: "json",
	    type: "POST",
	    data: {id : <?php print $this->uri->segment(3);?>, estado : estado} })
   .done(function(data) {                               // respuesta del servidor
		if(data.res == "ok") {callback(true);}
		else {alert(data.msj);callback(false)}
    })
   .error(function(){alert('No hay conexion');callback(false);})
}

</script>