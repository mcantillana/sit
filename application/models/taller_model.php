<?php
class Taller_model extends Model {
	
	
	private $tabla = "sit_taller";
		
	
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
	 * Actualiza un taller
	 * @param array $options
	 */
	function update($options = array()){
		
			// required values
			if(!$this->_required(array('id_taller'),$options)) {
				return false;	
			}
	
			if(isset($options['nombre'])){
				$this->db->set('nombre', $options['nombre']);
			}
	
			if(isset($options['descripcion'])){
				$this->db->set('descripcion', $options['descripcion']);
			}
			
		
			if(isset($options['requisitos'])){
				$this->db->set('requisitos', $options['requisitos']);
			}
	
			if(isset($options['nivel'])){
				$this->db->set('nivel', $options['nivel']);
			}			
			
			$this->db->where('id_taller', $options['id_taller']);
			
			$this->db->update($this->tabla);
			
			return $this->db->affected_rows();
	}
	
	function delete($id){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id			
		$this->db->where('id_taller', $id);
		$this->db->delete($this->tabla);

		return $this->db->affected_rows();
	}	
	/**
	 * 
	 * agrega un nuevo registro
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
	function get_talleres($options = array()){
		
			if(isset($options['id_taller'])){
				$this->db->where('id_taller', $options['id_taller']);
			}
			
			if(isset($options['nombre'])){
				$this->db->where('nombre', $options['nombre']);
			}
			
			if(isset($options['descripcion'])){
				$this->db->where('descripcion', $options['descripcion']);
			}

		
			if(isset($options['requisitos'])){
				$this->db->set('requisitos', $options['requisitos']);
			}
	
			if(isset($options['nivel'])){
				$this->db->set('nivel', $options['nivel']);
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