<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/CRU_Master.php';

/**
 * 市町村区API
 * @author koji.fukami
 *
 */
class Qualifications extends CRU_Master {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Qualifications_model');
    }

    /**
     * Get Education ID
     * @return integer
     */
    protected function getParameterId(){
        $this->chekapikey();
        $method = $this->input->server("REQUEST_METHOD");
        if( $method == "GET" ){
            $id = $this->input->get("can_qualification_id");
        }else {
            parse_str(file_get_contents("php://input"),$var_array);
            $id = isset($var_array["id"])?$var_array["id"]:'';
        }
        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }

    protected  function checkValidations($postData = false)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('enjin_helper');
        $this->form_validation->set_data($postData);
        $method = $this->input->server("REQUEST_METHOD");
        if( $method == "PUT" ){
            $this->form_validation->set_rules('id', '', 'required|integer');
        }
        $this->form_validation->set_rules('qualification_id', '', 'trim|required|integer');
        $this->form_validation->set_rules('acquisition_date', '', 'trim|required|integer|valid_date_check');
        
        $this->form_validation->set_message('required', '%s は必須です。');
        $this->form_validation->set_message('integer', '%s は整数です。');
        $this->form_validation->set_message('valid_date_check', '%s 取得年月は "YYYYMMDD" の形式です。');

        return $this->form_validation->run();

    }

    protected  function prepareInsertData()
    {
        $post = $this->input->post();
        $data = array(
            'can_candidate_id' => $this->getCanCandidateId(),
            'qualification_id' => $post['qualification_id'],
            'qualification'    => isset($post['qualification'])?$post['qualification']:"",
            'score'            => isset($post['score'])?$post['score']:"",
            'acquisition_date' => $post['acquisition_date'],
            'status'           => 0
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