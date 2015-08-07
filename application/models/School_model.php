<?php

/**
 * 市町村区model
 * @author ThinhNH
 *
 */
class School_model extends Enjin_Model {

	protected $_table = 'schools';

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