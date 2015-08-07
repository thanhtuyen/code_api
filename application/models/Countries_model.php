<?php

/**
 *Countries model
 * @author tuyennt
 *
 */

class Countries_model extends Enjin_Model {

    protected $_table = 'countries';

    protected $_primaryKeyField = 'id';

    protected $_labelsMap = array (
        'id' => 'id',
        'name' => 'name',
        'iso_id' => 'iso_id'
    );

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }

}