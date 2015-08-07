<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/CRU_Master.php';

/**
 * LanguageAPI
 * @author tuyennt
 *
 */
class Languages extends CRU_Master {
    protected $_model;

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct('Languages_model');
	}

    /**
     * Get Education ID
     * @return string
     */
    protected function getParameterId(){
        //check API
        $this->chekapikey();

        $method = $this->input->server("REQUEST_METHOD");
        if( $method == "GET" ){
            $id = $this->input->get("can_language_id");
        }else {
            parse_str(file_get_contents("php://input"),$var_array);
            $id = isset($var_array["id"])?$var_array["id"]:'';
        }
        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }

    /**
     * Check valid the data
     * @param bool $postData
     * @return mixed
     */
    protected function checkValidations($postData = false)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->form_validation->set_data($postData);
        $method = $this->input->server("REQUEST_METHOD");
        if( $method == "PUT" ){
            $this->form_validation->set_rules('id', '', 'required|integer');
        }
        $this->form_validation->set_rules('foreign_language_id', '', 'required|integer');
        $this->form_validation->set_rules('level_id', '', 'required|integer');
        $this->form_validation->set_rules('oversea_life', '', 'integer');
        
        $this->form_validation->set_message('required', '%s は必須です。');
        $this->form_validation->set_message('integer', '%s は整数です。');

        return $this->form_validation->run();

    }

    protected function prepareInsertData()
    {
        $post = $this->input->post();
        $data = array(
            'can_candidate_id' => $this->getCanCandidateId(),
            'foreign_language_id' => $post['foreign_language_id'],
            'foreign_language' => isset($post['foreign_language'])?$post['foreign_language']:"",
            'level_id' => $post['level_id'],
            'oversea_life' => isset($post['oversea_life'])?$post['oversea_life']:"",
            'status' => 0,
        );
        
        return $data;
    }

    /**
     * We use the same object to update and insert
     * @return array|void
     * @throws Exception
     */
    protected function prepareUpdateData(){
        return $this->prepareInsertData();
    }
}