<div class="container">

<!---------------------------------------------------------------PRODUCTOS -->
<!--<div class="row" style="background: #cccccc;">   -->
<div class="row">
   <div class="col-lg-2">
      <div class="row">
	      <div class="panel panel-default">
				<div class="panel-heading text-center"><h5><strong>CATEGORIAS</strong></h5></div>
				<table class="table table-condensed table-striped">
					<tbody>
					<?php 
					foreach ($categorias as $categoria) {
						print '
						<tr>
							<td><a href="javascript:void(0)"><input  type= "checkbox" class="categ" data-id="'.$categoria->id.'" id="cat'.$categoria->id.'"></a></td>
							<td><a href="javascript:void(0)" class="categ" data-id="'.$categoria->id.'" id="cat'.$categoria->id.'">'.$categoria->nombre.'</a></td>
						</tr>';
					}
					?>
					</tbody>
				</table> <!-- tabla--> 
			</div> <!-- Panel-->
		</div>
      <div class="row">
	      <div class="panel panel-default">
				<div class="panel-heading text-center"><h5><strong>MARCAS</strong></h5></div>
				<table class="table table-condensed table-striped">
					<tbody>
					<?php 
					foreach ($marcas as $marca) {
						print '
						<tr>
							<td><a href="javascript:void(0)"><input  type= "checkbox" class="marca" data-id="'.$marca->id.'" id="mar'.$marca->id.'"></a></td>
							<td><a href="javascript:void(0)" class="marca" data-id="'.$marca->id.'" id="mar'.$marca->id.'">'.$marca->nombre.'</a></td>
						</tr>';
					}
					?>
					</tbody>
				</table> <!-- tabla--> 
			</div> <!-- Panel-->
		</div>
	</div>
   <div class="col-lg-10">
	  	<div class="row baner08" id="listaproductos">  


<?php
$i = 0;
foreach ($productos as $producto) {         

   if ($i == 0) {
      print '
	  	<div class="row">';
   }elseif (($i % 3) == 0) {
   	print '
		</div>
	  	<div class="row">';
   } 
	print '
		<div class="col-lg-4" align="center">
      <div class="row">
         <div class="col-lg-9 col-lg-offset-2">
            <div class="row">
               <div class="col-lg-12">
                  <img class="img-responsive img01" src="'.$producto->imagen.'"/>
               </div>
            </div>     
            <div class="row">
               <div class="col-lg-10">
                  <div class="row">
                     <div class="col-lg-8 texto02" align="left"><h6><strong>'.$producto->nombre.'</strong></h6></div>
                     <div class="col-lg-4 texto02" align="right"><h4><strong>$'.number_format($producto->precio , 0, ",", ".").'</strong></h4></div>
                  </div>
               </div>   
            </div>
            <div class="row">
               <div class="col-lg-12 texto02" align="left">
                  <h6>'.$producto->descripcioncorta.'</h6>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12 text-right">
                  <button type="button" class="btn btn-xs btn-success" id="btn-verdetalle" data-id="'.$producto->id.'">Ver Detalles</button>
               </div>
            </div>
         </div>
      </div>
   </div> ';
$i = $i + 1;
}
?>
		</div>  
	</div>  
</div>
</div> <!-- /container -->

<!------------------------------------------------------------------------------------------------------------------------------------> 
<script type="text/javascript">

$(document).ready(function(){

   $('.container').on('click','#btn-verdetalle',function(event){
      id = $(event.target).attr("data-id");
      window.location="<?php print base_url();?>web/producto/"+id;
   });

   $('.container').on('click','.categ',function(event){
      idcategoria = $(event.target).attr("data-id");
		rta = buscarxcategoria(idcategoria, function(rta){
			if(!rta) { alert("ha habido un error en la busqueda"); }
	   })
	})

   $('.container').on('click','.marca',function(event){
      idmarca = $(event.target).attr("data-id");

   });

})

//----------------------------------------------------------------------------------funcion buscarxcategoria
function buscarxcategoria(idcategoria, callback) {
  $.ajax({                                              
		url: "<?php print base_url();?>producto/listarProductosxCategoria",
		context: document.body,
		dataType: "json",
		type: "POST",
		data: {idcategoria : idcategoria} })
   .done(function(data) {                               // respuesta del servidor
		if(data.res=="ok") {
			callback(true);
			if(data.productos.length == 0) {alert("No se encuentra ninguna coincidencia"); return false;}

			for (var i = 0; i < data.productos.length; i++) {
			   if (i == 0) { $("#listaproductos").html('<div class="row">'); }
		   	if ((i % 3) == 0) {
		   		$("#listaproductos").append("</div>");
		   		$("#listaproductos").append('	<div class="row">');
		   	}  
				$("#listaproductos").append('		<div class="col-lg-4" align="center">'); 
				$("#listaproductos").append('			<div class="row">');
				$("#listaproductos").append('				<div class="col-lg-9 col-lg-offset-2">');
				$("#listaproductos").append('					<div class="row">');
				$("#listaproductos").append('						<div class="col-lg-12">');
		//		$("#listaproductos").append('							<img class="img-responsive img01" src="'+data.productos[i].id+'"/>');
				$("#listaproductos").append('						</div>');
			   $("#listaproductos").append('     			</div>');    
				$("#listaproductos").append('	         <div class="row">');
				$("#listaproductos").append('	         	<div class="col-lg-10">');
				$("#listaproductos").append('	            	<div class="row">');
				$("#listaproductos").append('	               	<div class="col-lg-8 texto02" align="left"><h6><strong>'+data.productos[i].nombre+'</strong></h6></div>');
				$("#listaproductos").append('	                  <div class="col-lg-4 texto02" align="right"><h4><strong>$'+data.productos[i].precio+'</strong></h4></div>');
				$("#listaproductos").append('	               </div>');
				$("#listaproductos").append('	            </div>');   
				$("#listaproductos").append('	         </div>');
				$("#listaproductos").append('	        	<div class="row">');
				$("#listaproductos").append('	         	<div class="col-lg-12 texto02" align="left">');
				$("#listaproductos").append('	               <h6>'+data.productos[i].descripcioncorta+'</h6>');
				$("#listaproductos").append('	            </div>');
				$("#listaproductos").append('	         </div>');
				$("#listaproductos").append('	         <div class="row">');
				$("#listaproductos").append('	         	<div class="col-lg-12 text-right">');
				$("#listaproductos").append('	               <button type="button" class="btn btn-xs btn-success" id="btn-verdetalle" data-id="'+data.productos[i].id+'">Ver Detalles</button>');
				$("#listaproductos").append('	            </div>');
				$("#listaproductos").append('	         </div>');
				$("#listaproductos").append('	      </div>');
				$("#listaproductos").append('	   </div>');
				$("#listaproductos").append('	</div>');
			}




		} else {alert(data.msj);callback(false)}
	})
   .error(function(){alert('No hay conexion');callback(false);})
}






//----------------------------------------------------------------------------------funcion pintarproductos
function pintarproductos() {
	for (var i = 0; i < data.productos.length; i++) {
	   if (i == 0) {{ $("#listaproductos").html('<div class="row">'); }
	   }else { 
	   	if ((i % 3) == 0) {$("#listaproductos").append("</div>");}
		}
		$("#listaproductos").append('	<div class="row">'); 
		$("#listaproductos").append('		<div class="col-lg-4" align="center">'); 
		$("#listaproductos").append('			<div class="row">');
		$("#listaproductos").append('				<div class="col-lg-9 col-lg-offset-2">');
		$("#listaproductos").append('					<div class="row">');
		$("#listaproductos").append('						<div class="col-lg-12">');
		$("#listaproductos").append('							<img class="img-responsive img01" src="'+data.productos[i].imagen+'"/>');
		$("#listaproductos").append('						</div>');
	   $("#listaproductos").append('     			</div>');    
		$("#listaproductos").append('	         <div class="row">');
		$("#listaproductos").append('	         	<div class="col-lg-10">');
		$("#listaproductos").append('	            	<div class="row">');
		$("#listaproductos").append('	               	<div class="col-lg-8 texto02" align="left"><h6><strong>'+data.productos[i].nombre+'</strong></h6></div>');
		$("#listaproductos").append('	                  <div class="col-lg-4 texto02" align="right"><h4><strong>$'+data.productos[i].precio+'</strong></h4></div>');
		$("#listaproductos").append('	               </div>');
		$("#listaproductos").append('	            </div>');   
		$("#listaproductos").append('	         </div>');
		$("#listaproductos").append('	        	<div class="row">');
		$("#listaproductos").append('	         	<div class="col-lg-12 texto02" align="left">');
		$("#listaproductos").append('	               <h6>'+data.productos[i].descripcioncorta+'</h6>');
		$("#listaproductos").append('	            </div>');
		$("#listaproductos").append('	         </div>');
		$("#listaproductos").append('	         <div class="row">');
		$("#listaproductos").append('	         	<div class="col-lg-12 text-right">');
		$("#listaproductos").append('	               <button type="button" class="btn btn-xs btn-success" id="btn-verdetalle" data-id="'+data.productos[i].id+'">Ver Detalles</button>');
		$("#listaproductos").append('	            </div>');
		$("#listaproductos").append('	         </div>');
		$("#listaproductos").append('	      </div>');
		$("#listaproductos").append('	   </div>');
		$("#listaproductos").append('	</div>');
		$i = $i + 1;
	}
}


</script>
