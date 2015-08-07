<?php

/**
 * 資格マスタmodel
 * @author koji.fukami
 *
 */
class Qualification_model extends Enjin_Model {

	protected $_table = 'qualifications';

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