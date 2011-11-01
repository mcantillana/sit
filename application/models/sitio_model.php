<?php
	class Sitio_model extends Model {

		function Sitio_model(){
			parent::__construct();
			
			$this->load->database();
		}

		function test_data(){

			$query = $this->db->query('select * from hotel');

			foreach ($query->result() as $row)
			{
				$data[] =  $row;
				//echo $row['name'];
				//echo $row['email'];
			}
			return $data;
		}
		function test_data_2(){
			$query = $this->db->get('hotel');

			foreach ($query->result() as $f){
				$data[] = $f;
			}
			return $data;
		}
	}

