<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * BusinessesAPI
 * @author tuyennt
 *
 */
class Businesses extends R_Master {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Businesses_model');
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function getParameterId()
    {
        $id = $this->input->get('business_id');
        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }
}