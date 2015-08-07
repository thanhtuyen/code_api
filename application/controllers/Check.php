<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Check extends CI_Controller {

	public function index()
	{
		$data = array();
		$this->load->view('check', $data);
	}
}