<?php
	
Class Participantes extends Controller{

	
	function __construct(){
		
		parent::Controller();
		
		$this->is_logged_in();
	
	
		$this->load->model('participante_model');
		$this->load->model('planificar_taller_model');
		//$this->load->model('categoria_relator_model');
	}
	
	
	function eliminar(){
			
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No se ha definido un participante a eliminar';
	            
		}else{			
			
			$id_tp	=	$this->uri->segment(3);
	
		
			if($this->participante_model->delete($id_tp)){
								
				$tipo 	= 'success';
				$msg	= 'El participante ha sido eliminado correctamente';				
							
			}else{  
				
				$tipo 	= 'error';
				$msg	= 'No se ha podido eliminar el participante”.';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('participantes/');
	}
	
	
	function index(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$id_tp	=	$this->input->post('id_tp');
		
		if(!empty($id_tp)){
			
			$where	=	"where ptp.id_tp = ".$id_tp." and p.id_part = ptp.id_part";
			$data['taller_selecionado'] = $id_tp;
		}else{
			$where = "where p.id_part = ptp.id_part";	
			$data['taller_selecionado'] = "";
		}
		
		
		$sql = "select p.id_part, ptp.id_tp, p.email, p.nombre_completo"
		.	"\n from sit_participante p, sit_participante_taller_planificado ptp "
		.	$where
		; 
		
		$data['participantes'] = $this->participante_model->custom_execute_query($sql);
		//$data['participantes']	=	$this->participante_model->get_participantes(array('sortBy' => 'email', 'sortDirection' => 'ASC'));		

		$sql	=	"select pt.id_tp, t.nombre" 
		.	"\n from sit_planificar_taller pt, sit_taller t"
		.	"\n	where pt.id_taller = t.id_taller"
		;

		$talleres	=	$this->planificar_taller_model->custom_query($sql);
		
		$array_taller['0']	=	"Todos los talleres";	
		foreach ($talleres as $taller){
			$array_taller[$taller->id_tp] = $taller->nombre;
		}
		
		$data['talleres'] = $array_taller;
		
		$this->load->view('admin/participantes/listar_participantes',$data);
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