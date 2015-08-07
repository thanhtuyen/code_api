<?php

/**
 * ユーザー企業認証model
 * @author koji.fukami
 *
 */
class Authcompany_model extends CI_Model {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * API KEY,ユーザー企業ID チェック
	 * @param string $apikey
	 * @param number $company_id
	 * @return array|boolean
	 */
	public function checkapikey( $apikey , $company_id )
	{
		$company_id = intval($company_id);
		$this->db->where("id",$company_id);
		$this->db->where("api_key",$apikey);
		$this->db->where("status",0);
		$query = $this->db->get("rec_companies");

		//DBに存在した場合は取得した企業情報を配列でreturn
		//存在しない場合はfalseをreturn
		if( $query->num_rows() ){
			return $query->row_array(0);
		}else{
			return false;
		}
	}

}