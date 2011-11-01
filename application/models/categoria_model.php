<?php
class Categoria_model extends Model {
	
	
	private $tabla = "sit_categoria";
		
	
	function __construct(){
		parent::__construct();
		
	}

	
	/** Metodo Utilitario**/
	function _required($required, $data)
	{
		foreach($required as $field)
			if(!isset($data[$field])) return false;
			
		return true;
	}
	
	/**
	 * 
	 * Actualiza una categoria
	 * @param array $options
	 */
	function update($options = array()){
		
			// required values
			if(!$this->_required(array('id_categoria'),$options)) {
				return false;	
			}
	
			if(isset($options['nombre'])){
				$this->db->set('nombre', $options['nombre']);
			}
	
			if(isset($options['descripcion'])){
				$this->db->set('descripcion', $options['descripcion']);
			}
						
			$this->db->where('id_categoria', $options['id_categoria']);
			
			$this->db->update($this->tabla);
			
			return $this->db->affected_rows();
	}
	
	function delete($id){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id			
		$this->db->where('id_categoria', $id);
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
		
		return $this->db->insert_id();
					
		
	}
	
	/**
	 * 
	 * obtiene relatores
	 * @param array $options
	 */
	function get_categories($options = array()){
		
			if(isset($options['id_categoria'])){
				$this->db->where('id_categoria', $options['id_categoria']);
			}
			
			if(isset($options['nombre'])){
				$this->db->where('nombre', $options['nombre']);
			}
			
			if(isset($options['descripcion'])){
				$this->db->where('descripcion', $options['descripcion']);
			}
				
			$query = $this->db->get($this->tabla);

		// sort
			if(isset($options['sortBy']) && isset($options['sortDirection']))
				$this->db->order_by($options['sortBy'], $options['sortDirection']);
				
					
			if(isset($options['count'])){
				return $query->num_rows();
			} 
				
			return $query->result();
		
		
	}
}