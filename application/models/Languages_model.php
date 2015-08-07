<?php

/**
 * Languages model
 * @author tuyennt
 *
 */
require APPPATH . '/models/Can_model.php';

class Languages_model extends Can_Model {

    protected $_table = 'can_languages';

    protected $_primaryKeyField = 'id';

    protected $_labelsMap = array (
        'id' => 'id',
        'foreign_language_id' => 'foreign_language_id',
        'foreign_language'    => 'foreign_language',
        'level_id' => "level_id",
        'oversea_life' => "oversea_life"
    );
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}


}