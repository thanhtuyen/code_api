<?php

/**
 * Classification model
 * @author tuyennt
 *
 */
class Classification_model extends CI_Model {

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 区分値データ取得
     * $id指定: 一件取得
     * @param number $id default: null
     * @return unknown
     */
    public function get($id=null, $class_type=null)
    {

        $this->db->select("id , name ");

        if( $id !== null ){
            $id = intval($id);
            $this->db->where("id",$id);
        }

        if($class_type !== null) {
            switch($class_type) {
                case 0;
                    $table = "student_bunri_classes";
                    break;
                case 1;
                    $table = "manage_bunri_classes";
                    break;
                case 2:
                    $table = "school_classes";
                    break;
                case 3:
                    $table = "public_private_classes";
                    break;
                case 4:
                    $table = "levels";
                    break;
            }
        }

        $this->db->where("status",0);
        if($id !== null) {
            $result = $this->db->get($table)->row_array();
        } else {
            $result = $this->db->get($table)->result_array();
        }


        return $result;
    }
}