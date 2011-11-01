<?php

$js = '


<!-- Load TinyMCE -->
<script type="text/javascript" src="'.base_url().'tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$(\'textarea.tinymce\').tinymce({
			// Location of TinyMCE script
			script_url : \''.base_url().'tiny_mce/tiny_mce.js\',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>
<!-- /TinyMCE -->
';
	$data['heading'] = $js;
	$this->load->view('admin/admin_header',$data);

	$opciones = Array(
 	
	 	array(
	 	'titulo' => 'Cancelar',
	 	'icono' => 'icon-32-cancel',
	 	'link' => 'talleres/'	
	 	)
 	);
 	
 	$data	=	array(
	'titulo' => 'Nuevo Taller',
	'icono' => 'icon-48-menu-add',
	'ops'	=> $opciones,
	'miga' => '<a href="talleres/">talleres</a> | <strong>Agregar</strong>'
	);	 	
 	
?>
	<div class="section">

		<?php $this->load->view('admin/admin_top',$data)?>

		<?php if($this->session->flashdata('success')):?>		
		<div id="success" class="info_div"><span class="ico_success"><?php echo $this->session->flashdata('success')?></span></div>
		<?php endif;?>
		
		<?php if($this->session->flashdata('error')):?>
		<div id="fail" class="info_div"><span class="ico_cancel"><?php echo $this->session->flashdata('error')?></span></div>		
		<?php endif;?>
		
			
		<?=form_error('nombre','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		<?=form_error('descripcion','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
	    <?=form_error('requisitos','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>')?>
		<?=form_error('categorias','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>')?>
		
		<?php $data['round'] = 'top'?>
		<?php $this->load->view('admin/admin_round',$data)?>
		<div id="edit_form">
		
			<?php echo form_open_multipart('talleres/agregar/'); ?>
			
			<label><strong>Nombre</strong></label>						
			<?php echo form_input('nombre', set_value('nombre'),'class="inputclass"');?>
						
			<br />
			
			<label><strong>Requisitos</strong></label>					
			<?php echo form_input('requisitos', set_value('requisitos'),'class="inputclass"');?>			
			
			<br />
			<label><strong>Nivel</strong></label>
			<?php 					
				$options = array(
                  'basico'  => 'Nivel Básico',
                  'medio'    => 'Nivel Medio',
                  'avanzado'   => 'Nivel Avanzado',
                  
                );

				echo form_dropdown('nivel', $options, 'basico');

			?>
			
			<br />
			<div class="col w150" style="font-size:14px;margin-top:5px;"><strong>Categorías</strong></div>
			<div class="col w700">
			<?php $data['categorias'] = $categorias; ?>
			<?php $this->load->view('admin/categorias/categorias.php'); ?>
			</div>
			
			<div class="cls"></div>
			<br />
			<label><strong>Descripción</strong></label>					
			<?php echo form_textarea('descripcion', set_value('descripcion'),' class="tinymce" ');?>			
			
		
			<br />
					
			<?php echo form_submit('agregar_taller','Guardar','id="save"  class="loginbutton" class="submit"');?>
				
					
			<?php echo form_close(); ?>
			 
		</div>	
			<?php $data['round'] = 'bottom'?>
			<?php $this->load->view('admin/admin_round',$data)?>
	</div><!-- end #section -->
<?php 
	$this->load->view('admin/admin_footer');
?>