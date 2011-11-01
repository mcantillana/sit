<?php
class Planificar_taller_model extends Model {
	
	
	private $tabla = "sit_planificar_taller";
		
	
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
	 * Actualiza un Taller Programado
	 * @param $options$actualizacion_pt
	 */
	function update($options = array()){
		
			// required values
			if(!$this->_required(array('id_tp'),$options)) {
				return false;	
			}
		    

	    	
			if(isset($options['id_tp'])){
				$this->db->set('id_tp', $options['id_tp']);
			}
	
			if(isset($options['id_relator'])){
				$this->db->set('id_relator', $options['id_relator']);
			}
	
			if(isset($options['id_taller'])){
				$this->db->set('id_taller', $options['id_taller']);
			}
				
			if(isset($options['fecha'])){
				$this->db->set('fecha', $options['fecha']);
			}

			if(isset($options['hora_inicio'])){
				$this->db->set('hora_inicio', $options['hora_inicio']);
			}

			if(isset($options['hora_termino'])){
				$this->db->set('hora_termino', $options['hora_termino']);
			}

			if(isset($options['lugar'])){
				$this->db->set('lugar', $options['lugar']);
			}
			if(isset($options['cupos'])){
				$this->db->set('cupos', $options['cupos']);
			}						

			if(isset($options['estado'])){
				$this->db->set('estado', $options['estado']);
			}	
						
			$this->db->where('id_tp', $options['id_tp']);
			
			$this->db->update($this->tabla);
			
			return $this->db->affected_rows();
	}
	
	/**
	 * 
	 * funcion que elimina un Taller programado
	 * @param unknown_type $id
	 */	
	function delete($id){
		
		// Produce:
		// DELETE FROM mitabla
		// WHERE id = $id			
		$this->db->where('id_tp', $id);
		$this->db->delete($this->tabla);

		return $this->db->affected_rows();
	}
	//*/
	/**
	 * 
	 * Eregistramos un taller a la planificación
	 * @param $options
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
	
	function get_talleres_planificados($options = array()){
		
			if(isset($options['id_tp'])){
				$this->db->where('id_tp', $options['id_tp']);
			}

			if(isset($options['id_relator'])){
				$this->db->where('id_relator', $options['id_relator']);
			}
						
			if(isset($options['id_taller'])){
				$this->db->where('id_taller', $options['id_taller']);
			}		
			
			$query = $this->db->get($this->tabla);

		
			if(isset($options['sortBy']) && isset($options['sortDirection']))
				$this->db->order_by($options['sortBy'], $options['sortDirection']);
				
					
			if(isset($options['count'])){
				return $query->num_rows();
			} 
				
			return $query->result();
		
		
	}
	//*/
	function custom_query($sql){
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)		
			return $query->result();
			
		return false;
		 
	}

}