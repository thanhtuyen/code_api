<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/CRU_Master.php';

/**
 * 市町村区API
 * @author ThinhNH
 *
 */
class Education extends CRU_Master {

	protected $_model;
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Education_model');

	}

	/**
	 * Get Education ID
	 * @return integer
	 */
	protected function getParameterId(){
		$method = $this->input->server("REQUEST_METHOD");
		if( $method == "GET" ){
			$id = $this->input->get("can_education_id");
		}else {
			parse_str(file_get_contents("php://input"),$var_array);
			$id = isset($var_array["id"])?$var_array["id"]:'';
		}
		if( !isset($id) or !is_numeric($id)){
			throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
		}
		return $id;
	}

	protected function prepareInsertData(){
		$post = $this->input->post();
		$insertData = array(
			'can_candidate_id' 		=>	$this->getCanCandidateId(),
			'school_id'				=>	$post['school_id'],
                        'undergraduate_id'                      =>      $post['undergraduate_id'],
			'department'			=>	isset($post['department'])?$post['department']:'',
			'student_bunri_class_id'=>	isset($post['student_bunri_class_id'])?$post['student_bunri_class_id']:'',
			'seminar'				=>	isset($post['seminar'])?$post['seminar']:'',
			'major_theme'			=>	isset($post['major'])?$post['major']:'',
			'circle'				=>	isset($post['circle'])?$post['circle']:'',
			'admission_date'		=>	isset($post['admission_date'])?$post['admission_date']:'',
			'graduation_date'			=>	isset($post['graduation_date'])?$post['graduation_date']:''
		);
		//school
		if ($post['school_id']==0){
			if (empty($post['school'])){
				throw new Exception ('Please choose a school');
			}
			$this->load->model('School_model', 'school');
			//check school exist
			$school = $this->school->getBy(array('name'=> $post['school']));
			if ($school){
				$insertData['school_id'] = $school['id'];
			}else {
				$insertData['school'] = $post['school'];
			}
		}

		// undergraduate
		if (isset($post['undergraduate_id']) && $post['undergraduate_id']==0){
			if (!empty($post['undergraduate'])){
				$this->load->model('Undergraduates_model', 'undergraduates');
				//check undergraduate exist
				$undergraduate = $this->undergraduates->getBy(array('name'=> $post['undergraduate']));
				if ($undergraduate){
					$insertData['undergraduate_id'] = $undergraduate['id'];
				}else {
					$insertData['undergraduate'] = $post['undergraduate'];
				}
			}
		}
		return $insertData;
	}

	/**
	 * We use the same object to update and insert
	 * @return array|void
	 * @throws Exception
	 */
	protected function prepareUpdateData(){
		return $this->prepareInsertData();
	}

	/**
	 * Check valid the data
	 * @param bool $postData
	 * @return mixed
	 */
	protected function checkValidations($postData = false){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
                $this->load->helper('enjin_helper');
		$this->form_validation->set_data($postData);
		$method = $this->input->server("REQUEST_METHOD");
                if( $method == "PUT" ){
                    $this->form_validation->set_rules('id', '', 'required|integer');
                }
                
		$this->form_validation->set_rules('school_id', '', 'trim|required|integer');
		$this->form_validation->set_rules('undergranduate_id', '', 'trim|integer');
		$this->form_validation->set_rules('student_bunri_class_id', '', 'trim|integer');
                $this->form_validation->set_rules('admission_date', '', 'trim|valid_date_check');
                $this->form_validation->set_rules('graduation_date', '', 'trim|valid_date_check');
                
                $this->form_validation->set_message('required', '%s は必須です。');
                $this->form_validation->set_message('integer', '%s は整数です。');
                $this->form_validation->set_message('valid_date_check', '%s 取得年月は "YYYYMMDD" の形式です。');
                
		return $this->form_validation->run();

	}

}