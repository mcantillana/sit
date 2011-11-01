<?php

Class Main extends Controller{
	
	private $_tipo		= null;
	private $_id		= null;
	private $_nombre	= null;
	
	
	function __construct(){
		parent::Controller();
		
		$this->load->model('admin_model');
		$this->load->model('relator_model');
		$this->load->model('taller_model');
		$this->load->model('planificar_taller_model');
		$this->load->model('participante_model');
		
		$this->load->model('categoria_model');
		
				
	}
	
	function index(){
		
		$sql = "SELECT tp.id_tp,t.nombre As nombre_taller, r.nombre_completo As nombre_relator,tp.lugar, to_char(tp.fecha, 'DD-MM-YYYY') AS fecha, t.id_taller"
		.	"\n FROM sit_planificar_taller tp, sit_taller t, sit_relator r" 
		.	"\n	WHERE tp.estado = 1 AND tp.id_relator = r.id AND tp.id_taller = t.id_taller"
		.	"\n ORDER BY tp.fecha ASC"
		;
		

		$sql2	=	"select t.id_taller, c.nombre, c.descripcion"
		.	"\n	from sit_taller t, sit_categoria_taller ct, sit_categoria c" 
		.	"\n	where t.id_taller = ct.id_taller and c.id_categoria = ct.id_categoria"
		;
		
		$data['categorias']	= $this->planificar_taller_model->custom_query($sql2);
		$data['talleres'] 	= $this->planificar_taller_model->custom_query($sql);
		
		$this->load->view('front/front_index',$data);

	}

	function inscribir(){

		$id_tp	=	$this->uri->segment(3);	
		
		
		
		$this->form_validation->set_rules('email','E-mail','required|trim|valid_email');
		$this->form_validation->set_rules('nombre_completo','Nombre Completo','required|trim');

	
		
		if($this->form_validation->run()){
			//print_r($_POST);
		//	echo $id_tp;
			//die();			
			
			
			$participante = $this->participante_model->get_participantes(array('email' => $_POST['email']));
			//select * from sit_participante_taller_planificado ptp, sit_participante p
			//where p.email = email AND ptp.id_tp = $id_tp
			
			//print_r($participante);die();
			if(!count($participante)){
				$id_part =	$this->participante_model->add($_POST);
			}else{
				
				$id_part = $participante[0]->id_part;
				
				$sql = "select * from sit_participante_taller_planificado ptp"
				.	"\n	where ptp.id_tp = ".$id_tp." AND ptp.id_part = ".$id_part
				;
				$esta_inscrito = $this->participante_model->custom_execute_query($sql);

				if(count($esta_inscrito[0])){
					$tipo 	= 'error';
					$msg	= 'Usted ya se encuentra inscrito en el taller!';				
					$this->session->set_flashdata($tipo, $msg);
			        redirect('main/inscribir/'.$id_tp);
					
				}
			}
			
			$sql = "INSERT INTO sit_participante_taller_planificado (id_tp, id_part) VALUES('".$id_tp."','".$id_part."')";
			
			if(!$this->participante_model->custom_query($sql)){
				
				$tipo 	= 'success';
				$msg	= 'Se ha registrado el Taller correctamente!';				
				$this->session->set_flashdata($tipo, $msg);
        		redirect('main/inscribir/'.$id_tp);
        		
			}else{
				
				$tipo 	= 'error';
				$msg	= 'No se ha podido registrar el taller!';				
				$this->session->set_flashdata($tipo, $msg);
        		redirect('main/inscribir/'.$id_tp);
			}
			
		}
		
		
		
		$sql = "SELECT tp.id_tp,t.nombre As nombre_taller, r.nombre_completo As nombre_relator,tp.lugar, to_char(tp.fecha, 'DD-MM-YYYY') AS fecha, tp.hora_inicio, tp.hora_termino, tp.estado, tp.cupos, t.nivel, t.requisitos"
		.	"\n FROM sit_planificar_taller tp, sit_taller t, sit_relator r"
		.	"\n WHERE tp.estado = 1 AND tp.id_tp = ".$id_tp." AND tp.id_relator = r.id AND tp.id_taller = t.id_taller"
		.	"\n ORDER BY tp.fecha ASC"
		;
		
		
		$talleres = $this->planificar_taller_model->custom_query($sql);
		$data['taller'] = $talleres[0];
		//print_r($data);
		//echo $id_tp;
		$this->load->view('front/inscribir_taller',$data);
	}
	
	
	function relator(){
		
		$id_relator = $this->uri->segment(3);
		
		$sql	=	"select c.nombre"
		.	"\n from sit_relator r, sit_categoria_relator cr, sit_categoria c" 
		.	"\n where r.id = ".$id_relator." and r.id = cr.id_relator and c.id_categoria = cr.id_categoria"
		;

		
	
		$result		=	$this->relator_model->get_users(array('id' => $id_relator, 'limit' => '1'));
		
		$data['categorias']	=	$this->planificar_taller_model->custom_query($sql);
		$data['relator']	=	$result[0];
		
		$this->load->view('front/detalle_relator',$data);
		
	}
	
	function taller(){
		
		$id_taller 	= 	$this->uri->segment(3);
		$result		=	$this->taller_model->get_talleres(array('id_taller' => $id_taller, 'limit' => '1'));
		
		
		
		$sql = "select c.nombre"
		.	"\n from sit_taller t, sit_categoria_taller ct, sit_categoria c"
		.	"\n where t.id_taller = ".$id_taller." and t.id_taller = ct.id_taller and c.id_categoria = ct.id_categoria"
		;
		
		$data['categorias']	=	$this->planificar_taller_model->custom_query($sql);


		$data['taller'] = $result[0];
		$this->load->view('front/detalle_taller',$data);
		
	}
	function planificacion(){

			

		
		$sql = "SELECT tp.id_tp,t.nombre As nombre_taller, r.nombre_completo As nombre_relator, to_char(tp.fecha, 'DD-MM-YYYY') AS fecha, tp.estado, tp.cupos, tp.id_taller, tp.id_relator" 
		.	"\n FROM sit_planificar_taller tp, sit_taller t, sit_relator r"
		.	"\n WHERE tp.id_relator = r.id AND tp.id_taller = t.id_taller"
		.	"\n ORDER BY t.nombre ASC"
		;
		$data['talleres']	=	$this->planificar_taller_model->custom_query($sql);
		$this->load->view('front/listar_planificacion_talleres',$data);
	}
	
	function login(){

			

		
		$this->form_validation->set_rules('user_login','E-mail','required|trim|callback_valida_login');
		$this->form_validation->set_rules('user_pass','password','required|trim');

	
		
		if($this->form_validation->run()){
				/*		
			if($this->_tipo == 'admin'){
				$result		=	$this->admin_model->get_users(array('email' => $this->id));
			}else{
				$result		=	$this->relator_model->get_users(array('email' => $id));
			}		
			$nombre	=	$result[0]->nombre_completo;
			 //*/
			$data = array(
				'id' => $this->_id,
				'nombre' => $this->_nombre,		
				'tipo' => $this->_tipo,		
				'is_logged_in' => true
			);
			
			$this->session->set_userdata($data);
			
			redirect('dashboard');
		}
		$this->load->view('front/login_form');
	
	}
	
	
	
	function salir()
	{
		$this->session->sess_destroy();
		$this->login();
	}
	
	function valida_login($user){
		
		
		if($this->input->post('user_pass'))
		{
			$pass = $this->input->post('user_pass');			
			$user_result = $this->admin_model->get_users(array('email' => $user, 'contrasena' => md5($pass)));
			
			
			if($user_result) {				
				$this->_tipo 	= 	'admin';
				$this->_id		=	$user_result[0]->id;
				$this->_nombre	=	$user_result[0]->nombre_completo;
				
				//print_r($user_result);
				return TRUE;	
			}	
			
			$user_result = $this->relator_model->get_users(array('email' => $user, 'contrasena' => md5($pass)));
			
			if($user_result) {		
						
				$this->_tipo 	= 	'relator';				
				$this->_id		=	$user_result[0]->id;
				$this->_nombre	=	$user_result[0]->nombre_completo;
				
				return TRUE;	
			}	
			
		}
		$this->form_validation->set_message('valida_login', 'Tu E-mail o Contraseñas son incorrectos');
		 
		return FALSE;
	}
	
	
}