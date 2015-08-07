<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 市町村区API
 * @author ThinhNH
 *
 */
class Events extends R_Master {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Events_model');
	}


	protected function getParameterId(){
		$get = $this->input->get();
		if( !isset($get['ev_event_id']) or !is_numeric($get['ev_event_id']) ){
			throw new Exception("ev_event_idが数値ではありません。",REST_ER_PARAM_FORMAT);
		}
		return $get['ev_event_id'];
	}

}