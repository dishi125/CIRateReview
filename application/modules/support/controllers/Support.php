<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('v_add_support');
	}

	public function save_support(){
		$request = $this->input->post();

		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

		$params['username'] = trim($request['username']);
		$params['email'] = trim($request['user_email']);
		$params['problem_type'] = trim($request['problem_type']);
		$params['reported_problem'] = trim($request['reported_problem']);
		$params['subject'] = trim($request['subject']);
		$params['message'] = trim($request['message']);
		$params['is_resolved'] = 0;
		$params['status'] = "draft";
		$Add = $this->RateAndReviewDb->insert('support', $params);

		echo json_encode(['status' => 1]);
		die();
	}

	public function list_support(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('support');
			$get_support_data = $this->RateAndReviewDb->get();
			$getsupportList = $get_support_data->result_array();

			$this->load->view('v_support_list', compact('getsupportList'));
		}
		else {
			redirect('login');
		}
	}

	public function support_details(){
		$request = $this->input->post();
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('id',$request['support_id']);
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('support');
			$get_support_data = $this->RateAndReviewDb->get();
			$getsupport = $get_support_data->row_array();

			echo json_encode(['status' => 1, 'support_details' => $getsupport]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			die();
		}
	}

	public function update_support(){
		$request = $this->input->post();
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$params['status'] = $request['status'];
			$this->RateAndReviewDb->where('id', $request['support_id']);
			$update = $this->RateAndReviewDb->update('support', $params);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('support');
			$get_support_data = $this->RateAndReviewDb->get();
			$getsupportList = $get_support_data->result_array();
			$html = "";
			if(isset($getsupportList)) {
				foreach ($getsupportList as $support){
					$html .= '<tr>
									<td>'.$support['id'].'</td>
									<td>'.$support['username'].'</td>
									<td>'.$support['email'].'</td>
									<td>'.$support['problem_type'].'</td>
									<td>'.$support['reported_problem'].'</td>
									<td>'.$support['subject'].'</td>
									<td>'.$support['message'].'</td>
									<td>'.$support['status'].'</td>
									<td>
										<ul class="list-inline hstack gap-2 mb-0">
											<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
												<a class="text-primary d-inline-block edit-item-btn" onclick="edit_support('.$support['id'].')"><i class="ri-pencil-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
												<a class="text-danger d-inline-block remove-item-btn" onclick="delete_support('.$support['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
											</li>
										</ul>
									</td>
								</tr>';
				}
			}
			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			die();
		}
	}

	public function delete_support(){
		$support_id = $this->uri->segment(2);
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $support_id);
			$res = $this->RateAndReviewDb->update('support', array('is_deleted' => 1));

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('support');
			$get_support_data = $this->RateAndReviewDb->get();
			$getsupportList = $get_support_data->result_array();
			$html = "";
			if(isset($getsupportList)) {
				foreach ($getsupportList as $support){
					$html .= '<tr>
									<td>'.$support['id'].'</td>
									<td>'.$support['username'].'</td>
									<td>'.$support['email'].'</td>
									<td>'.$support['problem_type'].'</td>
									<td>'.$support['reported_problem'].'</td>
									<td>'.$support['subject'].'</td>
									<td>'.$support['message'].'</td>
									<td>'.$support['status'].'</td>
									<td>
										<ul class="list-inline hstack gap-2 mb-0">
											<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
												<a class="text-primary d-inline-block edit-item-btn" onclick="edit_support('.$support['id'].')"><i class="ri-pencil-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
												<a class="text-danger d-inline-block remove-item-btn" onclick="delete_support('.$support['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
											</li>
										</ul>
									</td>
								</tr>';
				}
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
