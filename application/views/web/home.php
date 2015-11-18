
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
                     <button type="button" class="btn btn-md btn-success" id="btn-guardar">Ver Detales</button>
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
   <div class="col-lg-12 text-center">
      <h4><strong>PRODUCTOS DESTACADOS</strong></h4>
   </div>

<?php
$i = 0;
foreach ($productos as $producto) {
   $i = $i + 1;
   if ($i == 1 || $i == 5) {
      if ($i == 5) {
         print '</div>';
      }
      print '<div class="row">';
   } 
  print '<div class="col-lg-3" align="center">
            <div class="row">
               <div class="col-lg-9 col-lg-offset-2">
                  <div class="row">
                     <div class="col-lg-12">
                        <img class="img-responsive img-rounded img01" src="'.$producto->imagen.'"/>
                     </div>
                  </div>     
                  <div class="row">
                     <div class="col-lg-10">
                        <div class="row">
                           <div class="col-lg-8 textos05a" align="left"><h6><strong>'.$producto->nombre.'</strong></h6></div>
                           <div class="col-lg-4 textos06" align="right"><h4><strong>$'.number_format($producto->precio , 0, ",", ".").'</strong></h4></div>
                        </div>
                     </div>   
                  </div>
                  <div class="row">
                     <div class="col-lg-12 textos05" align="left">
                        <h6>'.$producto->descripcioncorta.'</h6>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-verdetalle btn-xs btn-success" data-id="'.$producto->id.'">Ver Detalles</button>
                     </div>
                  </div>
               </div>
            </div>
         </div> ';
}
?>
</div>  


</div> <!-- /container -->
</div>
<!---------------------------------------------------------------BANER 4 -->
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

   $('*').on('click','.btn-verdetalle',function(event){
      id = $(event.target).attr("data-id");
      window.location="<?php print base_url();?>web/producto/"+id;
   });
})
</script>
