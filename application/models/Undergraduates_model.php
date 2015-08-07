<?php

/**
 * Undergraduates model
 * @author tuyennt
 *
 */
class Undergraduates_model extends Enjin_Model {

    protected $_table = 'undergraduates';

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