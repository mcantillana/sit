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
	 	'link' => 'talleres/agregar'	
	 	)
	 	
 	);
 	
 	$data	=	array(
	'titulo' => 'Listado de Talleres',
	'icono' => 'icon-48-menumgr',
	'ops'	=> $opciones,
	'miga' => '<strong>Talleres</strong>'
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
				<th>Nombre </th>				
				<th>Nivel</th>
				<th>Acción</th>				
			</tr>
			</thead>
			<tbody>
			
			<?php $i=0; foreach ($talleres as $taller):?>
			<?php 
				$i++;
				$eliminar_l	=	"talleres/eliminar/".$taller->id_taller;
				$eliminar	=	"talleres/#";				
				$editar		=	"talleres/editar/".$taller->id_taller;
			?>
			<tr>
				<td class="table_check"><?php echo $i; ?></td>				
				<td class="table_title"><a href="<?php echo $editar; ?>"><?php echo $taller->nombre; ?></a></td>
				<td class="table_title">
				<?php 
					
					switch ($taller->nivel){
						case 'basico':
							echo "Nivel Básico";
						break;
						
						case 'basico':
							echo "Nivel Medio";
						break;
						
						case 'basico':
							echo "Nivel Avanzado";
						break;
					}	
				?>
				</td>
				<td><a href="<?php echo $eliminar?>" onclick="if(confirm('¿Estas Seguro de Eliminar el Taller <?php echo $taller->nombre?>')){window.location.href = '<?php echo $eliminar_l?>'}">
				<img src="images/deleted.png" alt="Desea Eliminar el taller  <?php echo $taller->nombre?>" />
				</a></td>
								
			</tr>
	
			<?php endforeach;?>
			</tbody>
		</table>					
	</div> <!-- end #tabledata -->
	
	

<?php 
	$this->load->view('admin/admin_footer');
?>