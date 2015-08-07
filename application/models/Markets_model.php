<?php

/**
 * 市場マスタmodel
 * @author koji.fukami
 *
 */

class Markets_model extends Enjin_Model {

	protected $_table = 'markets';

	protected $_primaryKeyField = 'id';

	protected $_labelsMap = array (
		'id' => 'id',
		'name' => 'name'
	);

	public function __construct()
	{
		parent::__construct();
	}


}