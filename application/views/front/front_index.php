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
    <link rel="stylesheet" type="text/css" media="all" href="css/front_style.css" />
	<!--  <link rel="Stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.1.custom.css"  />  -->	
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
	<!-- 
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
	 -->
	<!-- 
	<script type="text/javascript" src="js/hoverIntent.js"></script>
	
	<script type="text/javascript" src="js/excanvas.pack.js"></script>
	<script type="text/javascript" src="js/jquery.flot.pack.js"></script>
	

  	
  	<script type="text/javascript" src="js/custom.js"></script>
   -->	
   
  <script type="text/javascript" src="js/mootools.js"></script>
<script type="text/javascript" src="js/rokbox/rokbox.js"></script>
<link href="js/rokbox/themes/light/rokbox-style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/rokbox/themes/light/rokbox-config.js"></script>


	<?php
		//imprime cabecera si es que esta definida
		if(isset($heading)){
			echo $heading;
		} 
	?>
	
	<style type="text/css">
		body{
			
		}
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


<div class="container" id="container">
    <div  id="header">
  
    </div><!-- end header -->
     <div id="content" >
     <div id="tabledata" class="section">
     
<!-- cominezo de content -->

<!-- comienzo de top -->
<div id="toolbar-box">

<div class="t">
	<div class="t">
		<div class="t"></div>
	</div>
</div>
		
<div class="m">

<div class="toolbar-list" id="toolbar">

	<div class="clr"></div>

</div>

<div class="pagetitle icon-48-calendar"><h2>Sistema de Inscripción de Talleres</h2></div>

<div class="clr"></div>

</div>

			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>

</div>

<div id="submenu-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
		
				<span><strong>Talleres</strong> | <a href="planificacion/">Planificacion</a><span style="float:right"><a href="login/">Login</a></span>
				
			<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
</div>


<!-- termino de top -->

<!-- comienzo de round top -->
<div id="element-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
			
<!-- termino round top -->			

<?php foreach ($talleres as $taller): ?>
		<?php $link = "main/inscribir/".$taller->id_tp; ?>
		<!-- Comienzo bloque taller programado -->	
		<div class="taller_programado">
			<h1><em><a href="<?php echo $link?>" rel="rokbox[750 450]" title="<?php echo $taller->nombre_taller?> :: <?php echo $taller->nombre_relator?>"><?php echo $taller->nombre_taller?></a></em></h1>
			<div class="left"><img src="images/taller_planificado.png" /></div>
			<div class="left info">				
				<p><strong>Relator:</strong> <?php echo $taller->nombre_relator?></p>
				<p><strong>Lugar:</strong> <?php echo $taller->lugar?></p>
				<p><strong>Fecha:</strong> <?php echo $taller->fecha?></p>
				<p><strong>Categorías:</strong> 
				<?php 
					$cat = "";
					foreach ($categorias as $categoria){
						if($taller->id_taller == $categoria->id_taller){
							$cat .= $categoria->nombre.", ";		
						}
					}
					echo $cat;
				?>
				</p>
				<p><strong><a href="<?php echo $link?>" rel="rokbox[750 600]" title="">Inscribete..</a></strong></p>
				
			</div>
			<div class="clear"></div>			
		</div>
		
		<!-- Término bloque taller programado -->
<?php endforeach;?>		
<a  href="planificacion/">Ver todos..</a>	


   


<!-- comienzo de round top -->
		</div>
		
			<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>

<!-- termino de round -->
<!-- termino de content -->
     </div>
     </div>
    <div  id="footer" class="clearfix">
    	<p class="left">EWOK</p>
		<p class="right">© 2010 Desarrollado por Miguel Cantillana</p>
	</div><!-- end #footer -->
</div><!-- end container -->

</body>
</html>
	