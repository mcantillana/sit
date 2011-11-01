<?php
class Relator_model extends Model {
	
	
	private $tabla = "sit_relator";
		
	
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
	
	function update($options = array()){
		
			// required values
			if(!$this->_required(array('id'),$options)) {
				return false;	
			}
	
			if(isset($options['email'])){
				$this->db->set('email', $options['email']);
			}
	
			if(isset($options['nombre_completo'])){
				$this->db->set('nombre_completo', $options['nombre_completo']);
			}
	
			if(isset($options['contrasena'])){
				$this->db->set('contrasena', md5($options['contrasena']));
			}
				
			if(isset($options['sitio_web'])){
				$this->db->set('sitio_web', $options['sitio_web']);
			}

			if(isset($options['fotografia'])){
				$this->db->set('fotografia', $options['fotografia']);
			}

			if(isset($options['biografia'])){
				$this->db->set('biografia', $options['biografia']);
			}
						
			$this->db->where('id', $options['id']);
			
			$this->db->update($this->tabla);
			
			return $this->db->affected_rows();
	}
	
			
	function delete($id){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id			
		$this->db->where('id', $id);
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
	function get_users($options = array()){
		
			if(isset($options['id'])){
				$this->db->where('id', $options['id']);
			}
			
			if(isset($options['email'])){
				$this->db->where('email', $options['email']);
			}
			
			if(isset($options['nombre_usuario'])){
				$this->db->where('nombre_usuario', $options['nombre_usuario']);
			}
		
			if(isset($options['contrasena'])){
				$this->db->where('contrasena', $options['contrasena']);
			}
			
		//select * from sit_administrador a where a.nombre_usuario = 'mcantillana' AND a.contrasena = md5('2010')	
			$query = $this->db->get($this->tabla);

		// sort
			if(isset($options['sortBy']) && isset($options['sortDirection']))
				$this->db->order_by($options['sortBy'], $options['sortDirection']);
				
					
			if(isset($options['count'])){
				return $query->num_rows();
			} 
				
			return $query->result();
		
		
	}
	
	function custom_query($sql){
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)		
			return $query->result();
			
		return false;
		 
	}
	
}