<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('auth_key');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('new_user_id');
		$this->session->unset_userdata('user_permissions');
		$this->session->unset_userdata('all_users');
		$this->session->unset_userdata('user_ip');
		$this->session->unset_userdata('role_name');
		$this->session->unset_userdata('is_review_customer');

		$this->load->view('logout');
	}
}
