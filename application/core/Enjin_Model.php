<?php

class Enjin_Model extends CI_Model
{
    /**
     * Table name
     * @var string
     */
    protected $_table = "";

    /**
     * Primary key field name
     * @var string
     */
    protected $_primaryKeyField = "";

    /**
     * Join tables
     * @var array
     */
    protected $_joinTables = array();

    /**
     * Labels map
     * @var array
     */
    protected $_labelsMap = array();

    /**
     * The status field flag
     * @var string
     */
    protected $_statusFlagField  = 'status';


    /**
     * Created field
     * @var string
     */
    protected $_createdField = 'created';

    /**
     * Modified field
     * @var string
     */
    protected $_modifiedField = 'modified';

    /**
     * Lock flag field
     * @var string
     */
    protected $_lockFlagField = 'lock_flag';

    /**
     * Construct function
     */
    public function __construct() {
        parent::__construct();

    }

    /**
     * ====================================================
     * Private Functions
     * ====================================================
     */


    /**
     * Build select string from labels map
     * @return string
     */
    private function getSelectStringFromLabelMap(){
        $selectString = "";
        if (count($this->_labelsMap)==0){
            $selectString = "*";
        }else {
            $lastElementKey = end($this->_labelsMap);
            foreach ($this->_labelsMap as $field=>$label){
                $selectString .= $field . " as ". $label;
                if ($lastElementKey != $field){
                    $selectString .= " , ";
                }
            }
        }
        return $selectString;
    }

    /**
     * Join with $this->_joinTables
     */
    private function joinTable(){
        foreach($this->_joinTables as $join)
            $this->db->join($join['table'], $join['join'], $join['type']);
    }

    /**
     * ====================================================
     * Public Functions
     * ====================================================
     */

    /**
     * @param $offset
     * @param $page
     * @param array $filters
     * @param string $order
     * @param bool|string $select
     * @param bool $useJoinTables
     * @return array
     * @internal param array $filter
     * @internal param bool $useLabelsMap
     * @internal param $start
     * @internal param array $joins
     * @internal param bool $count_total
     */
    public function getListObject($offset, $page, $filters = array(), $select= false, $order='',  $useJoinTables = false)
    {
        // Set filters
        if ($filters) {
            $this->db->where($filters);
        }

        //check status flag
        if (!empty ($this->_statusFlagField)){
            $this->db->where($this->_table.'.'.$this->_statusFlagField, DATABASE_OBJECT_STATUS_ON);
        }

        // set order
        if(!$order) {
            $order = $this->_primaryKeyField. ' desc';
        }

        // if $select if false, select from labelsMap
        if (!$select) {
            $selectString = $this->getSelectStringFromLabelMap();
        }else {
            $selectString = $select;
        }

        $select='SQL_CALC_FOUND_ROWS ' . $selectString ;
        $start = $page * $offset;
        $this->db->select($select, FALSE)
            ->order_by($order)
            ->limit($offset ,$start);
        if($useJoinTables) {
            $this->joinTable();
        }

        $query = $this->db->get($this->_table);
        $list = $query->result_array();
        $query = $this->db->query('SELECT FOUND_ROWS() AS `total_rows`');
        $total_rows = $query->row()->total_rows;
        $return_data = array(
            'data_list' => $list,
            'total_rows' => $total_rows
        );
        return $return_data;
    }

    /**
     * @param array $filters
     * @param bool $select
     * @param string $order
     * @param bool $useJoinTables
     * @return list objects
     */
    public function getAll($filters = array(), $select= false, $order='',  $useJoinTables = false){
        // Set filters
        if ($filters) {
            $this->db->where($filters);
        }

        //check status flag
        if (!empty ($this->_statusFlagField)){
            $this->db->where($this->_table.'.'.$this->_statusFlagField, DATABASE_OBJECT_STATUS_ON);
        }

        // set order
        if(!$order) {
            $order = $this->_primaryKeyField. ' desc';
        }

        // if $select if false, select from labelsMap
        if (!$select) {
            $selectString = $this->getSelectStringFromLabelMap();
        }else {
            $selectString = $select;
        }
        $select = $selectString ;
        $this->db->select($select, FALSE)
            ->order_by($order);

        // if use join tables let join tables
        if($useJoinTables) {
            $this->joinTable();
        }
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }


    /**
     * @param $id
     * @param bool $select
     * @param bool $useJoinTable
     * @return
     */
    public function getById($id, $filters = null, $select = false, $useJoinTable = false) {
        if (!$select) {
            $selectString = $this->getSelectStringFromLabelMap();
        }else {
            $selectString = $select;
        }
        if ($useJoinTable){
            $this->joinTable();
        }
        if($filters){
             $this->db->where($filters);
        }

        //check status flag
        if (!empty ($this->_statusFlagField)){
            $this->db->where($this->_table.'.'.$this->_statusFlagField, DATABASE_OBJECT_STATUS_ON);
        }
        $query = $this->db->select($selectString)
                    ->where($this->_table.'.'.$this->_primaryKeyField, $id)
                    ->from ($this->_table)->get();
        return $query->row_array();
    }

    /**
     * @param $filters
     * @param string $customSelect
     * @param bool $useJoinTable
     * @return
     * @internal param $id
     */
    public function getBy($filters, $customSelect = '', $useJoinTable = false) {

        if (empty($customSelect)){
            $customSelect = $this->getSelectStringFromLabelMap();
        }
        if ($useJoinTable){
            $this->joinTable();
        }
        //check status flag
        if (!empty ($this->_statusFlagField)){
            $this->db->where($this->_table.'.'.$this->_statusFlagField, DATABASE_OBJECT_STATUS_ON);
        }
        $query = $this->db->select($customSelect )
            ->where($filters)
            ->get($this->_table);
        return $query->result_array();
    }


    /**
     * ThinhNH
     * Insert data to table
     * @param $data
     * @return the ID
     */
    public function doInsert($data){
        if (!isset($data[$this->_createdField]))
            $data[$this->_createdField] = date('Y-m-d H:i:s', time());

        if (!isset($data[$this->_modifiedField]))
            $data[$this->_modifiedField] = date('Y-m-d H:i:s', time());

        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }


    /**
     * ThinhNH
     * Update data
     * @param $id
     * @param $data
     * @return mixed
     */
    public function doUpdate($id, $data){
        $data[$this->_modifiedField] = date('Y-m-d H:i:s', time());
        return $this->db->where($this->_primaryKeyField, $id)->update($this->_table, $data);
    }


}
