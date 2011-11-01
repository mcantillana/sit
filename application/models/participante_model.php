<?php
class Participante_model extends Model {
	
	
	private $tabla = "sit_participante";
		
	
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
			if(!$this->_required(array('id_part'),$options)) {
				return false;	
			}
	
			if(isset($options['id_part'])){
				$this->db->set('id_part', $options['id_part']);
			}
	
			if(isset($options['nombre_completo'])){
				$this->db->set('nombre_completo', $options['nombre_completo']);
			}
						
			$this->db->where('id_part', $options['id_part']);
			
			$this->db->update($this->tabla);
			
			return $this->db->affected_rows();
	}
	
	function delete($id){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id			
		$this->db->where('id_part', $id);
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
	function get_participantes($options = array()){
		
			if(isset($options['id_part'])){
				$this->db->where('id_part', $options['id_part']);
			}
			
			if(isset($options['nombre_completo'])){
				$this->db->where('nombre_completo', $options['nombre_completo']);
			}

			if(isset($options['email'])){
				$this->db->where('email', $options['email']);
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
	
	function custom_execute_query($sql){
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)		
			return $query->result();
			
		return false;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $sql
	 */
	function custom_query($sql){
		$query = $this->db->query($sql);
		//if ($query->num_rows() > 0)		
		//return $query->result();
			
		//return false;
		 
	}
}