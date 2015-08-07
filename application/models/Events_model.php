<?php

/**
 * イベントmodel
 * @author koji.fukami
 *
 */
class Events_model extends Enjin_Model {

	protected $_table = 'ev_events';

	protected $_primaryKeyField = 'id';

	protected $_labelsMap = array (
		'ev_events.id' => 'id',
		'ev_events.name' => 'name',
		'job_vote_id' => 'job_vote_id',
		'screening_stages.name' => 'screening_stage_name',
		'target_select_id' => 'target_select_id',
		'contents' => 'contents'

	);

	protected $_joinTables = array (

		array(
			'table' => 'screening_stages',
			'join' => 'screening_stages.id = ev_events.screening_stage_id',
			'type' => 'left'
		),
		array(
			'table' => 'job_votes',
			'join' => 'job_votes.id = ev_events.job_vote_id',
			'type' => 'left'
		)
	);

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function getById($id, $customSelect = '', $useJoinTable = true){
		$object = parent::getById($id, $customSelect, $useJoinTable);
		$this->load->model('Ev_schedules_model', 'schedule');
		$listSchedules = $this->schedule->getBy(array('ev_event_id'=>$id));
		if ($object){
			$object['schedules'] = $listSchedules;
			return $object;
		}
		return array();
	}

	public function getAll($filters = array(), $select= false, $order='',  $useJoinTables = true){
		$listObject = parent::getAll($filters, $select, $order,  $useJoinTables);
		$this->load->model('Ev_schedules_model', 'schedule');
		foreach ($listObject as &$object) {
			$listSchedules = $this->schedule->getBy(array('ev_event_id'=>$object['id']));
			$object['schedules'] = $listSchedules;
		}

		return $listObject;
	}
}