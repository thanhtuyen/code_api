<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 市町村区API
 * @author koji.fukami
 *
 */
require APPPATH . '/controllers/CRU_Master.php';

class CanCandidates extends CRU_Master {

    protected $_model;
    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Cancandidates_model');
    }

    protected function getParameterId() {
        //check API
        $this->chekapikey();

        $method = $this->input->server("REQUEST_METHOD");
        if( $method == "GET" ){
            $id = $this->input->get("can_candidate_id");
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
    protected  function checkValidations($postData = false)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('enjin_helper');
        $this->form_validation->set_data($postData);

        $this->form_validation->set_rules('last_name', '', 'trim|required');
        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_rules('first_name', '', 'trim|required');
        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_rules('mail_address', '', 'trim|required|valid_email');
        $this->form_validation->set_message('required|valid_email', '%s is required');

        $this->form_validation->set_rules('join_possible_date', '', 'trim|valid_date_check');
        $this->form_validation->set_message('valid_date_check', '%s should be in "YYY-MM-DD" Format');
        $this->form_validation->set_rules('tel', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('extension_number', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('direct_extension', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('cell_number', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('cell_mail', '', 'trim|valid_email');
        $this->form_validation->set_message('valid_email', '%s is valid_email');
        $this->form_validation->set_rules('post_code', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('home_post_code', '', 'trim|numeric_hyphen');
        $this->form_validation->set_message('numeric_hyphen', '%s should numeric and hyphen');
        $this->form_validation->set_rules('birthday', '', 'trim|valid_date_check');
        $this->form_validation->set_message('valid_date_check', '%s should be in "YYY-MM-DD" Format');
        return $this->form_validation->run();
    }

    protected function prepareInsertData()
    {
        $post = $this->input->post();
        $data = array(
            'last_name' => $post['last_name'],
            'last_name_kana'=>isset($post['last_name_kana'])?$post['last_name_kana']:"",
            'last_name_en' =>isset($post['last_name_en'])?$post['last_name_en']:"",
            'mid_name' =>isset($post['mid_name'])?$post['mid_name']:"",
            'mid_name_en' =>isset($post['mid_name_en'])?$post['mid_name_en']:"",
            'first_name' =>$post['first_name'],
            'first_name_kana' =>isset($post['first_name_kana'])?$post['first_name_kana']:"",
            'first_name_en' =>isset($post['first_name_en'])?$post['first_name_en']:"",
            'face_photo' =>isset($post['face_photo'])?$post['face_photo']:"",
            'mail_address' =>$post['mail_address'],
            'unique_id' =>isset($post['unique_id'])?$post['unique_id']:"",
            'password' =>$post['password'],
            'unique_id' =>isset($post['unique_id'])?$post['unique_id']:"",
            'rec_company_id' =>isset($post['rec_company_id'])?$post['rec_company_id']:"",
            'tel' =>isset($post['tel'])?$post['tel']:"",
            'extension_number' =>isset($post['extension_number'])?$post['extension_number']:"",
            'direct_extension' =>isset($post['direct_extension'])?$post['direct_extension']:"",
            'cell_number' =>isset($post['cell_number'])?$post['cell_number']:"",
            'cell_mail' =>isset($post['cell_mail'])?$post['cell_mail']:"",
            'country_id' =>isset($post['country_id'])?$post['country_id']:"",
            'post_code' =>isset($post['post_code'])?$post['post_code']:"",
            'prefecture_id' =>isset($post['prefecture_id'])?$post['prefecture_id']:"",
            'residence' =>isset($post['residence'])?$post['residence']:"",
            'home_country_id' =>isset($post['home_country_id'])?$post['home_country_id']:"",
            'home_post_code' =>isset($post['home_post_code'])?$post['home_post_code']:"",
            'home_prefecture_id' =>isset($post['home_prefecture_id'])?$post['home_prefecture_id']:"",
            'home_residence' =>isset($post['home_residence'])?$post['home_residence']:"",
            'home_tel' =>isset($post['home_tel'])?$post['home_tel']:"",
            'birthday' =>isset($post['birthday'])?$post['birthday']:"",
            'sex' =>isset($post['sex'])?$post['sex']:"",
            'membership' =>isset($post['membership'])?$post['membership']:"",
            'join_possible_date' =>$post['join_possible_date'],
            'remark' =>isset($post['remark'])?$post['remark']:"",
            'bar_code_id' =>isset($post['bar_code_id'])?$post['bar_code_id']:"",
            'referer_company_id' =>isset($post['referer_company_id'])?$post['referer_company_id']:"",
            'status' => 0,
            'last_modified_type' => 0,
            'updatable_flag' => 0,
            'lock_flag' => 0,
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