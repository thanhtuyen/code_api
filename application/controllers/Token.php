<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';

/**
 * Token 生成 controller
 *
 */
class Token extends Enjin_Controller {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}
        
        /**
	 * token生成
	 * @method: POST
	 * @action: index
	 * @return: json response|error json response
	 */
	public function post_post()
	{
                $this->load->model("Token_model","token");
                
                //apikey,ユーザー企業ID check
                $this->chekapikey();
                $token = $this->token->createToken( $this->getRecCompanyId() );

                // セッションに企業IDとトークンを保存
                $this->session->set_userdata('token', $token);
                $this->session->set_userdata('rec_company_id', $this->getRecCompanyId());

                $this->response(["token" => $token]);
	}
        
}