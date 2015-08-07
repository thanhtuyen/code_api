<?php

/**
 * @author ThinhNH
 *
 */
class Jobvotes_model extends Enjin_Model {

	protected $_table = 'job_votes';

	protected $_primaryKeyField = 'id';

	protected $_labelsMap = array (
		'job_votes.id' => 'id',
		'job_votes.title' => 'title',
		'job_votes.rec_department_id' => 'rec_department_id',
		'job_votes.requirement' => 'requirement',
		'job_votes.jobtype_id' => 'jobtype_id',
		'job_votes.treatment' => 'treatment',
		'job_votes.qualification_require' => 'qualification_require',
		'job_votes.wanted_person' => 'wanted_person',
		'job_votes.wanted_deadline' => 'wanted_deadline',
		'job_votes.start_salary' => 'start_salary',
		'job_votes.start_date' => 'start_date',
		'job_votes.recruitment_area_id' => 'recruitment_area_id',
		'job_votes.wanted_year' => 'wanted_year',
		'job_votes.rec_recruiter_id' => 'rec_recruiter_id'
	);

	protected $_joinTables = array(
		array(
			'table' => 'rec_departments',
			'join' => 'rec_departments.id = job_votes.rec_department_id and rec_departments.status = 0',
			'type' => 'inner'
		)
	);
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}


}