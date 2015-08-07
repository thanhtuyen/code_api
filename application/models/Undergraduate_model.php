<?php

/**
 * 市町村区model
 * @author ThinhNH
 *
 */
class Undergraduate_model extends Enjin_Model {

	protected $_table = 'undergraduate';

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