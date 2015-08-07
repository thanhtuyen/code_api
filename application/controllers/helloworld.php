<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helloworld extends CI_Controller {

	public function index()
	{
		//データベース接続
		$this->load->database();

		foreach ($this->db->get('school_initial_datas')->result_array() as $row)
		{
// 		    echo $row['id'];
// 		    echo $row['name'];
// 		    echo $row['school_class_id'];
		}


		$this->config->load('my_app');

		$data['status'] = $this->config->item('status');

		$this->load->view('sampleview', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */