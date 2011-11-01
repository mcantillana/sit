<?php
	
Class Talleres extends Controller{


	function __construct(){
		
		parent::Controller();
		
		$this->is_logged_in();
		$this->load->model('taller_model');
		$this->load->model('categoria_model');
		$this->load->model('categoria_taller_model');

	}
	
	function index(){
		
		
			
			
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
		
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$data['talleres']	= $this->taller_model->get_talleres(array('sortBy' => 'nombre','sortDirection' => 'ASC' ));
		
		$this->load->view('admin/talleres/listar_talleres',$data);
		

	}	

	function editar(){
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$id_taller	=	$this->uri->segment(3);	
		
		
	    $result 	= 	$this->taller_model->get_talleres(array('id_taller' => $id_taller));
		
	   
	    $data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
			    
	    if(!$result){
	    	
	    	$tipo 	= 'error';
			$msg	= 'El Taller que desa editar no existe';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('talleres/');
        	
	    } 

		// Validate form
	    $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
	    $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');	    
	    $this->form_validation->set_rules('requisitos', 'requisitos', 'trim|required');
	    $this->form_validation->set_rules('categorias','Categorías','callback_valida_unicidad_categorias');	    
	    
	    if($this->form_validation->run())
	    {
	        
	    	// agregamos el id al post
	     	$_POST['id_taller'] = $id_taller;	     
	     	unset($_POST['save']);		

	     	$res = $this->taller_model->get_talleres(array('id_taller'=>$id_taller));
   			
        	
   			$categorias = $_POST['categorias'];	
        	unset ($_POST['categorias']);
   			
	        if($this->taller_model->update($_POST)) {

	        	
	        	//eliminamos todas las categorias del relator
	        	$this->categoria_taller_model->delete(array('id_taller' => $id_taller));
	        	
	           //insertamos las categorias seleccionados
	          
	           
	            foreach ($categorias as $cat){
	            	$add = array(
	            		'id_taller' =>$id_taller,
	            		'id_categoria' => $cat
	            	);
	            	
	        		$this->categoria_taller_model->add($add);
	            }
   			
	            $this->session->set_flashdata('success', 'El taller se ha actualizado correctamente!');
	            redirect('talleres/');
	            
	        } else {
	        	
                $this->session->set_flashdata('flashError', 'No se ha podido actualizar el taller.');
	            redirect('talleres/');
	        }
	        			
	    
	    }
	    
	    $data['taller'] = $result[0];
	    
	    $data['categorias']		=	$this->categoria_model->get_categories();
	 	$data['seleccionadas']	=	$this->categoria_taller_model->get_categoria_taller(array('id_taller' => $id_taller));    

		$this->load->view('admin/talleres/editar_taller', $data);		
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	function eliminar(){
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No existe el taller que deseas eliminar';
	            
		}else{			
			
			$id_taller	=	$this->uri->segment(3);

			$nombres 	= 	$this->taller_model->get_talleres(array('id_taller' => $id_taller,'limit' => '1'));
			$nombre		=	$nombres[0]->nombre;
			
			
			$this->load->model('planificar_taller_model');
			$tp = $this->planificar_taller_model->get_talleres_planificados(array('id_taller' => $id_taller, 'count' => true));
			
			if($tp){
				$tipo 	= 'error';
				$msg	= 'Imposible eliminar el taller, debido a que tiene un taller programado!';
				$this->session->set_flashdata($tipo, $msg);
        		redirect('talleres/');	
			}
		
			if($this->taller_model->delete($id_taller)){
								
				$tipo 	= 'success';
				$msg	= 'El Taller '.$nombre. ' se ha eliminado correctamente!';
				
							
			}else{
				
				$tipo 	= 'error';
				$msg	= 'No existe el taller que deseas eliminar';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('talleres/');		
		
	}
	function agregar(){
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		// Validate form
	    $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
	    $this->form_validation->set_rules('descripcion', 'descripcion', 'trim|required');
	    
	    $this->form_validation->set_rules('requisitos', 'requisitos', 'trim|required');
	    $this->form_validation->set_rules('categorias','Categorías','callback_valida_unicidad_categorias');
	    
	    if($this->form_validation->run())
	    {

	    	unset($_POST['agregar_taller']);
	    	$categorias = $_POST['categorias'];
	    	unset($_POST['categorias']);
	    	
	    	
	    	// Validation passes
	    	
	        $id_taller = $this->taller_model->add($_POST);
	        
		      
	        if($id_taller) {
	        	
	           foreach ($categorias as $cat){
	            	$add = array(
	            		'id_taller' =>$id_taller,
	            		'id_categoria' => $cat
	            	);
	            	
	        		$this->categoria_taller_model->add($add);
	            }
	            
	            $this->session->set_flashdata('success', 'El taller ha sido registrado correctamente!.');
	            redirect('talleres/');
	        } else {
                $this->session->set_flashdata('error', 'No se ha registrar el taller');
	            redirect('talleres/');
	        }
	       
	    	
	    }
	    
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');		 
		   		
		$data['categorias']	=	$this->categoria_model->get_categories();
		$this->load->view('admin/talleres/agregar_taller',$data);		
	}	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $email
	 */
	function valida_unicidad_categorias($categorias){

		$cont = count($categorias);
	
		if($cont){
			return true;	
		}
		
		$this->form_validation->set_message('valida_unicidad_categorias', 'Debes seleccionar al menos una categoría');		 
		return false;
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
	