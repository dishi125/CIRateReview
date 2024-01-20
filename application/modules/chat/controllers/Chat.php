<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
//		if ($this->session->userdata('auth_key')) {
			$this->load->view('v_chat');
		/*}else {
			redirect('login');
		}*/
	}

}
