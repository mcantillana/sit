<?php
	

	$this->load->view('admin/admin_header');


	
 	
 	$opciones = Array(
 	
	 	 array(
	 	'titulo' => 'Volver',
	 	'icono' => 'icon-32-back',
	 	'link' => 'dashboard/'	
	 	),
	 	array(
	 	'titulo' => 'Agregar',
	 	'icono' => 'icon-32-new',
	 	'link' => 'relatores/agregar'	
	 	)
	 	
 	);
 	
 	$data	=	array(
	'titulo' => 'Listado de relatores',
	'icono' => 'icon-48-user-add',
	'ops'	=> $opciones,
	'miga' => '<strong>Relatores</strong>'
	);	 	
 	
 	
 	
 
 
	
?>

	<div id="tabledata" class="section">
	
		<?php $this->load->view('admin/admin_top',$data)?>
		
		<?php if($this->session->flashdata('success')):?>		
		<div id="success" class="info_div"><span class="ico_success"><?php echo $this->session->flashdata('success')?></span></div>
		<?php endif;?>
		
		<?php if($this->session->flashdata('error')):?>
		<div id="fail" class="info_div"><span class="ico_cancel"><?php echo $this->session->flashdata('error')?></span></div>		
		<?php endif;?>
		
			
		<br />		

					
		<table id="table">
			<thead>
			<tr>
				<th>Nº</th>
				<th>E-mail </th>
				<th>Nombre Completo</th>
				<th>Acción</th>				
			</tr>
			</thead>
			<tbody>
			
			<?php $i=0; foreach ($relatores as $relator):?>
			<?php 
				$i++;
				$eliminar_l	=	"relatores/eliminar/".$relator->id;
				$eliminar	=	"relatores/#";				
				$editar		=	"relatores/editar/".$relator->id;
			?>
			<tr>
				<td class="table_check"><?php echo $i; ?></td>				
				<td class="table_title"><a href="<?php echo $editar; ?>"><?php echo $relator->email; ?></a></td>
				<td><?php echo $relator->nombre_completo; ?></td>
				<td><a href="<?php echo $eliminar?>" onclick="if(confirm('¿Estas Seguro de Eliminar a <?php echo $relator->nombre_completo?>')){window.location.href = '<?php echo $eliminar_l?>'}">
				<img src="images/deleted.png" alt="Desea Eliminar a  <?php echo $relator->nombre_completo ?>" />
				</a></td>
								
			</tr>
	
			<?php endforeach;?>
			</tbody>
		</table>					
	</div> <!-- end #tabledata -->
	
	

<?php 
	$this->load->view('admin/admin_footer');
?>