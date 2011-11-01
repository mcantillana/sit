<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sistema de Inscripción de Talleres - Formulario de Inscripción</title>


<script language="javascript" type="text/javascript">
	function setFocus() {
		document.form_registro_talleres.nombre_completo.select();
		document.form_registro_talleres.nombre_completo.focus();
	}

</script>

<style type="text/css">
body{	
	
	font-size:14px;
	color:#666666;
	background:#fff;
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, sans-serif;

}

a{
	color:#666;
	text-decoration:none;
}

a:hover{
	text-decoration:underline;	
}

CUSTOM				 */

#placeholder{width:180px;height:95px;padding:10px;padding-bottom:14px;}
.more{font-size:13px;}
.approved{font-weight:bold;color:#25a21f}
#success{margin:-px 0px;border:1px solid #b2dc4d;color:#40550d;font-family:"Arial", Arial, sans-serif;font-size:12px;background:#cce297;font-weight:700;padding:5px;-moz-border-radius:3px;-webkit-border-radius: 3px;}
#fail{margin:5px 0px;border:1px solid #c82820;color:#c82820;font-family:"Arial", Arial, sans-serif;font-size:12px;font-weight:700;background:#e7928d;padding:5px;-moz-border-radius:3px;-webkit-border-radius: 3px;}
#warning{margin:5px 0px;border:1px solid #efdc90;color:#a9a014;font-family:"Arial", Arial, sans-serif;font-size:12px;font-weight:700;background:#fffecc;padding:5px;-moz-border-radius:3px;-webkit-border-radius: 3px;}

.ico_success{padding-left:20px;background:url(../../images/success.jpg) no-repeat left center}
.ico_cancel{padding-left:20px;background:url(../../images/error.jpg) no-repeat left center}
.ico_error{padding-left:20px;background:url(../../images/ico_error.jpg) no-repeat left center}

.left{
	float:left;
}
#taller #info-taller .campos{
	width:150px;
	font-weight:bold;
	
}
#taller #info-taller .valores{
	width:400px;
	
}
.cls{
	clear:both;
}

#taller{
	margin:auto;
	width:700px;
}

#info-taller{

	border:1px solid #e6db55;
	background-color: #fffbcc;
	margin: 20px;
	padding: 14px;

}

#form-taller{
	margin: 0 10px;
	padding: 20px 40px 25px 40px;
	line-height: 1.5em;

}
#form-taller label{
	margin-top:15px;
	display:block;
	
}
#form-taller input{
	border:1px solid #999;
	padding:3px;
	
}
#form-taller input:focus{
	border:1px solid #666;
	background:#EEE;
}

</style>
</head>
<body onload="javascript:setFocus()">

<div id="taller">
	<div id="info-taller">
		
			<div class="campos left">Nombre Taller</div><div class="valores left">: <?php echo $taller->nombre_taller?></div>
			<div class="cls"></div>
			
			<div class="campos left">Nombre Relator</div><div class="valores left">: <?php echo $taller->nombre_relator?></div>
			<div class="cls"></div>
			<?php 
		
					if ($taller->nivel == 'basico'){
						$nivel	=	"Básico";
					}
					
					if($taller->nivel == 'intermedio'){						
						$nivel = "Intermedio";
					}
					
					if ($taller->nivel == 'avanzado'){
						$nivel	=	"Avanzado";
					}
		//*/			

			?>
			<div class="campos left">Nivel</div><div class="valores left">: <?php echo $nivel?></div>
			<div class="cls"></div>
			
			<div class="campos left">Requisitos</div><div class="valores left">: <?php echo $taller->requisitos?></div>
			<div class="cls"></div>
			
			<div class="campos left">Lugar</div><div class="valores left">: <?php echo $taller->lugar?></div>
			<div class="cls"></div>
			
			<div class="campos left">Fecha</div><div class="valores left">: <?php echo $taller->fecha?></div>
			<div class="cls"></div>
			
			<div class="campos left">Hora</div><div class="valores left">: <?php echo $taller->hora_inicio?> a <?php echo $taller->hora_termino?> hrs.</div>
			<div class="cls"></div>
			
			<div class="campos left">Cupos</div><div class="valores left">: <?php echo $taller->cupos?></div>
			<div class="cls"></div>
	</div>
	<div id="form-taller">
	
		<?php if($this->session->flashdata('success')):?>		
		<div id="success" class="info_div"><span class="ico_success"><?php echo $this->session->flashdata('success')?></span></div>
		<?php endif;?>
		
		<?php if($this->session->flashdata('error')):?>
		<div id="fail" class="info_div"><span class="ico_cancel"><?php echo $this->session->flashdata('error')?></span></div>		
		<?php endif;?>
		
		<?=form_error('email','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		<?=form_error('nombre_completo','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		
	   <form action="<?php echo base_url()?>/main/inscribir/<?php echo $taller->id_tp?>" method="post" id="form" name="form_registro_talleres">
			<label>Nombre completo </label>
			<?php echo form_input('nombre_completo',set_value('nombre_completo'),' size="48" ')?>			

			<label>E-mail</label>			
			<?php echo form_input('email',set_value('email'),' size="48" ')?>
						
			<br /><br />
			
			<input type="submit" value="Realizar Inscripción" />
		</form>
	</div>
</div>
</body>
</html>