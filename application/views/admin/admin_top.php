<div id="toolbar-box">

<div class="t">
	<div class="t">
		<div class="t"></div>
	</div>
</div>
		
<div class="m">

<div class="toolbar-list" id="toolbar">
	<ul>
		<?php foreach ($ops as $op): ?>
		
		<li><a href="<?php echo $op['link']; ?>" class="toolbar">
			<span class="<?php echo $op['icono']; ?>"></span><?php echo $op['titulo']; ?></a>
		</li>
				
		<?php endforeach;?>	
	</ul>
 
	<div class="clr"></div>

</div>

<div class="pagetitle <?php echo $icono; ?>"><h2><?php echo $titulo; ?></h2></div>

<div class="clr"></div>

</div>

			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>

</div>

<div id="submenu-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
		
				<span><a href="dashboard/">Dashboard</a> | <?php echo $miga; ?></span>
				
			<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
</div>

		