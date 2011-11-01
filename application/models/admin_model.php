<?php
	class Admin_model extends Model {

		
		private $tabla = "sit_administrador";
		
			
		function Admin_modell(){
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
		 * Agrega usuarios al sistema de administracion de talleres
		 * @param $options
		 * @return ID
		 */
		function add($options = array()){			
						
			$this->db->insert($this->tabla, $options);
			
			return $this->db->insert_id();
					
		}
		
		/**
		 * 
		 * Funcion que actualiza registros
		 * @param $options
		 * @return Fila Afectada o False
		 */	
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
					
		
				$this->db->where('id', $options['id']);
				
				$this->db->update($this->tabla);
				
				return $this->db->affected_rows();
		}
		
		/**
		 * 
		 * Elimina un usuario de la tabla administrador
		 * @param $id
		 */
		
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
		 * Obtiene elemtos de la tabla administrador
		 * @param $options
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
			

			// limit / offset
			if(isset($options['limit']) && isset($options['offset'])){
				$this->db->limit($options['limit'], $options['offset']);
			}else if(isset($options['limit'])){
				$this->db->limit($options['limit']);
			}
				
			// sort
			if(isset($options['sortBy']) && isset($options['sortDirection']))
				$this->db->order_by($options['sortBy'], $options['sortDirection']);
			
				
			$query = $this->db->get($this->tabla);

		
				
					
			if(isset($options['count'])){
				return $query->num_rows();
			} 
		
				
			return $query->result();
			
		}
		
		
	}
	
	
	
