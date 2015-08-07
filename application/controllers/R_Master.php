<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';

/**
 * The Parent Controller for Readonly Controller
 * @author ThinhNH
 *
 */
class R_Master extends Enjin_Controller {

	protected $_model;

	/**
	 * construct
	 * @param $model
	 */
	public function __construct($model)
	{
		parent::__construct();
		$this->load->model($model, 'model');
		$this->_model = $this->model;
	}

	/**
	 * Get Object ID (required to implement in child controller)
	 * @return int
	 */
	protected function getParameterId(){
		return 0;
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
			$list = $this->_model->getById($id);
			$this->response($list);
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
			$list = $this->_model->getAll();
			$this->response($list);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}
	}


}