<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $taller->nombre?></title>

<style type="text/css">
#contenedor-taller{
	color:#000;
	font-family:arial;
	
}
#contenedor-taller h1{
	font-size: 28px;
}
#descripcion-taller{
	margin:10px 5px 20px 5px;
}
#footer-taller{
	margin:5px;
	padding:10px;
	border:1px solid #e6db55;
	background:#fffbcc;
}
</style>
</head>
<body>

<div id="contenedor-taller">
	<h1><?php echo $taller->nombre?></h1>
	<div id="descripcion-taller">
		<?php echo $taller->descripcion?>
	</div>
	<div id="footer-taller">
	<strong>Nivel: </strong> <?php echo $taller->nivel?> <br />
	<strong>Requisitos: </strong> <?php echo $taller->requisitos?> <br /> 
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