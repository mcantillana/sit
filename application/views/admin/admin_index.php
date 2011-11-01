<?php 
	$data['nombre'] = $nombre;
	
?>
<?php 	$this->load->view('admin/admin_header',$data); ?>


		<div id="content_main" class="clearfix">
			<div id="main_panel_container" class="left">
			
			<div id="shortcuts" class="clearfix">
				<h2 class="ico_mug">Panel Control</h2>
				<ul>
					<li><a href="administradores/"><img src="images/header/icon-48-user.png" alt="Administradores" title="Administradores" /><span>Admin</span></a></li>
					<li><a href="relatores/"><img src="images/header/icon-48-user-add.png" alt="Relatores" title="Relatores" /><span>Relatores</span></a></li>
					<li><a href="categorias/"><img src="images/header/icon-48-category.png" alt="Administrador de Categorías" title="Administrador de Categorías" /><span>Categorías</span></a></li>
					<li><a href="talleres/"><img src="images/header/icon-48-menumgr.png" alt="Administrador de talleres" title="Administrador de talleres" /><span>Talleres</span></a></li>					
					<li><a href="PlanificarTaller/"><img src="images/header/icon-48-article.png" title="Administrador de Talleres Planificados" alt="Administrador de Talleres Planificados" /><span>Planificacion</span></a></li>
					<li><a href="participantes/"><img src="images/header/icon-48-groups" alt="Participantes" /><span>Participantes</span></a></li>
					<!-- <li><a href=""><img src="images/security.jpg" alt="Security" /><span>Security</span></a></li>
					 -->
				</ul>
			</div><!-- end #shortcuts -->
			</div>
			
			<?php $this->load->view('admin/admin_menu_derecho'); ?>
			
		</div><!-- end #content_main -->
<?php
	$this->load->view('admin/admin_footer'); 
?>		