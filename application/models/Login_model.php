<?php

/**
 * ログインmodel
 *
 */
class Login_model extends Enjin_Model {

	protected $_table = 'can_candidates';

	protected $_primaryKeyField = 'unique_id';

	protected $_labelsMap = array (
		'unique_id' => 'unique_id'
	);

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * ThinhNH
	 * Check candidate for login
	 * @param $unique_id
	 * @param $password
	 * @return a candidate object
	 */
	public function checkCandidate($unique_id, $password){
		$candidate = $this->db->select('id')
				->where('unique_id', $unique_id)
				->where ('password', $password)
				->limit(1)
				->get($this->_table)->row_array();
		return $candidate['id'];
	}

}