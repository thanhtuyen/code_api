<?php

/**
 * The Can model
 * Handle the functions for lock table
 * @author ThinhNH
 *
 */
class Can_model extends Enjin_Model {

	private $_canTable = 'can_candidates';

	private $_canCandidateId = 0;

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	private function updateFlag($flag) {
		$update = array (
			'lock_flag' => $flag
		);
		return $this->db->where ('id', $this->_canCandidateId)->update($this->_canTable, $update);
	}

	public function getLockFlag(){
		$candidate = $this->db->select('lock_flag')
				->where('id', $this->_canCandidateId)
				->get($this->_canTable)
				->row_array();
		if ($candidate) return $candidate['lock_flag'];
		return LOCK_FLAG_OFF;
	}

	/**
	 * Set curent canCandidateId
	 * @param $id
	 */
	public function setCanCandidateId($id) {
		$this->_canCandidateId = $id;
	}

	/**
	 * Get object information for edit
	 * In case the lock flag is off
	 * @param $id object id
	 * @param string $customSelect
	 * @param bool $useJoinTable
	 * @return mix
	 */
	public function getByIdAndLock($id, $customSelect = '', $useJoinTable = false){
		$this->db->trans_start();
		// get object information
		$object = $this->getById($id, $customSelect, $useJoinTable);
		//set lock flag on
		$this->updateFlag(LOCK_FLAG_ON);
		$this->db->trans_complete();
		$result = array(
			'transStatus' => $this->db->trans_status(),
			'data' => $object
		);
		return $result;

	}

	/**
	 * Update object
	 * Update the lock flag
	 * @param $id
	 * @param $updateData
	 * @return bool status of transaction
	 */
	public function doUpdateAndUnLock($id, $updateData){
		$this->db->trans_start();
		//update data
		$this->doUpdate($id, $updateData);
		//set flag is off
		$this->updateFlag(LOCK_FLAG_OFF);
		$this->db->trans_complete();
		return $this->db->trans_status();

	}
}