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
	 	'link' => 'categorias/agregar'	
	 	)
 	);
 	
 	$data	=	array(
	'titulo' => 'Listado de categorias',
	'icono' => 'icon-48-category',
	'ops'	=> $opciones,
	'miga' => '<strong>Categorias</strong>'
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
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Acción</th>				
			</tr>
			</thead>
			<tbody>
			
			<?php $i=0; foreach ($categorias as $cat):?>
			<?php 
				$i++;
				$eliminar_l	=	"categorias/eliminar/".$cat->id_categoria;
				$eliminar	=	"categorias/#";				
				$editar		=	"categorias/editar/".$cat->id_categoria;
			?>
			<tr>
				<td class="table_check"><?php echo $i; ?></td>				
				<td class="table_title"><a href="<?php echo $editar; ?>"><?php echo $cat->nombre; ?></a></td>
				<td><?php echo $cat->descripcion; ?></td>
				<td><a href="<?php echo $eliminar?>" onclick="if(confirm('¿Estas Seguro de Eliminar a <?php echo $cat->descripcion?>')){window.location.href = '<?php echo $eliminar_l?>'}">
				<img src="images/deleted.png" alt="Desea Eliminar a  <?php echo $cat->descripcion?>" />
				</a></td>
								
			</tr>
	
			<?php endforeach;?>
			</tbody>
		</table>					
	</div> <!-- end #tabledata -->
	
	

<?php 
	$this->load->view('admin/admin_footer');
?>
