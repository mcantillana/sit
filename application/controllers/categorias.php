<?php
class Categorias extends Controller{
	
	function __construct(){
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('categoria_model');
	}
	
	function index(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
		
		$data['categorias']	= $this->categoria_model->get_categories(array('sortBy' => 'nombre_completo','sortDirection' => 'ASC' ));
		
		$this->load->view('admin/categorias/listar_categorias',$data);

	}
	
	
	function eliminar(){
			
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No se ha definido una categoría a eliminar';
	            
		}else{			
			
			$id_categoria	=	$this->uri->segment(3);

			$categorias		= 	$this->categoria_model->get_categories(array('id_categoria' => $id,'limit' => '1'));
			$nombre			=	$categorias[0]->nombre;
			
		
			if($this->categoria_model->delete($id_categoria)){
								
				$tipo 	= 'success';
				$msg	= 'La Categoría '.$nombre. ' se ha eliminado correctamente!';				
							
			}else{
				
				$tipo 	= 'error';
				$msg	= 'No existe La categoría  que deseas eliminar';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('categorias/');
        		
	}
	
	function editar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$id			=	$this->uri->segment(3);	
		
	    $result 	= 	$this->categoria_model->get_categories(array('id_categoria' => $id));
		
	    $data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
			    
	    if(!$result){
	    	
	    	$tipo 	= 'error';
			$msg	= 'No existe la categoría que desa actualizar';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('categorias/');
        	
	    } 

	    // Validate form
	    $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
	    $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');
	    
	    
	    if($this->form_validation->run())
	    {

	    	//print_r($_POST);
	    	$pattern 				= "#<[^>]*?>#";	    	    	
			$desc 					= $_POST['descripcion'];			 	
			$_POST['descripcion'] 	= preg_replace($pattern,'', $desc);
			
	    	// agregamos el id al post
	     	$_POST['id_categoria'] = $id;	     
	     	unset($_POST['editar_categoria']);		

	        if($this->categoria_model->update($_POST)) {

	        	$this->session->set_flashdata('success', 'La categoría se ha actualizado correctamente!');
	            redirect('categorias/');
	            
	        } else {
	        	
                $this->session->set_flashdata('error', 'No se ha podido actualizar La categoría');
	            redirect('categorias/');
	        }
	        			
	        
	    }
	    

	    $data['categoria'] = $result[0];
	    
	    
	    $this->load->view('admin/categorias/editar_categoria', $data);		
	}
	
	function agregar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		// Validate form
	    $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
	    $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');
	    
	    
	    if($this->form_validation->run())
	    {

	    	unset($_POST['agregar_categoria']);
	    	
	    	
	    	// Validation passes
	        $id = $this->categoria_model->add($_POST);
	        
		      
	        if($id) {
	            $this->session->set_flashdata('success', 'La categoría ha sido registrado correctamente!.');
	            redirect('categorias/');
	        } else {
                $this->session->set_flashdata('error', 'No se ha registrar la categoría.');
	            redirect('relatores/');
	        }
	       
	    	
	    }
	    
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');		 
		   		
		$this->load->view('admin/categorias/agregar_categoria',$data);		
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