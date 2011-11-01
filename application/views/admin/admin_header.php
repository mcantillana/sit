<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administración - Sistema de Inscripción de talleres [SIT]</title>
	<base href="<?php echo base_url(); ?>" />
	<meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="index,follow" />

    <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="Stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.1.custom.css"  />	
	<!--[if IE 7]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<!--[if IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen, projection" /><![endif]-->

	
	<link rel="stylesheet" type="text/css" href="css/rounded.css" />


	
	<!--[if IE]>
		<style type="text/css">
		  .clearfix {
		    zoom: 1;     /* triggers hasLayout */
		    display: block;     /* resets display for IE/Win */
		    }  /* Only IE can see inside the conditional comment
		    and read this CSS rule. Don't ever use a normal HTML
		    comment inside the CC or it will close prematurely. */
		</style>
	<![endif]-->
	<!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
	<script type="text/javascript" src="js/hoverIntent.js"></script>
	
	<script type="text/javascript" src="js/excanvas.pack.js"></script>
	<script type="text/javascript" src="js/jquery.flot.pack.js"></script>
	



  	
  	<script type="text/javascript" src="js/custom.js"></script>
  	
	<?php
		//imprime cabecera si es que esta definida
		if(isset($heading)){
			echo $heading;
		} 
	?>
	
	<style type="text/css">
		#header p{
			color:#FFF;
			background:none;
			margin:30px 10px 0 0;
			padding:0;
			text-align:right;
		}
		#header p a{
			color:#FFF;
			font-weight:bold;
			text-decoration:none;
		}
		#header p a:hover{
			text-decoration:underline;
		}
	</style>

	 <!--[if IE]><script language="javascript" type="text/javascript" src="js/excanvas.pack.js"></script><![endif]-->
</head>
<body>
<?php 
	$last_a	=	getdate($this->session->userdata('last_activity'));
	$hora	=	$last_a['hours'].":".$last_a['minutes'].":".$last_a['seconds'];
	$fecha	=	$last_a['mday']. "/". $last_a['mon']. "/". $last_a['year']; 
	$ultima_actividad = $hora. " ". $fecha;
	
	$id 	=	$this->session->userdata('id');
	$nombre	=	$this->session->userdata('nombre'); 
?>

<div class="container" id="container">
    <div  id="header">
  
		<p>Bienvenid@ <strong><a href="administradores/editar/<?php echo $id;?>" ><?php echo $nombre; ?></a></strong>, Tú último Acceso: <?php echo $ultima_actividad; ?> | <a href="<?php echo base_url(); ?>salir">¿Deseas salir?</a></p>
	

    </div><!-- end header -->
     <div id="content" >
	