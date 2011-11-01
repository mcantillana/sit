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
	 	'link' => 'relatores/'	
	 	)
 	);
 	$editar_a = "Editar: ".$relator->nombre_completo;
 	$data	=	array(
	'titulo' => $editar_a,
	'icono' => 'icon-48-edit',
	'ops'	=> $opciones,
	'miga' => '<a href="relatores/">relatores</a> | <strong>editar</strong>'
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
		
		
		<?=form_error('email','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		<?=form_error('nombre_completo','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
	    <?=form_error('contrasena','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>')?>
		<?=form_error('categorias','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>')?>
		
		<?php $data['round'] = 'top'?>
		<?php $this->load->view('admin/admin_round',$data)?>
		<div id="edit_form">
		
			<?php echo form_open_multipart('relatores/editar/'.$relator->id); ?>
		
			<div class="form-left">
			
			<label><strong>ID</strong></label>						
			<?php echo form_input('id', $relator->id,'class="inputclass" disabled="disabled" style="color:#000"');?>
			
			<br />
			
			<label><strong>E-mail</strong></label>						
			<?php echo form_input('email', $relator->email,'class="inputclass"');?>
						
			<br />
			
			<label><strong>Nombre Completo</strong></label>					
			<?php echo form_input('nombre_completo', $relator->nombre_completo,'class="inputclass"');?>			
			
			<br />
						
			<label><strong>Contraseña</strong></label>						
			<?=form_password('contrasena','','class="inputclass"');?>
		
			<br />
			
			<label><strong>Sitio Web</strong></label>					
			<?php echo form_input('sitio_web', $relator->sitio_web,'class="inputclass"');?>			
			
			<br />
				
				
			<label><strong>Modificar Imagen</strong></label>
			<?php echo form_upload('fotografia')?>				
						
		
			</div>
			<div class="form-left">
				<div id="update-image-relator">
				<?php 
					if(empty($relator->fotografia)){
						$img = '<img src="'.base_url().'/fotos_perfil/no_foto.jpg" alt="No Foto" />'; 
					}else{
						$img = '<img src="'.base_url().'/fotos_perfil/thumbs/'.$relator->fotografia.'" alt="'.$relator->nombre_completo.'" />';
					}				
					
					echo $img;
				?>
									
				</div>
			</div>	
			<div class="cls"></div>
			
			<div class="col w150" style="font-size:14px;margin-top:5px;"><strong>Categorías</strong></div>
			<div class="col w700">
			<?php $data['categorias'] = $categorias; ?>
			<?php $this->load->view('admin/categorias/categorias.php'); ?>
			</div>
			
			<div class="cls"></div>
			<br />
			<br />
			<label><strong>Biografía</strong></label>					
			<?php echo form_textarea('biografia', $relator->biografia,' class="tinymce" ');?>			
			
			<br />		
			<?php echo form_submit('save','Actualizar','id="save"  class="loginbutton" class="submit"');?>
				
			<?php echo form_close(); ?>
		</div>
		<?php $data['round'] = 'bottom'?>
		<?php $this->load->view('admin/admin_round',$data)?>
	</div><!-- end #section -->
<?php 
	$this->load->view('admin/admin_footer');
?>