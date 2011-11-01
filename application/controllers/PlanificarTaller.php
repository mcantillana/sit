<?php

Class PlanificarTaller extends Controller{
		
	
	function __construct(){
		parent::Controller();
		
		//verificamos si esta autenticado
		$this->is_logged_in();	
		
		$this->load->model('taller_model');
		$this->load->model('relator_model');
		$this->load->model('planificar_taller_model');
				
	}
	
	function index(){
		//echo "sadf";
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$sql = "SELECT tp.id_tp,t.nombre As nombre_taller, r.nombre_completo As nombre_relator, to_char(tp.fecha, 'DD-MM-YYYY') AS fecha, tp.estado, tp.cupos" 
		.	"\n FROM sit_planificar_taller tp, sit_taller t, sit_relator r"
		.	"\n WHERE tp.id_relator = r.id AND tp.id_taller = t.id_taller"
		.	"\n ORDER BY t.nombre ASC"
		;
		$data['talleresplanificados']	=	$this->planificar_taller_model->custom_query($sql);
		
		$this->load->view('admin/PlanificarTaller/listar_planificacion_taller',$data);
	}
	
	function activar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$id_tp	 = $this->uri->segment(3);
		$estado  = $this->uri->segment(4);

		

		$tp_result		=	$this->planificar_taller_model->update(array('id_tp' => $id_tp, 'estado' => $estado));
		
		 if(!$tp_result){
		 	$tipo 	= 'error';
			$msg	= 'No se puede activar el Taller planificado';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('PlanificarTaller/');
        	
		 }else{
		 	
		 	$tipo 	= 'success';
			$msg	= 'Se ha activado el Taller planificado';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('PlanificarTaller/');
        	
		 
		 }
	}


	function eliminar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
	
			
		if ($this->uri->segment(3) === FALSE){
			 
			$tipo 	= 'error';
			$msg	= 'No se ha podido eliminar el Taller Planificado';
	            
		}else{						
			$id_tp	=	$this->uri->segment(3);
			if($this->planificar_taller_model->delete($id_tp)){
								
				$tipo 	= 'success';
				$msg	= 'El taller Planificado se ha eliminado correctamente!';				
							
			}else{
				
				$tipo 	= 'error';
				$msg	= 'No existe el taller planificado que deseas eliminar';
			}
			
		}

		$this->session->set_flashdata($tipo, $msg);
        redirect('PlanificarTaller/');
        		
	}
	
	function editar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		$id_tp			=	$this->uri->segment(3);	
		//$tp_result		=	$this->planificar_taller_model->get_talleres_planificados(array('id_tp' => $id_tp));
		$sql	=	"select t.id_tp, t.id_relator,t.id_taller,to_char(t.fecha, 'DD-MM-YYYY') AS fecha, t.hora_inicio, t.hora_termino, t.lugar, t.cupos, t.estado"
		.	"\n	from sit_planificar_taller t limit 1"
		;
		
		$tp_result		=	$this->planificar_taller_model->custom_query($sql);
		
		 if(!$tp_result){
	    	
	    	$tipo 	= 'error';
			$msg	= 'No existe el Taller planificado que deseas eliminar';
			
			$this->session->set_flashdata($tipo, $msg);		
        	redirect('PlanificarTaller/');
        	
	    } 
		
		// Validate form
	    $this->form_validation->set_rules('hora_inicio', 'Hora de inicio', 'callback_valida_hora');
	    $this->form_validation->set_rules('lugar', 'Lugar', 'trim|required');
	    
	    
	    if($this->form_validation->run())
	    {
	  		//print_r($_POST)		 ;   
	  		$h_inicio 	= $this->input->post('hora_inicio').":".$this->input->post('minuto_inicio').":00";
	  		$h_termino 	= $this->input->post('hora_termino').":".$this->input->post('minuto_termino').":00";
	  //  	print_r($_POST);
	    	$actualizacion_pt = array(
	    		'id_tp'			=> $id_tp,
	    		'id_relator' 	=> $this->input->post('relator'),
	    		'id_taller' 	=> $this->input->post('taller'),
	    		'fecha' 		=> $this->input->post('fecha'),
	    		'hora_inicio' 	=> $h_inicio,
	    		'hora_termino' 	=> $h_termino,
	    		'lugar' 		=> $this->input->post('lugar'),
	    		'cupos' 		=> $this->input->post('cupos'),
	    		'estado' 		=> $this->input->post('estado'),
	    	);
	    	
	    //	print_r($actualizacion_pt);
	    	
	       if($this->planificar_taller_model->update($actualizacion_pt)) {

	        	$this->session->set_flashdata('success', 'El taller Planificado se ha modificado correctamente!');
	            redirect('PlanificarTaller/');
	            
	        } else {	        	
                $this->session->set_flashdata('error', 'No se ha podido modificar el Taller Planificado!');
	            redirect('PlanificarTaller/');
	        }
	    		//*/
	    }
		
		
	    
	    
		$talleres	= $this->taller_model->get_talleres(array('sortBy' => 'nombre','sortDirection' => 'ASC' ));		
		$sql = "SELECT t.id, t.nombre_completo FROM sit_relator t ORDER BY nombre_completo ASC";
		$relatores = $this->relator_model->custom_query($sql);
		
		foreach ($relatores as $relator){
			$rel_op[$relator->id] = $relator->nombre_completo;
		}
		$data['relatores'] = $rel_op;
		
		foreach ($talleres as $taller){
			$taller_op[$taller->id_taller] = $taller->nombre;
		}
		
		$this->load->helper('date');
		$cadenafecha = "%d-%m-%Y";
		
		$tiempo = time();
		$cupos = array();
		for($i=1;$i<100;$i++){
			$cupos[$i] = $i; 
		}
		//combos hora
		$horas	=	array();
		for($i=0;$i<24;$i++){
			$h	=	sprintf("%02d",$i);
			$horas[$h] = $h;			
		} 
		
		//combos minutos
		$minutos	=	array();
		for($i=0;$i<60;$i++){
			$m	=	sprintf("%02d",$i);
			$minutos[$m] = $m;			
		} 
				
		$data['tp']	=	$tp_result[0];
		
		
		$hora_inicial	= explode(':', $tp_result[0]->hora_inicio);
		$hora_termino	= explode(':', $tp_result[0]->hora_termino);
		
		//valores por defecto
		$data['valor_defecto_inicio_hora']		= $hora_inicial[0];
		$data['valor_defecto_inicio_minuto'] 	= $hora_inicial[1];
		
		$data['valor_defecto_termino_hora']		= $hora_termino[0];
		$data['valor_defecto_termino_minuto'] 	= $hora_termino[1];
			
		$data['relator_sel']					=	$tp_result[0]->id_relator;
		$data['taller_sel']						=	$tp_result[0]->id_taller;
		$data['cupos_sel']						=	$tp_result[0]->cupos; 
		
		if($tp_result[0]->estado){
			$data['inactivo_checked']			=	0;	
			$data['activo_checked']				=	1;
		}else{
			$data['inactivo_checked']			=	1;	
			$data['activo_checked']				=	0;
		}
		
		
		
		$data['horas'] 							=	$horas;
		$data['minutos']						=	$minutos;
		$data['cupos'] 							= 	$cupos;
		$data['hoy'] 							= 	$tp_result[0]->fecha;//mdate($cadenafecha);		
		$data['relatores'] 						= 	$rel_op;
		$data['talleres']						= 	$taller_op;
		
		$this->load->view("admin/PlanificarTaller/editar_planificacion_taller",$data);
		
	}
	
	function agregar(){
		
			
		if($this->session->userdata('tipo') == 'relator') { 
			die('Acceso denegado');
		}
		
		// Validate form
	    //$this->form_validation->set_rules('fecha', 'Fecha', 'trim|required');
	    $this->form_validation->set_rules('hora_inicio', 'Hora de inicio', 'callback_valida_hora');
	    //$this->form_validation->set_rules('hora_termino', 'Hora de Término', 'trim|required');	    
	    $this->form_validation->set_rules('lugar', 'Lugar', 'trim|required');
	    
	    
	    if($this->form_validation->run())
	    {
	  		$h_inicio 	= $this->input->post('hora_inicio').":".$this->input->post('minuto_inicio').":00";
	  		$h_termino 	= $this->input->post('hora_termino').":".$this->input->post('minuto_termino').":00";
	  //  	print_r($_POST);
	    	$planificacion_taller = array(
	    		'id_relator' 	=> $this->input->post('relator'),
	    		'id_taller' 	=> $this->input->post('taller'),
	    		'fecha' 		=> $this->input->post('fecha'),
	    		'hora_inicio' => $h_inicio,
	    		'hora_termino' => $h_termino,
	    		'lugar' => $this->input->post('lugar'),
	    		'cupos' => $this->input->post('cupos'),
	    		'estado' => $this->input->post('estado'),
	    	);

	    	//print_r($planificacion_taller);
	    	
	    	$id_tp	=	$this->planificar_taller_model->add($planificacion_taller);
	    	
	    			      
	        if($id_tp) {	                    
	            $this->session->set_flashdata('success', 'La planificación del taller se ha realizado correctamente!.');
	            redirect('PlanificarTaller/');	            
	        } else {
                $this->session->set_flashdata('error', 'No se pudo realizar la planificación del taller!');
	            redirect('PlanificarTaller/');
	        }
	       //*/
	    	
	    }
		
		
		$talleres	= $this->taller_model->get_talleres(array('sortBy' => 'nombre','sortDirection' => 'ASC' ));
		
		$sql = "SELECT t.id, t.nombre_completo FROM sit_relator t ORDER BY nombre_completo ASC";
		$relatores = $this->relator_model->custom_query($sql);
		
		foreach ($relatores as $relator){
			$rel_op[$relator->id] = $relator->nombre_completo;
		}
		$data['relatores'] = $rel_op;
		
		foreach ($talleres as $taller){
			$taller_op[$taller->id_taller] = $taller->nombre;
		}
		
		$this->load->helper('date');
		$cadenafecha = "%d-%m-%Y";
		$tiempo = time();
		$cupos = array();
		for($i=1;$i<100;$i++){
			$cupos[$i] = $i; 
		}
		//combos hora
		$horas	=	array();
		for($i=0;$i<24;$i++){
			$h	=	sprintf("%02d",$i);
			$horas[$h] = $h;			
		} 
		
		//combos minutos
		$minutos	=	array();
		for($i=0;$i<60;$i++){
			$m	=	sprintf("%02d",$i);
			$minutos[$m] = $m;			
		} 
		
		$data['horas'] 		=	$horas;
		$data['minutos']	=	$minutos;
		$data['cupos'] 		= $cupos;
		$data['hoy'] 		= mdate($cadenafecha);		
		$data['relatores'] 	= $rel_op;
		$data['talleres']	= $taller_op;
		
		$this->load->view("admin/PlanificarTaller/agregar_planificacion_taller",$data);
	}
	
	/**
	 * 
	 * valida horario de taller
	 * @param $hora_inicio
	 */
	function valida_hora($hora_inicio){
		$hora_termino	=	$this->input->post('hora_termino');
		
		//echo ($hora_inicio > $hora_termino);
		
		
		if($hora_inicio < $hora_termino) {
			//echo $hora_inicio. " - ".$hora_termino;
			//echo "hora_inicio < hora_termino";	
			//die();
			return true;	
		}
		
		$this->form_validation->set_message('valida_hora', 'La hora de inicio debe ser menor que la hora de término!');
		return false;
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
	 