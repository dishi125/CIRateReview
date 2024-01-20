<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_website extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$route = $this->uri->segment(2);
			$type = "Website";
			$getwebsiteList = $this->getwebsiteList();
			$page = "manage_website";
			$this->load->view('v_manage_website', compact('getwebsiteList', 'type', 'page'));
		}else {
			redirect('login');
		}
	}

	public function getwebsiteList(){
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

		$this->RateAndReviewDb->select('ciw.id,ciw.name as website,ciw.link');
		$this->RateAndReviewDb->from('ci_websites ciw');
		$this->RateAndReviewDb->where('ciw.is_deleted',0);

		$get_website_data = $this->RateAndReviewDb->get();
		$getwebsiteList = $get_website_data->result_array();
		return $getwebsiteList;
	}

	public function add_website(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$type = 'website';
			$page = "manage_website";
			$this->load->view('v_add_website', compact('type', 'page'));
		}else {
			redirect('login');
		}
	}


	public function save_website(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();

			$id = '';
			if (isset($request['id'])) {
				$id = $request['id'];
			}

			$website = $request['website'];
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('id');
			$this->RateAndReviewDb->from('ci_websites ciw');
			$this->RateAndReviewDb->where('ciw.name', $website);
			if ($id != '') {
				$this->RateAndReviewDb->where('id !=', $id);
			}
			$this->RateAndReviewDb->where('ciw.is_deleted', 0);
			$get_website_data = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($get_website_data->row_array()) && count($get_website_data->row_array()) > 0)) {
				$exist = true;
			}

			$status = 'error';
			if ($exist) {
				echo json_encode(['status' => 0, 'error' => 'this website is already added']);
				die();
			}
			elseif ($id == '' && !$exist) {
				$params['name'] = $request['website'];
				$params['link'] = $request['link'];
				$params['created_id'] = $this->session->userdata('user_id');
				$params['created_date'] = date("Y-m-d H:i:s");
				$AddUpdate = $this->RateAndReviewDb->insert('ci_websites', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			}
			elseif ($id != '' && !$exist) {
				$params['name'] = $request['website'];
				$params['link'] = $request['link'];
				$params['updated_id'] = $this->session->userdata('user_id');
				$params['update_date'] = date("Y-m-d H:i:s");
				$this->RateAndReviewDb->where('id', $id);
				$AddUpdate = $this->RateAndReviewDb->update('ci_websites', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			}
			else {
				echo json_encode(['status' => 'error', 'error' => 'Something went wrong']);
				die();
			}
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function delete_website(){
		if ($this->session->userdata('auth_key')) {
			$website_id = $this->uri->segment(2);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $website_id);
			$res = $this->RateAndReviewDb->update('ci_websites', array('is_deleted' => 1));

			$getwebsiteList = $this->getwebsiteList();

			$html = "";
			foreach ($getwebsiteList as $website) {
				$html .= '<tr>';
				$html .= '<td>' . $website['id'] . '</td>';
				$html .= '<td>' . $website['website'] . '</td>';
				$html .= '<td>' . $website['link'] . '</td>';

				$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">
							<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="'.base_url('edit_website/'.$website['id']).'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>
							<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_website(' . $website['id'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>
						</ul>
					</td>';
				$html .= '</tr>';
			}

			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function edit_website(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$website_id = $this->uri->segment(2);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->where('id',$website_id);
			$get_website_data = $this->RateAndReviewDb->get();
			$website = $get_website_data->row_array();

			$page = "manage_website";
			$this->load->view('v_edit_website', compact('page', 'website'));
		}
		else {
			redirect('login');
		}
	}

}
