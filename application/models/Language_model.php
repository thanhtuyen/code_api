<?php

/**
 * 語学マスタmodel
 *
 */
class Language_model extends Enjin_Model {

    protected $_table = "foreign_languages";

    protected $_primaryKeyField = "id";

    protected $_labelsMap = array (
        "id" => "id",
        "name" => "name",
        );


    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }
    
}