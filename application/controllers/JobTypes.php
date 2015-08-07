<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 職種タイプマスタAPI
 * @author ThinhNH
 *
 */
class JobTypes extends R_Master {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Jobtypes_model');
	}

	protected function getParameterId(){
		$method = $this->input->server("REQUEST_METHOD");
		if( $method == "GET" ){
			$id = $this->input->get("jobtype_id");
		}
		if( !isset($id) or !is_numeric($id)){
			throw new Exception("jobtype_idが数値ではありません。",REST_ER_PARAM_FORMAT);
		}
		return $id;
	}

}