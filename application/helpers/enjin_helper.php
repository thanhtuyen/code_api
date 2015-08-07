<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('valid_date_check'))
{
    function valid_date_check($date)
    {
        if(isset($date)&(!preg_match("/^[0-9]{4}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) ){
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

if ( ! function_exists('numeric_hyphen')) {

    function numeric_hyphen($str)
    {
        if(isset($str) & (!preg_match('/^[0-9-]+$/i', $str))) {
            return FAlSE;
        } else {
            return TRUE;
        }

    }
}