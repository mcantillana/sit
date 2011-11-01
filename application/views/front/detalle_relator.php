<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $taller->nombre?></title>

<style type="text/css">
#contenedor-relator{
	color:#000;
	font-family:arial;
	
}
#contenedor-relator h1{
	font-size: 28px;
}
#descripcion-relator{
	margin:0 5px 20px 15px;
	float:left;
}
#footer-relator{
	margin:5px;
	padding:10px;
	border:1px solid #e6db55;
	background:#fffbcc;
}
#foto-relator img{
	padding:3px;
	border:1px solid #DDD;
	
	background:#FFF;

	
}
#foto-relator{
	float:left;
}

.cls{
	clear:both;
}
</style>
</head>
<body>

<div id="contenedor-relator">
	<h1><?php echo $relator->nombre_completo?></h1>
	<div id="foto-relator">
	<img src="<?php echo base_url()?>fotos_perfil/<?php echo (empty($relator->fotografia))?"no_foto.jpg":"thumbs/".$relator->fotografia ?>" title="nombre" alt="nombre" />
	</div>
	<div id="descripcion-relator">
		<?php echo $relator->biografia?>		
	</div>
	
	<div class="cls"></div>
	<div id="footer-relator">
	<strong>Sitio Web: </strong> <?php echo (empty($relator->sitio_web))?"---":$relator->sitio_web ?> <br />		 
		<strong>Categorías: </strong>
		<?php 		
			$cat = "";
			foreach ($categorias as $categoria){
				$cat .= $categoria->nombre.", "; 
			}	
			echo $cat;			
		?>
		
		<br />
		
	</div>
</div>
</body>
</html>