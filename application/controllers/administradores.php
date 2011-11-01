<?php

Class Administradores extends Controller{
	
	
	 private $tipo;
	 private $id;
	 private $nombre;
	 
	
	function __construct(){
		parent::Controller();
		
		$this->is_logged_in();
		
		
		//cargamos los modelos necesarios
		$this->load->model('admin_model');
		
	}
	
	function index(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	

		$data['admins'] = $this->admin_model->get_users(array('sortBy' => 'nombre_completo','sortDirection' => 'ASC' ));
			
			
		
		$this->load->view('admin/usuarios/listar_administradores.php',$data);
		
	}
	/**
	 * @return "objeto eliminado"
	 * Funcion encardada de elimar administradores
	 */	
	function eliminar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No se ha definido un usuario a eliminar';
	            
		}else{			
			
				
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
			$id	=	$this->uri->segment(3);			
			if($this->admin_model->delete($id)){
				
				$nombres 	= 	$this->admin_model->get_users(array('id' => $id,'limit' => '1'));
				$nombre		=	$nombres[0]->nombre_completo;
				
				$tipo 	= 'success';
				$msg	= 'El usuario '.$nombre. 'Se ha eliminado correctamente!';	
			}else{
				$tipo 	= 'error';
				$msg	= 'No existe el Administrador que deseas eliminar';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('administradores/');		
	
	}
	function editar($id){
	
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
				
	 	$id				=	$this->uri->segment(3);	
	    $result 	= $this->admin_model->get_users(array('id' => $id));
		
	    $data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
			    
	    if(!$result){
	    	
	    	$tipo 	= 'error';
			$msg	= 'No se ha definido un usuario a actualizar';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('administradores/');
        	
	    } 

	    // Validate form
	    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
	   // $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
	    $this->form_validation->set_rules('nombre_completo', 'Nombre', 'trim|required');
	    
	    
	    if($this->form_validation->run())
	    {
	        // agregamos el id al post
	     	$_POST['id'] = $id;	     
	     			
	    	//si no hay contraseña nueva    
	    	if(empty($_POST['contrasena'])) unset($_POST['contrasena']);
	    	        

	        if($this->admin_model->update($_POST)) {
	        	
	            $this->session->set_flashdata('success', 'El usuario ha sido actualizado con exito!.');
	            redirect('administradores/');
	            
	        } else {
                $this->session->set_flashdata('flashError', 'No se ha podido actualizar el administrador.');
	            redirect('administradores/');
	        }
			//*/
        
	    }
	    
	    $data['admin'] = $result[0];
	    $this->load->view('admin/usuarios/editar_administrador', $data);	 

	}
	
	function agregar(){
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		
		// Validate form
	    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_valida_unicidad');
	    $this->form_validation->set_rules('nombre_completo', 'Nombre', 'trim|required');
	    $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
	    	    
	    if($this->form_validation->run())
	    {
	        $_POST['contrasena']	=	md5($_POST['contrasena']);
	        unset($_POST['add']);
	        
	    	// Validation passes
	        $id = $this->admin_model->add($_POST);
			
	        
	          
	        if($id) {
	            $this->session->set_flashdata('success', 'El administrador ha sido agregado correctamente!.');
	            redirect('administradores/');
	        } else {
                $this->session->set_flashdata('error', 'No se ha podido agregar al usuario.');
	            redirect('administradores/');
	        }
	        
	    	
	    }
	    
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');		 
		   		
		$this->load->view('admin/usuarios/agregar_administrador',$data);
	}
	
	function valida_unicidad($email){
		

			$count = $this->admin_model->get_users(array('email' => $email, 'count' => true));
			if(!$count) {				
				return TRUE;	
			}	

		$this->form_validation->set_message('valida_unicidad', 'ya existe administrador');
		 
		return FALSE;
	}
	
	/**
	 * 
	 * verifica si esta activa la sesion
	 */
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'Tu no tienes permisos para acceder a esta pagina. <a href="'.base_url().'login">Acceder?</a>';	
			die();		
			//$this->load->view('login_form');
		}		
	}	

}	
