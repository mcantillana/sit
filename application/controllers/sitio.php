<?php

	class Sitio extends Controller	{

		function Sitio()
		{
			parent::Controller();
			$this->load->model('sitio_model');
		}

		function index(){

			$data['titulo'] 	= "HOTELES DE LA ZONA DE CONCEPCION"	;
			$data['hoteles']	= $this->sitio_model->test_data();
		
			$this->load->view('sitio_view',$data);
			
		}

		function test2(){
			$data['titulo'] 	= "HOTELES DE LA ZONA DE CONCEPCION"	;
			$data['hoteles']	= $this->sitio_model->test_data_2();
			
			$this->load->view('sitio_view_2',$data);
		}
	}
?>
