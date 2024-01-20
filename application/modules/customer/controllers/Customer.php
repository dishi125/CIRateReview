<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetCustomerList = call_api_get($auth_key, 'customer/GetCustomerList');
			$GetCustomerList = json_decode($GetCustomerList, true);

			$check_permission = check_permission("Add Customer");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];
			$this->load->view('v_customer', compact('GetCustomerList', 'add', 'edit', 'delete'));
		}else {
			redirect('login');
		}
	}

	public function add_customer(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetAllRoles = call_api_get($auth_key, 'ManageRoles/GetAllRoles');
			$GetAllRoles = json_decode($GetAllRoles, true);

			$property_limit = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
			$trial_period = array(30,60,90,120);

			$this->load->view('v_add_customer', compact('GetAllRoles', 'property_limit', 'trial_period'));
		}else {
			redirect('login');
		}
	}

	public function save_customer(){
		if ($this->session->userdata('auth_key') && $this->input->is_ajax_request()) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();

			$user_id = $this->session->userdata('user_id');
			$params = array();
			$params['country_name'] = "US";
			$params['created_by'] = $user_id;
			$params['customer_email'] = trim($request['email']);
			$params['customer_name'] = trim($request['name']);
			$params['customer_password'] = (isset($request['action']) && $request['action']=="edit") ? "" : $request['password'];
			$params['extra_days'] = trim($request['extra_days']);
			$params['id'] = isset($request['customer_id']) ? $request['customer_id'] : 0;
			$params['ip'] = $this->session->userdata('user_ip');
			$params['no_of_properties'] = trim($request['property_limit']);
			$params['rolename'] = trim($request['role']);
			$params['trial_period'] = trim($request['trial_period']);
			$res = call_api_post($auth_key, "customer/AddUpdateCustomer", $params);

			/*if(isset($request['is_review_customer']) && trim($request['is_review_customer']) == 'on'){
				$is_review_customer = 1;
			}else{
				$is_review_customer = 0;
			}*/
			if($res == 0){
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->set('is_review_customer', $request['identity']);
				$this->RateAndReviewDb->where('user_email', trim($request['email']));
				$this->RateAndReviewDb->update('RR_CustomerDetail');
			}
			echo json_encode(['status' => $res]);
			die();
		} else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	function edit_customer(){
		$customer_id =  $this->uri->segment(2);
		$auth_key = $this->session->userdata('auth_key');
		$GetCustomerById = call_api_get($auth_key, 'customer/GetCustomerById/'.$customer_id);
		$GetCustomerById = json_decode($GetCustomerById, true);

		$GetAllRoles = call_api_get($auth_key, 'ManageRoles/GetAllRoles');
		$GetAllRoles = json_decode($GetAllRoles, true);

		$property_limit = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
		$trial_period = array(30,60,90,120);

		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
		$this->RateAndReviewDb->select('is_review_customer');
		$this->RateAndReviewDb->from('RR_CustomerDetail');
		$this->RateAndReviewDb->where('user_status', 1);
		$this->RateAndReviewDb->where('id', $customer_id);
		$is_review_customer = $this->RateAndReviewDb->get();
		$is_review_customer = $is_review_customer->row_array();

		$this->load->view('v_edit_customer', compact('GetCustomerById', 'GetAllRoles', 'property_limit', 'trial_period', 'is_review_customer'));
	}

	public function delete_customer(){
		if ($this->session->userdata('auth_key')) {
			$customer_id = $this->uri->segment(2);
			$auth_key = $this->session->userdata('auth_key');
			$res = call_api_get($auth_key, 'customer/DeleteCustomer/' . $customer_id);

			$GetCustomerList = call_api_get($auth_key, 'customer/GetCustomerList');
			$GetCustomerList = json_decode($GetCustomerList, true);
			$html = "";

			$check_permission = check_permission("Add Customer");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			foreach ($GetCustomerList as $customer) {
				$action = "";
				if ($edit == 1) {
					$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_customer/' . $customer['CustomerId'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>';
				}
				if ($delete == 1) {
					$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_customer(' . $customer['CustomerId'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
				}

				$html .= '<tr>';
				$html .= '<td>' . $customer['Id'] . '</td>';
				$html .= '<td>' . $customer['UserName'] . '</td>';
				$html .= '<td>' . $customer['UserEmail'] . '</td>';
				$html .= '<td>' . $customer['NoOfProperties'] . '</td>';
				$html .= '<td>' . $customer['TrialPeriod'] . '</td>';
				$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
					  </td>';
				$html .= '</tr>';
			}

			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}
}
