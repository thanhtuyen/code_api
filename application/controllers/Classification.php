<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';

/**
 * Class Classification
 * @author tuyennt
 */
class Classification extends Enjin_Controller {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Classification_model',"classification");
    }

    /**
     * 一件取得 class_id={number}が必須
     * /Classification/?class_id={number}&class_type={number}
     * @method: GET
     * @action: index
     * @return: json response|error json response
     */
    public function index_get()
    {
        try{
            //apikey,ユーザー企業ID check
            $this->chekapikey();

            $get = $this->input->get();

            if((isset($get['class_id']) and !is_numeric($get['class_id'])) and (isset($get['class_type']) and !is_numeric($get['class_type']))) {
                $message_class_id = "class_idが数値ではありません";
                $message_class_type = "class_typeが数値ではありません。";
                $datetime = new Datetime;
                $response = array();
                $response["code"] = REST_ER_PARAM_FORMAT;
                $response["error"] = [
                    "message"  => $message_class_id ,
                    "param"    => '' ,
                    "datetime" => $datetime->format(DateTime::ISO8601) ,
                    "serial"   => $datetime->format("YmdHis") . "-" . sprintf( "%05d" , mt_rand( 0 , 99999 ) ) ,
                ];
                $response_type["code"] = REST_ER_PARAM_FORMAT;
                $response_type["error"] = [
                    "message"  => $message_class_type ,
                    "param"    => '' ,
                    "datetime" => $datetime->format(DateTime::ISO8601) ,
                    "serial"   => $datetime->format("YmdHis") . "-" . sprintf( "%05d" , mt_rand( 0 , 99999 ) ) ,
                ];
                $error = array($response, $response_type);
                $responsecode = 400;
                $this->response($error,$responsecode);

            }

            if(!isset($get['class_id']) or !is_numeric($get['class_id'])) {
                throw new Exception("class_idが数値ではありません。",REST_ER_PARAM_FORMAT);
            }

            if(!isset($get['class_type']) or !is_numeric($get['class_type']) or !in_array($get['class_type'], array(0,1,2,3,4))) {
                throw new Exception("class_typeが数値ではありません。",REST_ER_PARAM_FORMAT);
            }

            $list = $this->classification->get($get["class_id"],$get["class_type"]);

            $this->response($list);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $code    = $e->getCode();
            $this->error_response($message,$code);
        }
    }

    /**
     * @method: GET
     * @action: list
     * @return: json response|error json response
     */
    public function list_get()
    {
        try{
            //apikey,ユーザー企業ID check
            $this->chekapikey();

            $get = $this->input->get();

            if(!isset($get['class_type']) or !is_numeric($get['class_type']) or !in_array($get['class_type'], array(0,1,2,3,4))) {
                throw new Exception("class_typeが数値ではありません。",REST_ER_PARAM_FORMAT);
            }

            $list = $this->classification->get(null,$get["class_type"]);
            $this->response($list);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $code    = $e->getCode();
            $this->error_response($message,$code);
        }
    }
}