<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Enjin_Controller.php';
/**
 * sample プログラム
 * @author koji.fukami
 *
 */
class Requestsample extends REST_Controller {

	/**
	 * POSTサンプル
	 * /Requestsample
	 * @method POST
	 * @action index
	 */
	public function index_post()
	{
		echo 3;
	}

	/**
	 * PUTサンプル
	 * /Requestsample
	 * @method PUT
	 * @action index
	 */
	public function index_put()
	{
		echo 2;
	}

	/**
	 * GETサンプル
	 * /Requestsample
	 * @method GET
	 * @action index
	 */
	public function index_get()
	{
		echo 1;
	}
}
