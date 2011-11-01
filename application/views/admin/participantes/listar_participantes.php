<?php
	
	$this->load->view('admin/admin_header');


	
 	
 	$opciones = Array(
 		 array(
	 	'titulo' => 'Volver',
	 	'icono' => 'icon-32-back',
	 	'link' => 'dashboard/'	
	 	),
	/* 	array(
	 	'titulo' => 'Agregar',
	 	'icono' => 'icon-32-new',
	 	'link' => 'categorias/agregar'	
	 	)
	 	//*/
 	);
 	
 	$data	=	array(
	'titulo' => 'Listado de Participantes',
	'icono' => 'icon-48-groups',
	'ops'	=> $opciones,
	'miga' => '<strong>Participantes</strong>'
	);	 	
 	
 	
 	
 
 
	
?>

	<div id="tabledata" class="section">
	
		
	
	
		<?php $this->load->view('admin/admin_top',$data)?>
		
		<div class="right">
		<?php echo form_open('participantes/','filtro')?>
			<label><strong>Filtro:</strong> </label>
			
			<?php echo form_dropdown('id_tp', $talleres,$taller_selecionado,'onchange="document.forms[0].submit()"'); ?>
		<?php echo form_close(); ?>	
		</div>	
		<br />		
		<br />
		<br />
		
		<?php if($this->session->flashdata('success')):?>		
		<div id="success" class="info_div"><span class="ico_success"><?php echo $this->session->flashdata('success')?></span></div>
		<?php endif;?>
		
		<?php if($this->session->flashdata('error')):?>
		<div id="fail" class="info_div"><span class="ico_cancel"><?php echo $this->session->flashdata('error')?></span></div>		
		<?php endif;?>
		
						
		<table id="table">
			<thead>
			<tr>
				<th>Nº</th>
				<th>E-Mail</th>
				<th>Nombre</th>
				<th>Acción</th>				
			</tr>
			</thead>
			<tbody>
			
			<?php $i=0; foreach ($participantes as $p):?>
			<?php 
				$i++;
				$eliminar_l	=	"participantes/eliminar/".$p->id_part;
				$eliminar	=	"participantes/#";				
				//$editar		=	"categorias/editar/".$p->id_categoria;
				$editar		=	"#";
			?>
			<tr>
				<td class="table_check"><?php echo $i; ?></td>				
				<td class="table_title"><?php echo $p->email; ?></td>
				<td><?php echo $p->nombre_completo; ?></td>
				<td><a href="<?php echo $eliminar?>" onclick="if(confirm('¿Estas Seguro de Eliminar a <?php echo $p->nombre_completo?>')){window.location.href = '<?php echo $eliminar_l?>'}">
				<img src="images/deleted.png" alt="Desea Eliminar a  <?php echo $p->nombre_completo?>" />
				</a></td>
								
			</tr>
	
			<?php endforeach;?>
			</tbody>
		</table>					
	</div> <!-- end #tabledata -->
	
	

<?php 
	$this->load->view('admin/admin_footer');
?>