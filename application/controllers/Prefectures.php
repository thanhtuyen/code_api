<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * Prefectures API
 * @author tuyennt
 *
 */
class Prefectures extends R_Master {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Prefectures_model');
    }

    /**
     * Get Prefecture ID
     * @return integer
     */
    protected function getParameterId(){
        $id = $this->input->get("prefecture_id");

        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }
}