<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';

/**
 * The Parent Controller for CRU Controller
 * @author ThinhNH
 *
 */
class CRU_Master extends Enjin_Controller {

	protected $_model;

	/**
	 * The can_candidate_id field name in current table
	 * To check with the canCandidateId in Session
	 * @var string
	 */
	protected $_candidateIdFkKey = 'can_candidate_id';

	/**
	 * construct
	 * @param $model
	 */
	public function __construct($model)
	{
		parent::__construct();
		$this->load->model($model, 'model');
		$this->_model = $this->model;

		//get canCandidateId from the session and set to the database
		$this->_model->setCanCandidateId($this->getCanCandidateId());

		$this->token_check();
		//check API
		$this->chekapikey();
	}

	/**
	 * Return the ID of the object
	 * For child controller re-define it  (required)
	 * @throws Exception
	 */
	protected function getParameterId(){
		throw new Exception('Unknown Error!', REST_ER_PAGE_NOTFOUND);
	}

	/**
	 * Check validates
	 * For child controller re-define it
	 * @param bool $postData
	 * @return bool
	 */
	protected function checkValidations($postData = false){
		return true;
	}

	/**
	 * For child controller re-define it (required)
	 * @throws Exception
	 */
	protected function prepareInsertData(){
		throw new Exception('Unknown Error!', REST_ER_PAGE_NOTFOUND);
	}

	/**
	 * For child controller re-define it (required)
	 * @throws Exception
	 */
	protected function prepareUpdateData(){
		throw new Exception('Unknown Error!', REST_ER_PAGE_NOTFOUND);
	}

	protected function checkCanCandidateId(){
		 if (!$this->getCanCandidateId()){
			 throw new Exception("You are not login!", REST_ER_AUTH_ERROR);
		 }
		return true;

	}

	/**
	 * Get the object detail and lock it
	 */
	public function lock_get()
	{
		try{

			$this->checkCanCandidateId();
			$id = $this->getParameterId();
			$code = 0;
                        
                        $filters = array(
                                "id" => $id,
                                "{$this->_candidateIdFkKey}" =>$this->getCanCandidateId()
                        );
                        
			// if Lock flag is ON
			// Get object by normal way
			// and check is that the object locked by their-self or another
			if ($this->_model->getLockFlag() == LOCK_FLAG_ON){
				
                                $objects = $this->_model->getBy($filters);
                                if (count($objects)==0){
                                        throw new Exception ('対象が存在していません。', REST_ER_PAGE_NOTFOUND);
                                }
                                
				//if the current object locked equal this id then this object locked by their self s
				if ($id != $this->getCurrentObjectId()){
					// The object locked by another
					$code = REST_RESPOND_CANNOT_LOCK;
				}
				$data = array();
				if (count($objects)>0)
					$data = $objects[0];
			}else {
                                $objects = $this->_model->getBy($filters);
                                if (count($objects)==0){
                                        throw new Exception ('対象が存在していません。', REST_ER_PAGE_NOTFOUND);
                                }
                            
				// if the lock flag is off
				// get and lock this object
				$result = $this->_model->getByIdAndLock($id);
				if ($result['transStatus']){
					// set the current locked object id
					$this->setCurrentObjectId($id);
				}else {
					throw new Exception('ロック処理に失敗しました。', REST_ER_TRANSACTION_ERROR);
				}
				$data = $result['data'];

			}
			$respond = array(
				'code' => $code,
				'datetime'=> date('Y-m-d H:i:s', time()),
				'data' => $data
			);
			$this->response($respond);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

	/**
	 * Get the object detail
	 *
	 */
	public function index_get()
	{
		try{
                        $this->checkCanCandidateId();
			$id = $this->getParameterId();
                        $filters = array(
                                "id" => $id,
				"{$this->_candidateIdFkKey}" =>$this->getCanCandidateId()
			);
			$list = $this->_model->getById($id, $filters);
                        if (count($list)==0){
                        	throw new Exception ('対象が存在していません。', REST_ER_PAGE_NOTFOUND);
                	}
			$this->response($list);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

	/**
	 * Get list objects of current candidate ID
	 */
	public function list_get()
	{
		try{

			$this->checkCanCandidateId();
			$filters = array(
				"{$this->_candidateIdFkKey}" =>$this->getCanCandidateId()
			);
			$list = $this->_model->getBy($filters);
			$this->response($list);
		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

	/**
	 * Insert new object
	 * @method: POST
	 * @action: index
	 * @return: json response|error json response
	 */
	public function post_post()
	{
		try{

			$this->checkCanCandidateId();
			$postData = $this->input->post();
			if ($this->checkValidations($postData)){
				$insertData = $this->prepareInsertData();
				//insert
				$id = $this->_model->doInsert($insertData);
				if (!$id){
					throw new Exception ('新たな情報がインサートできない。', REST_ER_PAGE_NOTFOUND);
				}
                                
                                $datetime = new Datetime;
				$this->response(array('code'=>REST_RESPOND_SUCCESS, 'datetime'=>$datetime->format(DateTime::ISO8601)));

			}else {
				throw new Exception(validation_errors(), REST_ER_PARAM_REQUIRED);
			}

		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}

	/**
	 * Update the object
	 * @method: PUT
	 * @action: index
	 * @return: json response|error json response
	 */
	public function put_put()
	{
		try{
			parse_str(file_get_contents("php://input"),$var_array);
			$_POST = $var_array; //set the put data to post data
			$id = $this->getParameterId();
			$currentLockedId = $this->getCurrentObjectId();
			if ($id != $currentLockedId) {
				throw new Exception ("Don't have any id locked", REST_ER_PARAM_FORMAT);
			}
			if (empty($id) || !is_numeric($id)){
				throw new Exception ('IDが存在していません。', REST_ER_PAGE_NOTFOUND);
			}
			if ($this->checkValidations($var_array)){

				$filters = array(
					"id" => $id,
					"{$this->_candidateIdFkKey}" =>$this->getCanCandidateId()
				);
				$objects = $this->_model->getBy($filters);
				if (count($objects)==0){
					throw new Exception ('対象が存在していません。', REST_ER_PAGE_NOTFOUND);
				}
				$updateData = $this->prepareUpdateData();
				//insert
				$id = $this->_model->doUpdateAndUnLock($id, $updateData);
				if (!$id){
					throw new Exception ('更新処理に失敗しました。', REST_ER_TRANSACTION_ERROR);
				}
                                // セッションからロックしたデータIDを削除
                                $this->deleteCurrentObjectId();
                                
                                $datetime = new Datetime;
				$this->response(array('code'=>REST_RESPOND_SUCCESS, 'datetime'=>$datetime->format(DateTime::ISO8601)));

			}else {
				throw new Exception(validation_errors(), REST_ER_PARAM_REQUIRED);
			}

		}catch( Exception $e ){
			$message = $e->getMessage();
			$code    = $e->getCode();
			$this->error_response($message,$code);
		}

	}


}