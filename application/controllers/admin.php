<?php

Class Admin extends Controller{
	
	
	 private $tipo;
	 private $id;
	 private $_nombre;
	 
	
	function __construct(){
		parent::Controller();
		
		//verificamos si esta autenticado
		$this->is_logged_in();
		
		//cargamos los modelos necesarios
		$this->load->model('admin_model');
		$this->load->model('relator_model');
		
		//registramos los tipo
		$this->id 			= 	$this->session->userdata('id');
		$this->tipo			=	$this->session->userdata('tipo');
		$this->nombre		=	$this->session->userdata('nombre');	
			
		
	}
	 
	function index(){

		$data['id'] 	= 	$this->id;
		$data['tipo']	=	$this->tipo;
		$data['nombre']	=	$this->nombre;
		
		if($this->tipo == 'admin'){
			$this->load->view('admin/admin_index',$data);
		}else{
			//$this->load->view('admin/relatores',$data);
			redirect("relatores/editar/".$this->id);
		}
		
	}

	
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