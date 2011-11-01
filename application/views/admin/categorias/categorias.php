<?php
	
?>

<div id="lista_categorias"> 
 
<?php foreach ($categorias as $c):?>
<?php
	$checked = '';
	if(isset($seleccionadas)){		
		foreach ($seleccionadas as $s){
			if($c->id_categoria == $s->id_categoria){
				$checked = 'checked="checked"';
			}		
		}	
	} 
	

?>
<label title="<?php echo $c->descripcion?>"><input type="checkbox" name="categorias[]" value="<?php echo $c->id_categoria?>" id="cat_<?php echo $c->id_categoria?>" <?php echo $checked; ?>/> <?php echo $c->nombre?></label>
<?php endforeach;?>             

</div>