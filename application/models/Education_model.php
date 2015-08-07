<?php

/**
 * 市町村区model
 * @author ThinhNH
 *
 */
require APPPATH . '/models/Can_model.php';

class Education_model extends Can_Model {

	protected $_table = 'can_educations';

	protected $_statusFlagField = '';

	protected $_primaryKeyField = 'id';

	protected $_labelsMap = array (
		'id' => 'id',
		'school_id' => 'school_id',
		'school' => 'school',
                'undergraduate_id' => 'undergraduate_id',
		'undergraduate' => 'undergraduate',
		'department' => 'department',
		'student_bunri_class_id' => 'student_bunri_class_id',
		'seminar' => 'seminar',
		'major_theme' => 'major_theme',
		'circle' => 'circle',
		'admission_date' => 'admission_date',
		'graduation_date' => 'graduation_date'
	);

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

}