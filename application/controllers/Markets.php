<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 市場マスタAPI
 * @author ThinhNH
 *
 */
class Markets extends R_Master {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Markets_model');
	}

	protected function getParameterId(){
		$method = $this->input->server("REQUEST_METHOD");
		if( $method == "GET" ){
			$id = $this->input->get("market_id");
		}
		if( !isset($id) or !is_numeric($id)){
			throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
		}
		return $id;
	}

}