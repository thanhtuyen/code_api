<?php

/**
 * Token model
 *
 */
class Token_model extends CI_Model {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * create token
	 * @param number $company_id
	 * @return string
	 */
	public function createToken($company_id)
	{

		//sha256でhashを生成 64文字
		$token = hash( 'sha256', uniqid($company_id) );
                
		return $token;
	}
}