<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 求人票API
 *
 */
class JobVotes extends R_Master {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Jobvotes_model');
	}


	protected function getParameterId(){
		$get = $this->input->get();
		if( !isset($get["job_vote_id"]) or !is_numeric($get["job_vote_id"]) ){
			throw new Exception("job_vote_idが数値ではありません。",REST_ER_PARAM_FORMAT);
		}
		return $get["job_vote_id"];
	}


	/**
	 * Get object detail
	 * @method : GET
	 * @action: get obect detail
	 * @return JSON format
	 */
	public function index_get()
	{
		try{
			$this->chekapikey();
			$id = $this->getParameterId();
			$filters = array(
				'job_votes.status' => 0,
				'job_votes.id' => $id,
				'rec_departments.rec_company_id' => $this->getRecCompanyId()
			);
			$list = $this->_model->getBy($filters, null, true);
			$object = array();
			if (count($list)>0)
				$object = $list[0];
			$this->response($object);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}
	/**
	 * 全件取得
	 * @method: GET
	 * @action: list
	 * @return: json response|error json response
	 */
	public function list_get()
	{
		try{
			$this->chekapikey();
			$filters = array(
				'job_votes.status' => 0,
				'rec_departments.rec_company_id' => $this->getRecCompanyId()
			);
			$list = $this->_model->getBy($filters, null, true);
			$this->response($list);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}
	}

}