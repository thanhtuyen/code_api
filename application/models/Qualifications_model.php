<?php

/**
 * 市町村区model
 * @author koji.fukami
 *
 */
require APPPATH.'/models/Can_model.php';

class Qualifications_model extends Can_Model {

    protected $_table = 'can_qualifications';

    protected $_primaryKeyField = 'id';

    protected $_labelsMap = array (
        'id' => 'id',
        'qualification_id' => 'qualification_id',
        'qualification'    => 'qualification',
        'score'            => 'score',
        'acquisition_date' => 'acquisition_date'
    );

    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }

}