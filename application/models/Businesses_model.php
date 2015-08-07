<?php

/**
 * Businesses model
 * @author tuyennt
 *
 */
class Businesses_model extends Enjin_Model {

    protected $_table = 'businesses';

    protected $_primaryKeyField = 'id';

    protected $_labelsMap = array (
        'id' => 'id',
        'name' => 'name'
    );
    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }

}