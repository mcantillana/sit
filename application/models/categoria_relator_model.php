<?php
class Categoria_relator_model extends Model {
	
	
	private $tabla = "sit_categoria_relator";
		
	
	function __construct(){
		parent::__construct();
		
	}

	/**
	 * 
	 * Elimina un registro en la tabla categoria relator
	 * @param $id
	 */
	function delete($options = array()){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id AND ID ..			
		if(isset($options['id_relator'])){
			$this->db->where('id_relator', $options['id_relator']);	
		}

		if(isset($options['id_categoria'])){
			$this->db->where('id_categoria', $options['id_categoria']);	
		}		
		
		$this->db->delete($this->tabla);

		return $this->db->affected_rows();
	}	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $options
	 */
	function add($options = array()){
						
		$this->db->insert($this->tabla, $options);
		
		return true;
					
		
	}
	
	/**
	 * 
	 * obtiene relatores
	 * @param array $options
	 */
	function get_categories_relator($options = array()){
		
		
			if(isset($options['id_relator'])){
				$this->db->where('id_relator', $options['id_relator']);
			}
			
			if(isset($options['id_categoria'])){
				$this->db->where('id_categoria', $options['id_categoria']);
			}
				
			$query = $this->db->get($this->tabla);

			
			if(isset($options['count'])){
				return $query->num_rows();
			} 
				
			return $query->result();
		
		
	}
		
}