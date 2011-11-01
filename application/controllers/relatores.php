<?php
	
Class Relatores extends Controller{

	private $gallery_path;
	
	
	function __construct(){
		
		parent::Controller();
		
		$this->is_logged_in();
		
	//	$this->load->model('admin_model');
	
		$this->load->model('relator_model');
		$this->load->model('categoria_model');
		$this->load->model('categoria_relator_model');
		
		$this->gallery_path = realpath(APPPATH . '../fotos_perfil');
		$this->gallery_path_url = base_url().'fotos_perfil/';		

	}
	
	function index(){
		
		
		
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	

		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$data['relatores'] = $this->relator_model->get_users(array('sortBy' => 'nombre_completo','sortDirection' => 'ASC' ));
			
		
		$this->load->view('admin/relatores/listar_relatores',$data);
		
		
	}
	
	function agregar(){
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		// Validate form
	    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_valida_unicidad');
	    
	    $this->form_validation->set_rules('nombre_completo', 'Nombre', 'trim|required');
	    $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
		$this->form_validation->set_rules('categorias','Categoría','callback_valida_unicidad_categorias');
	    
	    
	    if($this->form_validation->run())
	    {
	    	$categorias	=	$_POST['categorias'];
	    	unset($_POST['categorias']);
	    	
	        $_POST['contrasena']	=	md5($_POST['contrasena']);
	        unset($_POST['agregar_relator']);
	        
	        
	        if(empty($_POST['sitio_web'])) unset($_POST['sitio_web']);
	        if(empty($_POST['biografia'])) unset($_POST['biografia']);
	    	
	    
			if(!empty($_FILES['foto']['name'])){
	        	$_POST['fotografia'] = $this->do_upload('foto');
			}
				  
	    	// Validation passes
	        $id = $this->relator_model->add($_POST);
		      
	        if($id) {
	        	
	            //insertamos las categorias seleccionados
	            foreach ($categorias as $cat){
	            	$add = array(
	            		'id_relator' =>$id,
	            		'id_categoria' => $cat
	            	);
	        		$this->categoria_relator_model->add($add);
	            }
	            
	        	$this->session->set_flashdata('success', 'El Relator ha sido registrado correctamente!.');
	            redirect('relatores/');
	            
	        } else {
                $this->session->set_flashdata('error', 'No se ha registrar al relator.');
	            redirect('relatores/');
	        }
	        
	    	
	    }
	    
		$data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');		 

		$data['categorias']	=	$this->categoria_model->get_categories();
		
		$this->load->view('admin/relatores/agregar_relator',$data);		
	}
	
	function eliminar(){
		
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No se ha definido un relator a eliminar';
	            
		}else{			
			
			$id	=	$this->uri->segment(3);

			$nombres 	= 	$this->relator_model->get_users(array('id' => $id,'limit' => '1'));
			$nombre		=	$nombres[0]->nombre_completo;
			$foto		=	$nombres[0]->fotografia;
			$this->load->model('planificar_taller_model');
			$tp = $this->planificar_taller_model->get_talleres_planificados(array('id_relator' => $id, 'count' => true));
			
			if($tp){
				$tipo 	= 'error';
				$msg	= 'Imposible eliminar al relator, debido a que tiene un taller programado!';
				$this->session->set_flashdata($tipo, $msg);
        		redirect('relatores/');	
			}
		
			if($this->relator_model->delete($id)){
								
				$tipo 	= 'success';
				$msg	= 'El relator '.$nombre. ' se ha eliminado correctamente!';
				$this->delete_images($foto);
							
			}else{
				
				$tipo 	= 'error';
				$msg	= 'No existe el relator que deseas eliminar';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('relatores/');		
	
	}
	
	function editar(){
	 	
		$id			=	$this->uri->segment(3);	
	    $result 	= 	$this->relator_model->get_users(array('id' => $id));
		
	    $data['id'] 	= 	$this->session->userdata('id');
		$data['tipo']	=	$this->session->userdata('tipo');
		$data['nombre']	=	$this->session->userdata('nombre');	
			    
	    if(!$result){
	    	
	    	$tipo 	= 'error';
			$msg	= 'No existe el relator que deseas editar';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('relatores/');
        	
	    } 

	    // Validate form
	    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
	   // $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');
	    $this->form_validation->set_rules('nombre_completo', 'Nombre', 'trim|required');
  		$this->form_validation->set_rules('categorias','Categoría','callback_valida_unicidad_categorias');
	    
	    if($this->form_validation->run())
	    {
	        
	    	// agregamos el id al post
	     	$_POST['id'] = $id;	     
	     	unset($_POST['save']);		
	    	
	     	//si no hay contraseña nueva    
	    	if(empty($_POST['contrasena'])) unset($_POST['contrasena']);

	    	if(empty($_POST['sitio_web'])) unset($_POST['sitio_web']);

	    	if(empty($_POST['biografia'])) unset($_POST['biografia']);

	    	//if(empty($_POST['fotografia'])) unset($_POST['fotografia']);
	    	    	    	
	    	if(!empty($_FILES['fotografia']['name'])){
    		     $_POST['fotografia'] = $this->do_upload('fotografia');	    		     
	    	}
	    		
    		

   			$res = $this->relator_model->get_users(array('id'=>$id));
   			
        	
   			$categorias = $_POST['categorias'];	
        	unset ($_POST['categorias']);
   			
	        if($this->relator_model->update($_POST)) {

	        	//delete file thumbs and full
	        	if(!empty($_POST['fotografia'])){	
	        		$this->delete_images($res[0]->fotografia);
	        	}
	        	
	        	//eliminamos todas las categorias del relator
	        	$this->categoria_relator_model->delete(array('id_relator' => $id));
	           //insertamos las categorias seleccionados
	           //print_r($categorias);
	           
	            foreach ($categorias as $cat){
	            	$add = array(
	            		'id_relator' =>$id,
	            		'id_categoria' => $cat
	            	);
	            	//print_r($add);
	        		$id_rm =	$this->categoria_relator_model->add($add);
	            }
   			
	            $this->session->set_flashdata('success', 'El relator se ha actualizado correctamente.');
	            
	            if($this->session->userdata('tipo') == 'relator'){
	            	redirect('relatores/editar/'.$id);
	            }else{
	            	redirect('relatores/');	
	            }
	            
	            
	        } else {
	        	
                $this->session->set_flashdata('error', 'No se ha podido actualizar el relator.');
	         	
                if($this->session->userdata('tipo') == 'relator'){
	            	redirect('relatores/editar/'.$id);
	            }else{
	            	redirect('relatores/');	
	            }
	        }
	        			
	        //*/
	    }
	    
	    $data['relator'] = $result[0];
	    
	    $data['categorias']		=	$this->categoria_model->get_categories();
	    
	 
	    
		$data['seleccionadas']	=	$this->categoria_relator_model->get_categories_relator(array('id_relator' => $id));    

		$this->load->view('admin/relatores/editar_relator', $data);	 
		
	}

	function delete_images($name){
		
		//delete file thumbs
		$path	=	$this->gallery_path."/thumbs/".$name;   			
		unlink($path);		
		
		$path	=	$this->gallery_path."/".$name;   			
		unlink($path);		
	}
	
	/**
	 * 
	 * valida unicidad de la dirección de correo
	 * @param $email
	 */
	function valida_unicidad($email){
		

			$count = $this->relator_model->get_users(array('email' => $email, 'count' => true));
			if(!$count) {				
				return TRUE;	
			}	

		$this->form_validation->set_message('valida_unicidad', 'Ya existe el relator que desea registrar');
		 
		return FALSE;
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
	 * Realiza el upload
	 */
	function do_upload($file) {
		
			$config = array(
					'allowed_types' => 'jpg|jpeg|gif|png',
					'upload_path' => './fotos_perfil/',
					'max_size' => 2000
			);
				
			$this->load->library('upload', $config);

			$nombre_imagen = $_FILES[$file]['name'];
			$nombre_imagen = str_replace(" ","_",$nombre_imagen);
			
			$_FILES['foto']['name'] = $nombre_imagen;
			
			if(!$this->upload->do_upload($file)){
				
				$this->session->set_flashdata('error', $this->upload->display_errors('<p>','</p>'));
	            redirect('relatores/');	            					
		
			}
			
			//resize image
			$image_data = $this->upload->data();
			
			$config = array(
				'source_image' => $image_data['full_path'],
				'new_image' => $this->gallery_path . '/thumbs',
				'maintain_ration' => true,
				'width' => 200,
				'height' => 300
			);
			
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			return $image_data['file_name'];
			
		
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
	