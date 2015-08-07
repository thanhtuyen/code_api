<?php

/**
 * 職種タイプマスタmodel
 * @author ThinhNH
 *
 */
class JobTypes_model extends Enjin_Model {

	protected $_table = 'jobtypes';

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