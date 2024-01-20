<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_code extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}
			$check_permission = check_permission("Manage Property");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('HotelCode, PropertyName, id');
			$this->RateAndReviewDb->from('RR_Property');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$Property_codes = $this->RateAndReviewDb->get();
			$Property_codes = $Property_codes->result_array();

			$this->load->view('v_property_code', compact('add', 'edit', 'delete', 'Property_codes'));
		}else {
			redirect('login');
		}
	}

	public function add_property(){
		if ($this->session->userdata('auth_key')) {
			$this->load->view('v_add_property_code');
		}else {
			redirect('login');
		}
	}

	public function save_property(){
		if ($this->session->userdata('auth_key')) {
			$request = $this->input->post();
			$user_id = $this->session->userdata('user_id');
			if (isset($request['user_id']) && $request['user_id'] != "" && $request['user_id'] != "undefined"){
				$user_id = (int)$request['user_id'];
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$data = array(
				'PropertyName'=>$request['PropertyName'],
				'HotelCode'=>$request['HotelCode'],
				'UserId'=>$user_id
			);

			if (isset($request['id']) && $request['id']!=""){
				$this->RateAndReviewDb->update('RR_Property',$data,array('id' => $request['id']));
			} else {
				$this->RateAndReviewDb->insert('RR_Property',$data);
			}

			echo json_encode(['status' => 1]);
			die();
		}else {
			echo json_encode(['status' => 0]);
			die();
		}
	}

	public function edit_property(){
		$id =  $this->uri->segment(2);
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('HotelCode, PropertyName, id');
			$this->RateAndReviewDb->from('RR_Property');
			$this->RateAndReviewDb->where('id', $id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$Property_code = $this->RateAndReviewDb->get();
			$Property_code = $Property_code->row_array();

			$this->load->view('v_edit_property_code', compact('Property_code'));
		}else {
			redirect('login');
		}
	}

	public function delete_property(){
		$property_id =  $this->uri->segment(2);
		$user_id =  $this->uri->segment(3);
		$auth_key = $this->session->userdata('auth_key');
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->delete('RR_Property', array('id' => $property_id));

			if ($user_id == "" || $user_id == "null") {
				$user_id = $this->session->userdata('user_id');
			}

			$check_permission = check_permission("Manage Property");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('HotelCode, PropertyName, id');
			$this->RateAndReviewDb->from('RR_Property');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$Property_codes = $this->RateAndReviewDb->get();
			$Property_codes = $Property_codes->result_array();
			$html = "";
			if(isset($Property_codes) && !empty($Property_codes)) {
				foreach ($Property_codes as $Property_code) {
					$action = "";
					if ($edit == 1) {
						$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
									<a href="' . base_url() . 'edit_property/' . $Property_code['id'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
								</li>';
					}
					if ($delete == 1) {
						$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_property(' . $Property_code['id'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
					}

					$html .= '<tr>';
					$html .= '<td>' . $Property_code['PropertyName'] . '</td>';
					$html .= '<td>' . $Property_code['HotelCode'] . '</td>';
					$html .= '<td>
								<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
							</td>';
					$html .= '</tr>';
				}
			}
			else {
				$html .= '<tr>
							<td colspan="3" style="text-align: center">No records found</td>
						</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		} else {
			echo json_encode(['status' => 0]);
			die();
		}
	}

	public function filter_property(){
		$user_id =  $this->uri->segment(2);
		$auth_key = $this->session->userdata('auth_key');
		if ($this->session->userdata('auth_key')) {
			if ($user_id == "" || $user_id == "null") {
				$user_id = $this->session->userdata('user_id');
			}

			$check_permission = check_permission("Manage Property");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('HotelCode, PropertyName, id');
			$this->RateAndReviewDb->from('RR_Property');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$Property_codes = $this->RateAndReviewDb->get();
			$Property_codes = $Property_codes->result_array();
			$html = "";
			if(isset($Property_codes) && !empty($Property_codes)) {
				foreach ($Property_codes as $Property_code) {
					$action = "";
					if ($edit == 1) {
						$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
									<a href="' . base_url() . 'edit_property/' . $Property_code['id'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
								</li>';
					}
					if ($delete == 1) {
						$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_property(' . $Property_code['id'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
					}

					$html .= '<tr>';
					$html .= '<td>' . $Property_code['PropertyName'] . '</td>';
					$html .= '<td>' . $Property_code['HotelCode'] . '</td>';
					$html .= '<td>
								<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
							</td>';
					$html .= '</tr>';
				}
			}
			else {
				$html .= '<tr>
							<td colspan="3" style="text-align: center">No records found</td>
						</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		} else {
			echo json_encode(['status' => 0]);
			die();
		}
	}
}
