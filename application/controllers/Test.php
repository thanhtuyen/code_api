<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Test extends REST_Controller {

	public function index_get()
	{
		$this->response([
				'status' => 1,
				'key' => "get"
		], 200);
	}

	public function index_post()
	{
		$this->response([
				'status' => 1,
				'key' => "post"
		], 200);
	}

	public function ng_get()
	{
		$this->response([
				'status' => 1,
				'key' => "ng_get"
		], 500);
	}


	public function config_get()
	{
		$this->load->config("my_app");
		$job_status = config_item('job_status');
		$this->response([ "config" => [
			config_item('job_status')
		] ]);
	}


}