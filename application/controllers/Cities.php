<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 市町村区API
 * @author koji.fukami
 *
 */
class Cities extends R_Master {

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Cities_model');
	}

    /**
     * Get City ID
     * @return integer
     */
    protected function getParameterId(){
        $id = $this->input->get("city_id");

        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }

	/**
	 * 都道府県単位に取得
	 * /Cities/pref/{number}
	 * @param number $pref
	 * @return: json response|error json response
	 */
	public function pref_get($pref=0)
	{
		try{
            //apikey,ユーザー企業ID check
            $this->chekapikey();

			//$prefが不正の場合Exception
			if( !$pref or !is_numeric($pref) ){
				throw new Exception("検索値が数値ではありません。",REST_ER_PARAM_FORMAT);
			}

			$list = $this->cities->getPref($pref);

			$this->response($list);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}
	}
}