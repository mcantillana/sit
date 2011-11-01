<?php

class Crud extends Controller{

	function __construct(){
		parent::Controller();

		$this->load->scaffolding('hotel');
	}
	
	function index(){
	
	}
}