<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * 語学マスタAPI
 *
 */
class Language extends R_Master {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Language_model');
    }

    protected function getParameterId()
    {
        $id = $this->input->get('language_id');
        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }
}