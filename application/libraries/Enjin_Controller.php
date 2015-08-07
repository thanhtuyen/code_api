<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Enjin Controller
 * parent: REST_Controller
 * このコントローラーを継承して開発
 * @abstract
 * @author koji.fukami
 *
 */
abstract class Enjin_Controller extends REST_Controller {

	/**
	 * ユーザー企業ID
	 */
	private $rec_company_id = null;

	/**
	 * API KEY
	 */
	private $api_key = null;

	/**
	 * エラーマップ
	 */
	private $error_map = array();

	/**
	 * construct
	 * DB接続、SSL通信チェック1、ユーザー企業API KEY＆IDチェック
	 * @return: void|error json response
	 */
	public function __construct()
	{
		parent::__construct();

		try{
			//初期処理
			$this->init();

			//databases接続
			$this->load->database();

			//load session
			$this->load->library('session');

			//SSL通信check
			$this->is_ssl();
                        
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

	/**
	 * 初期処理 initialize
	 * errror map を読み込む
	 */
	private function init(){
		$this->load->config("restcode");
		$this->error_map = config_item("rest_error_messages");
	}

	/**
	 * 送られてくるトークンが正しいかどうかを確認
	 * @throws Exception
	 * @return boolean|error json response
	 */
	protected function token_check()
	{
		//開発用 config/settings.php : $config["token_check_requied"]
		//falseの場合token checkをスキップ
		$this->load->config("settings");
		$required = config_item("token_check_requied");
		if( $required === false ){
			return true;
		}

		//Token model load
		//$this->load->model("Token_model","token");

		//通信methodに合わせてget,postを切り替え
		if( $this->input->server("REQUEST_METHOD") == "GET" ){
			$token = $this->input->get("token");
                        $company_id = $this->input->get("rec_company_id");
		}elseif ($this->input->server("REQUEST_METHOD") == "POST"){
			$token = $this->input->post("token");
                        $company_id = $this->input->post("rec_company_id");
		}else {
			parse_str(file_get_contents("php://input"),$var_array);
			$token = $var_array['token'];
                        $company_id = $var_array['rec_company_id'];
		}

		//token check
		if( $this->checkToken( $company_id , $token ) ){
			return true;
		}else{
			throw new Exception($this->error_map[REST_ER_NO_TOKEN],REST_ER_NO_TOKEN);
		}
	}

	/**
	 * SSL CHECK
	 * @throws Exception
	 * @return boolean|error json response
	 */
	protected function is_ssl()
	{

		//開発用 config/settings.php : $config["ssl_protocol_required"]
		//falseの場合ssl checkをスキップ
		$this->load->config("settings");
		$ssl_protocol_required = config_item('ssl_protocol_required');
		if( !$ssl_protocol_required ){
			return true;
		}

		//SSL通信でなければException
		if( empty($_SERVER["HTTPS"]) or $_SERVER["HTTPS"] !== "on" ){
			throw new Exception("httpsで通信をしてください。",REST_ER_NOSSL_PROTOCOL);
		}
		return true;
	}

	/**
	 * API KEY CHECK
	 * @return boolean|error json response
	 */
	protected function chekapikey()
	{
		//Authcompany model load
		$this->load->model("Authcompany_model","auth");

		//通信methodに合わせてget,postを切り替え
		if( $this->input->server("REQUEST_METHOD") == "GET" ){
			$api_key = $this->input->get("api_key");
			$rec_company_id = $this->input->get("rec_company_id");
		}elseif ($this->input->server("REQUEST_METHOD") == "POST" ){
			$api_key = $this->input->post("api_key");
			$rec_company_id = $this->input->post("rec_company_id");
		}else {
			parse_str(file_get_contents("php://input"),$var_array);
			$api_key = $var_array["api_key"];
			$rec_company_id = $var_array["rec_company_id"];
		}

		//apikey check
		if( $this->auth->checkapikey($api_key,$rec_company_id) ){

			//member変数に保存
			$this->setApiKey($api_key);
			$this->setRecCompanyId($rec_company_id);

			return true;
		}else{
			//error response
			$this->error_response("apikey または company_id が不正です。",REST_ER_APIKEY_AUTH);
		}
	}

        /**
	 * check token
	 * @param number $chk_company_id
	 * @param string $chk_token
	 * @return boolean
	 */
	public function checkToken($chk_company_id,$chk_token)
	{
		$chk_company_id = intval($chk_company_id);

		//セッションに存在している場合true
		if( ($chk_company_id == $this->session->userdata('rec_company_id')) && ($chk_token == $this->session->userdata('token')) ){
			return true;
		}else{
			return false;
		}
	}
        
	/**
	 * error responseを出力する。
	 * @param string $message: 出力するmessage
	 * @param number $code: default:9000 :出力する code
	 * @param number $responsecode: default:400 :HTTPレスポンスコード
	 * @param string $param: 出力するparam
	 * @return json response
	 */
	protected function error_response( $message , $code = 9000 , $responsecode = 400 , $param = "" )
	{
                // バリデートにより複数のエラーがある場合
                $error_messages = explode("\n", $message);
                if(count($error_messages) > 2){
                    $error = array();
                    foreach ($error_messages as $er_message) {
                        if(!empty($er_message)){
                            $datetime = new Datetime;
                            $response = array();
                            $response["code"] = $code;
                            $response["error"] = [
                                    "message"  => $er_message ,
                                    "param"    => $param ,
                                    "datetime" => $datetime->format(DateTime::ISO8601) ,
                                    "serial"   => $datetime->format("YmdHis") . "-" . sprintf( "%05d" , mt_rand( 0 , 99999 ) ) ,
                            ];
                            array_push($error, $response);
                        }
                    }
                    $this->response($error,$responsecode);
                }else{
                        $datetime = new Datetime;
                        $response = array();
                        $response["code"] = $code;
                        $response["error"] = [
                                "message"  => $message ,
                                "param"    => $param ,
                                "datetime" => $datetime->format(DateTime::ISO8601) ,
                                "serial"   => $datetime->format("YmdHis") . "-" . sprintf( "%05d" , mt_rand( 0 , 99999 ) ) ,
                        ];              
                        $this->response($response,$responsecode);
                }
	}

	/**
	 * api_key setter
	 * @param string $api_key
	 */
	private function setApiKey($api_key)
	{
		$this->api_key = $api_key;
	}

	/**
	 * rec_company_id setter
	 * @param number $rec_company_id
	 */
	private function setRecCompanyId($rec_company_id)
	{
		$this->rec_company_id = intval($rec_company_id);
	}

	/**
	 * api_key getter
	 * @return string
	 */
	protected function getApiKey()
	{
		return $this->api_key;
	}

	/**
	 * rec_company_id getter
	 * @return number
	 */
	protected function getRecCompanyId()
	{
		return $this->rec_company_id;
	}


	/**
	 * Get candidateId from session
	 * @return mixed
	 */
	protected function getCanCandidateId(){

		return $this->session->userdata('canCandidateId');
	}

	/**
	 * Set candidateId to Session
	 * @param $id
	 * @return mixed
	 */
	protected function setCanCandidateId($id){
		return $this->session->set_userdata('canCandidateId', $id);
	}

	/**
	 * Get ObjectID from session
	 * The current object they locked to edit
	 * @return mixed
	 */
	protected function getCurrentObjectId(){
		return $this->session->userdata('currentObjectId');
	}

	/**
	 * Set ObjectID to Session
	 * The current object they locked to edit
	 * @param $id
	 * @return mixed
	 */
	protected function setCurrentObjectId($id){
		return $this->session->set_userdata('currentObjectId', $id);
	}

        /**
	 * Delete ObjectID from Session
	 * @param $id
	 * @return mixed
	 */
	protected function deleteCurrentObjectId(){
		return $this->session->unset_userdata('currentObjectId');
	}



}