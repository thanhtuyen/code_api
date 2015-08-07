<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/R_Master.php';

/**
 * CountriesAPI
 * @author tuyennt
 *
 */
class Countries extends R_Master {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct('Countries_model');

    }
    /**
     * Get country ID
     * @return integer
     */
    protected function getParameterId(){
        $id = $this->input->get("country_id");

        if( !isset($id) or !is_numeric($id)){
            throw new Exception("IDが数値ではありません。",REST_ER_PARAM_FORMAT);
        }
        return $id;
    }
}