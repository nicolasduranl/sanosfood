
<!---------------------------------------------------------------IMAGEN SUPERIOR -->
<div class="row baner01">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-lg-offset-1">
            <div class="textos01">
               <h3><strong>LOREM IPSUM</strong></h3>
               <h1><strong>DOLOR SIT AMET</strong></h1>
               <h4>LOREM IPSUM</h4>
               <h5>CONSECTETUR ADIPISICING ELIT, SED DO EIUSMOD TEMPOR INCIDIDUNT UT LABORE.</h5>
               <div class="row boton01">
                  <div class="col-lg-5">
                     <button type="button" class="btn btn-md btn-success" id="btn-guardar">Ver Detalles</button>
                  </div>
               </div>           
            </div>
         </div>
      </div>
   </div> <!-- /container -->
</div> 

<div class="container">

<!---------------------------------------------------------------PRODUCTOS -->
<div class="row">
   <div class="col-lg-12 text-center prod-linea">
      <h3><strong>PRODUCTOS DESTACADOS</strong></h3>
   </div>

<?php
$i = 0;
foreach ($productos as $producto) {         
   if ($i == 0) {
     print '
         <div class="row">';
   }
   elseif (($i % 4) == 0 && $i != 0) {
      print '
         </div>
         <div class="row">';
   } 
   print '  <div class="col-lg-3 prod-linea">
               <div class="row">
                  <div class="col-lg-11 col-lg-offset-1">
                     <div class="row">
                        <div class="col-lg-12" align="center">
                           <div class="panel panel-default panel-prod-img-mediana">
                              <a href="'.base_url().'web/producto/'.$producto->id.'"><img class="img-responsive img-mediana" src="'.$producto->imagen.'"/></a>
                           </div>
                        </div>
                     </div>     
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="panel panel-default panel-prod-nom">
                              <a href="'.base_url().'web/producto/'.$producto->id.'" class="linkproducto"><div class="texto02" align="center"><strong>'.$producto->nombre.'</strong></div></a>
                           </div>   
                        </div>  
                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="panel panel-default panel-prod-desc">
                              <a href="'.base_url().'web/producto/'.$producto->id.'" class="linkproducto"><h6 align="justify">'.$producto->descripcioncorta.'</h6></a>
                           </div>
                        </div>   
                     </div>
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="input-append">
                              <div class="col-lg-3" align="left" id="existen">
                                 <h5><small>Disponibles:</small></h5>
                              </div>
                              <div class="col-lg-2" align="left">
                                 <h5><strong>'.$producto->existencias.'</strong></h5>
                              </div>
                              <div class="col-lg-1" align="right">
                                 <h5><small>Precio:</small></h5>
                              </div>
                              <div class="col-lg-3" align="left">
                                 <div class="col-lg-4 texto02" ><h4><strong>$'.number_format($producto->precio , 0, ",", ".").'</strong></h4></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-12" align="center">
                           <div class="input-append">
                              <button type="button" class="btn btn-xs btn-info" id="btn-verdetalle" data-id="'.$producto->id.'">Mas Detalles</button>
                           </div>
                        </div>
                     </div>
                     <div>
                        <input type="hidden" class="idprod"     data-id="'.$producto->id.'"/>
                        <input type="hidden" class="imagenprod" data-id="'.$producto->imagen.'"/>
                        <input type="hidden" class="nombreprod" data-id="'.$producto->nombre.'"/>
                        <input type="hidden" class="precioprod" data-id="'.$producto->precio.'"/>
                        <input type="hidden" class="descripcioncortaprod" data-id="'.$producto->descripcioncorta.'"/>
                     </div>
                  </div>
               </div>
            </div> ';
   $i = $i + 1;
   }
   print '</div>';
?>

</div>  
<div class="row margen-top1"></div>

</div> <!-- /container -->
</div>
<!-------------------------------------------------- BANER 4 -->
<div class="row baner04">
   <div class="container">  
      <div class="col-lg-8 col-lg-offset-2 text-center">
         <div class="textos01">
            <h1><strong>LOREM IPSUM</strong></h1>
            <h2>dolor sit awet, consectetur adipising elit,</h2>
            <h2>sed do eiuswod tempor incididuut ut.</h2>
         </div>
      </div> 
   </div> <!-- /container -->
</div> 


<!------------------------------------------------------------------------------------------------------------------------------------> 
<script type="text/javascript">

$(document).ready(function(){

   $('.container').on('click','#btn-verdetalle',function(event){
      id = $(event.target).attr("data-id");
      window.location="<?php print base_url();?>web/producto/"+id;
   });

})

</script>

