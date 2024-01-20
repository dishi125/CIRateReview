<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RR_dashboard extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$page = "rr_dashboard";
			$this->load->view('v_rr_dashboard', compact('page'));
        }
    }

}
