<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';

/**
 * ログインAPI
 *
 */
class Login extends Enjin_Controller {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model',"login");
	}

	/**
	 * @method: post
	 * @action: index
	 * @return: json response|error json response
	 */
	public function index_post()
	{
		try{
                    
			$this->token_check();
			$this->chekapikey();
                        
			$post = $this->input->post();
			$unique_id = isset($post['unique_id'])?$post['unique_id']:'';
			$password = isset($post['password'])?$post['password']:'';
			if( empty($unique_id) or !is_numeric($unique_id) ){
				throw new Exception("unique_idが数値ではありません。",REST_ER_PARAM_FORMAT);
			}
			if( empty($password) or strlen($password)>100 ){
				throw new Exception("passwordが不正です。",REST_ER_PARAM_FORMAT);
			}

			$this->config->load('settings');
			$password = crypt($password, $this->config->item('password_salt'));
			$candidate_id = $this->login->checkCandidate($unique_id, $password);
                        
			if (!$candidate_id){
				throw new Exception("この候補者が存在していません。",REST_ER_PARAM_FORMAT);
			}
			// write to the session
			$this->setCanCandidateId($candidate_id);
			//respond success code
			$this->response(array('code'=>0));
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

}