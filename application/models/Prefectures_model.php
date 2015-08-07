<?php

/**
 *prefectures model
 * @author tuyennt
 *
 */
class Prefectures_model extends Enjin_Model {

    protected $_table = 'prefectures';

    protected $_primaryKeyField = 'id';

    protected $_labelsMap = array (
        'id' => 'id',
        'name' => 'name',
        'iso_id' => "iso_id"
    );

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }
}