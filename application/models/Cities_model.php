<?php

/**
 * 市町村区model
 * @author koji.fukami
 *
 */
class Cities_model extends Enjin_Model {

    protected $_table = "cities";

    protected $_primaryKeyField = "id";

    protected $_labelsMap = array (
        "id" => "id",
        "name" => "name",
        "iso_id" => "iso_id",
        "prefecture_id" => "prefecture_id");


	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 都道府県別取得
	 * $this->getのwrapper
	 * @param number $pref
	 * @return array
	 */
	public function getPref($pref=null)
	{
        $this->db->select("id , name , iso_id , prefecture_id");

        if( $pref !== null ){
            $pref = intval($pref);
            $this->db->where("prefecture_id",$pref);
        }
        $this->db->where("status",0);
        $result = $this->db->get("cities")->result_array();

        return $result;
	}
}