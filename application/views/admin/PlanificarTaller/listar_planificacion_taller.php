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
	 	'link' => 'PlanificarTaller/agregar'	
	 	)
 	);
 	
 	$data	=	array(
	'titulo' => 'Listado de Talleres Planificados',
	'icono' => 'icon-48-article',
	'ops'	=> $opciones,
	'miga' => '<strong>Planificar Taller</strong>'
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
				<th>Taller</th>
				<th>Relator</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th>Cupos</th>
				<th>Acción</th>				
			</tr>
			</thead>
			<tbody>
			
			<?php $i=0; foreach ($talleresplanificados as $tp):?>
			<?php 
				$i++;
				$eliminar_l	=	"PlanificarTaller/eliminar/".$tp->id_tp;
				$eliminar	=	"PlanificarTaller/#";				
				$editar		=	"PlanificarTaller/editar/".$tp->id_tp;
			?>
			<tr>
				<td class="table_check"><?php echo $i; ?></td>				
				<td class="table_title"><a href="<?php echo $editar; ?>"><?php echo $tp->nombre_taller; ?></a></td>
				
				<td><?php echo $tp->nombre_relator; ?></td>
				<td><?php echo $tp->fecha; ?></td>
				<td>
				<?php 
					
					if($tp->estado){
						$img = "icon-16-checkin.png";
						$alt = "Taller Activo";
						$segment_url = $tp->id_tp."/0";
					}else{
						$img = "icon-16-deny.png";
						$alt = "taller Inactivo";
						$segment_url = $tp->id_tp."/1";
					}
				 
				?>
				<a href="PlanificarTaller/activar/<?php echo $segment_url?>"><img src="images/<?php echo $img; ?>" title="<?php echo $alt?>" alt="<?php echo $alt?>"  /></a>
				</td>
				<td><?php echo $tp->cupos; ?></td>
								
				<td><a href="<?php echo $eliminar?>" onclick="if(confirm('¿Estas Seguro de Eliminar a <?php echo $tp->nombre_taller?>')){window.location.href = '<?php echo $eliminar_l?>'}">
				<img src="images/deleted.png" alt="Desea Eliminar a  <?php echo $tp->nombre_taller?>" />
				</a></td>
								
			</tr>
	
			<?php endforeach;?>
			</tbody>
		</table>					
	</div> <!-- end #tabledata -->
	
	

<?php 
	$this->load->view('admin/admin_footer');
?>