<?php

/**
 * 市町村区model
 * @author koji.fukami
 *
 */
class Ev_schedules_model extends Enjin_Model {

	protected $_table = 'ev_schedules';

	protected $_primaryKeyField = 'id';

	protected $_labelsMap = array (
		'id' => 'id',
		'holding_date' => 'holding_date',
		'end_date' => 'end_date',
		'individual_theme' => 'individual_theme',
		'capacity' => 'capacity',
		'wanted_deadline' => 'wanted_deadline',
		'venue' => 'venue',
		'day_content' => 'day_content'

	);



	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}


}