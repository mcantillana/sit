<?php

	$opciones = Array(
 	
	 	array(
	 	'titulo' => 'Cancelar',
	 	'icono' => 'icon-32-cancel',
	 	'link' => 'PlanificarTaller/'	
	 	)
 	);
 	
 	$data	=	array(
	'titulo' => 'Nueva Planificación de Taller',
	'icono' => 'icon-48-article-add',
	'ops'	=> $opciones,
	'miga' => '<a href="PlanificarTaller/">PlanificarTaller</a> | <strong>Agregar</strong>'
	);	 	
 	
	$js = '	
	<script type="text/javascript">
	$(function() {
		$("#fecha_taller").datepicker({
			showOn: \'button\',
			buttonImage: \'images/calendar.png\',
			buttonImageOnly: true,
			dateFormat: \'dd-mm-yy\'
		});
	});
	</script>
	';
	$data['heading'] = $js;

	$this->load->view('admin/admin_header',$data);
	
?>
	<div class="section">

		<?php $this->load->view('admin/admin_top',$data)?>

		<?php if($this->session->flashdata('success')):?>		
		<div id="success" class="info_div"><span class="ico_success"><?php echo $this->session->flashdata('success')?></span></div>
		<?php endif;?>
		
		<?php if($this->session->flashdata('error')):?>
		<div id="fail" class="info_div"><span class="ico_cancel"><?php echo $this->session->flashdata('error')?></span></div>		
		<?php endif;?>
		
			
		
		<?=form_error('hora_inicio','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		
		<?=form_error('lugar','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
		
	    
		
		<?php $data['round'] = 'top'?>
		<?php $this->load->view('admin/admin_round',$data)?>
		<div id="edit_form">
		
		<?php echo form_open('PlanificarTaller/agregar/'); ?>
			

			<label><strong>Relator</strong></label>
			<?php	echo form_dropdown('relator', $relatores); ?>

			<br />
			<label><strong>Taller</strong></label>
			<?php echo form_dropdown('taller', $talleres); ?>
			
			<br />
			<label><strong>Fecha</strong></label>						
			<?php echo form_input('fecha', $hoy,'class="inputclass" id="fecha_taller" readonly');?>
						
			<br />
			<?php 
				$valor_defecto_inicio_hora 		= 11;
				$valor_defecto_inicio_minuto 	= 30;
				
				$valor_defecto_termino_hora 	= 13;
				$valor_defecto_termino_minuto 	= 00;
			?>
			<label><strong>Hora de Inicio</strong></label>					
			<?php echo form_dropdown('hora_inicio', $horas,$valor_defecto_inicio_hora); ?> : <?php echo form_dropdown('minuto_inicio', $minutos,$valor_defecto_inicio_minuto); ?>			
			
			<br />

			<label><strong>Hora de Término</strong></label>					
			<?php echo form_dropdown('hora_termino', $horas,$valor_defecto_termino_hora); ?> : <?php echo form_dropdown('minuto_termino', $minutos,$valor_defecto_termino_minuto); ?>						

			<br />

			<label><strong>Lugar</strong></label>					
			<?php echo form_input('lugar', set_value('lugar'),'class="inputclass"');?>			
						
			<br />		
			
			<label><strong>Cupos</strong></label>
			<?php 					
				
				$valor_defecto = 20;

				echo form_dropdown('cupos', $cupos, $valor_defecto);

			?>
			<br />
			<label><strong>Estado</strong></label>		
			<label>
			<?php echo form_radio('estado', '1'); ?> Activo
			</label>
			<label>    	
			<?php echo form_radio('estado', '0','checked'); ?> Inactivo
			</label>
			<br />	
			<br />
			<?php echo form_submit('agregar_taller_planificado','Guardar','id="save"  class="loginbutton" class="submit"');?>
				
					
			<?php echo form_close(); ?>
			 
		</div>	
			<?php $data['round'] = 'bottom'?>
			<?php $this->load->view('admin/admin_round',$data)?>
	</div><!-- end #section -->
<?php $this->load->view('admin/admin_footer'); ?>