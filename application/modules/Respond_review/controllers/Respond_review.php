<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Respond_Review extends MX_Controller
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

			$GetReviewrespondList = $this->GetReviewrespondList('', $user_id, date('Y-m-d'), '');
			$page = "respond_review";
			$this->load->view('v_respond_review', compact('GetReviewrespondList', 'page'));
		} else {
			redirect('login');
		}
	}

	public function GetReviewrespondList($review_id = '', $user_id = '', $date = '', $hotelId = '')
	{
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
		$this->RateAndReviewDb->select('rr.id,rr.responder_id,rr.positive_review,rr.notes,rr.negative_review,rr.positive_description,rr.negative_description,rr.conclusion,rr.total_reviews,rr.is_responded,rr.respond_date,ciw.name as website,ciw.id as website_id,ciw.link,rrcd.user_name as client,rr.client_id,ch.id as hotel_id,rrcd.user_email,ch.hotel_name,rr.created_at,rr.attachments');
		$this->RateAndReviewDb->from('Responded_Reviews rr');
		$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = rr.website_id', 'left');
		$this->RateAndReviewDb->join('RR_customer as rrc', 'rrc.user_id = rr.client_id', 'left');
		$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = rrc.user_id', 'left');
		$this->RateAndReviewDb->join('client_hotels as ch', 'ch.id = rr.hotel_id', 'left');
		if($user_id != '') {
			$this->RateAndReviewDb->where('rrc.user_id', $user_id);
		}
		if ($review_id != '') {
			$this->RateAndReviewDb->where('rr.id', $review_id);
		}
		if ($date != ''){
			$this->RateAndReviewDb->where('rr.respond_date', $date);
		}
		if ($hotelId!='' && $hotelId!="all" && $hotelId!="undefined"){
			$this->RateAndReviewDb->where('ch.id', $hotelId);
		}
		$this->RateAndReviewDb->where('rrcd.user_status', 1);
		$this->RateAndReviewDb->where('rr.is_deleted', 0);
		$this->RateAndReviewDb->order_by('rr.respond_date', 'desc');
		$get_website_data = $this->RateAndReviewDb->get();
		$GetReviewrespondList = $get_website_data->result_array();

		return $GetReviewrespondList;
	}

	public function add_respond()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			// $this->RateAndReviewDb->reset_query();
			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('client_id', $user_id);
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$page = "respond_review";
			$this->load->view('v_add_respond', compact('GetAllWebsite', 'GetAllhotels', 'page'));
		} else {
			redirect('login');
		}
	}

	public function add_conclusion()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			// $this->RateAndReviewDb->reset_query();
			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('client_id', $user_id);
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->group_by('id,hotel_name');
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$page = "respond_review";
			$this->load->view('v_add_conclusion', compact('GetAllhotels', 'page'));
		} else {
			redirect('login');
		}
	}

	public function save_respond()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$respond_id = '';
			if (isset($request['id'])) {
				$respond_id = $request['id'];
			}
			$user_id = $this->session->userdata('user_id');

//			$website = (int)$request['website'];
//			$hotel_id = $request['hotel_name'];
			$client_id = (isset($request['customer']) && $request['customer']!="undefined") ? $request['customer'] : $user_id;
			$respond_date = $request['respond_date'];
			$total_added_hotels = $request['total_added_hotels'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $client_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$username = $this->RateAndReviewDb->get();
			$username = $username->row_array();
			$user_name = $username['user_name'];
			$date = date('m_d_Y',strtotime($request['respond_date']));

			$attachments = array();
			if (isset($_FILES['files'])) {
				$countfiles = count($_FILES['files']['name']);
				for ($i = 0; $i < $countfiles; $i++) {
					if (!empty($_FILES['files']['name'][$i])) {
						$dir_path = FCPATH . 'assets/respond_attachments';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}
						$file_ext = pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
						$file_name = 'Review_'.$user_name.'_'.$date.'_'.time().".".$file_ext;
						move_uploaded_file($_FILES['files']['tmp_name'][$i], $dir_path . '/' . $file_name);
						array_push($attachments, $file_name);
					}
				}
			}

			$errors = array();
			$success = array();
			for($i=1; $i<$total_added_hotels; $i++) {
				$hotel_id = $request['hotel_id_' . $i];
				$hotel_name = $request['hotel_name_' . $i];
				$website_id = $request['website_id_' . $i];
				$website_name = $request['website_name_' . $i];

				if ($hotel_id != "" && $hotel_name != "" && $website_id != "" && $website_name != "") {
					$this->RateAndReviewDb->where('client_id', $client_id);
					$this->RateAndReviewDb->where('website_id', $website_id);
					$this->RateAndReviewDb->where('hotel_id', $hotel_id);
					$this->RateAndReviewDb->where('respond_date', $respond_date);
					$this->RateAndReviewDb->where('is_deleted', 0);
					if ($respond_id != '') {
						$this->RateAndReviewDb->where('id', $respond_id);
					}
					$this->RateAndReviewDb->where('responder_id', $user_id);
					$this->RateAndReviewDb->from('Responded_Reviews');
					$get_response_data = $this->RateAndReviewDb->get();
					$exist = false;
					if ((!empty($get_response_data->row_array()) && count($get_response_data->row_array()) > 0)) {
						$exist = true;
					}

					if ($respond_id == '' && $exist) {
						array_push($errors, 'For ' . $hotel_name . ' hotel on ' . $website_name . ' website, Review respond record already added on this date. please select another.');
					} elseif (($respond_id == '' && !$exist) || ($respond_id != '' && !$exist)) {
						$params['positive_review'] = $request['positive_review'];
						$params['negative_review'] = $request['negative_review'];
						$params['total_reviews'] = $request['total_review'];
						$params['notes'] = $request['notes'];
						$params['hotel_id'] = $hotel_id;
						$params['client_id'] = $client_id;
						$params['Website_id'] = $website_id;
						$params['is_responded'] = $request['is_responded'];
						$params['respond_date'] = $request['respond_date'];
						$params['positive_description'] = $request['positive_description'];
						$params['negative_description'] = $request['negative_description'];
						$params['responder_id'] = $user_id;
						$params['ip'] = $this->session->userdata('user_ip');
						$params['created_at'] = date("Y-m-d H:i:s");
						$params['attachments'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";
						$AddUpdateCred = $this->RateAndReviewDb->insert('Responded_Reviews', $params);

						array_push($success, 'For ' . $hotel_name . ' hotel on ' . $website_name . ' website, Respond added successfully.');
					} elseif ($respond_id != '' && $exist) {
						$params['positive_review'] = $request['positive_review'];
						$params['negative_review'] = $request['negative_review'];
						$params['total_reviews'] = $request['total_review'];
						$params['is_responded'] = $request['is_responded'];
						$params['respond_date'] = $request['respond_date'];
						$params['positive_description'] = $request['positive_description'];
						$params['negative_description'] = $request['negative_description'];
						$params['updated_by'] = $user_id;
						$params['ip'] = $this->session->userdata('user_ip');
						$params['updated_at'] = date("Y-m-d H:i:s");
						$this->RateAndReviewDb->where('id', $respond_id);
						$AddUpdatecredentials = $this->RateAndReviewDb->update('Responded_Reviews', $params);
					}
				}
			}

			echo json_encode(['status' => 1, 'errors' => $errors, 'success' => $success]);
			exit;
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function update_respond(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$respond_id = '';
			if (isset($request['id'])) {
				$respond_id = $request['id'];
			}
			$user_id = $this->session->userdata('user_id');

			$client_id = (isset($request['customer']) && $request['customer']!="undefined") ? $request['customer'] : $user_id;
			$respond_date = $request['respond_date'];
			$hotel_id = $request['hotel_name'];
			$website_id = $request['website'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $client_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$username = $this->RateAndReviewDb->get();
			$username = $username->row_array();
			$user_name = $username['user_name'];
			$date = date('m_d_Y',strtotime($request['respond_date']));

			$this->RateAndReviewDb->where('client_id', $client_id);
			$this->RateAndReviewDb->where('website_id', $website_id);
			$this->RateAndReviewDb->where('hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('respond_date', $respond_date);
			$this->RateAndReviewDb->where('is_deleted', 0);
			if ($respond_id != '') {
				$this->RateAndReviewDb->where('id', $respond_id);
			}
			$this->RateAndReviewDb->where('responder_id', $user_id);
			$this->RateAndReviewDb->from('Responded_Reviews');
			$get_response_data = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($get_response_data->row_array()) && count($get_response_data->row_array()) > 0)) {
				$exist = true;
			}

			if ($respond_id == '' && $exist) {
				echo json_encode(['status' => 0, 'error' => 'Review respond record already added on this date.']);
				die();
			}
			elseif (($respond_id == '' && !$exist) || ($respond_id != '' && !$exist)) {
				$params['positive_review'] = $request['positive_review'];
				$params['negative_review'] = $request['negative_review'];
				$params['total_reviews'] = $request['total_review'];
				$params['notes'] = $request['notes'];
				$params['hotel_id'] = $hotel_id;
				$params['client_id'] = $client_id;
				$params['Website_id'] = $website_id;
				$params['is_responded'] = $request['is_responded'];
				$params['respond_date'] = $request['respond_date'];
				$params['positive_description'] = $request['positive_description'];
				$params['negative_description'] = $request['negative_description'];
				$params['responder_id'] = $user_id;
				$params['ip'] = $this->session->userdata('user_ip');
				$params['created_at'] = date("Y-m-d H:i:s");
				$AddUpdate = $this->RateAndReviewDb->insert('Responded_Reviews', $params);

				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			}
			elseif ($respond_id != '' && $exist) {
				$attachments = array();
				if (isset($_FILES['files'])) {
					$countfiles = count($_FILES['files']['name']);
					for ($i = 0; $i < $countfiles; $i++) {
						if (!empty($_FILES['files']['name'][$i])) {
							$dir_path = FCPATH . 'assets/respond_attachments';
							if (!is_dir($dir_path)) {
								mkdir($dir_path, 0777, TRUE);
							}
							$file_ext = pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
							$file_name = 'Review_'.$user_name.'_'.$date.'_'.time().".".$file_ext;
							move_uploaded_file($_FILES['files']['tmp_name'][$i], $dir_path . '/' . $file_name);
							array_push($attachments, $file_name);
						}
					}
				}

				$db_attachments = (isset($request['attachments']) && $request['attachments']!="") ? explode(",",$request['attachments']) : "";
				$dir_path = FCPATH . 'assets/respond_attachments';
				if (isset($request['old_images']) && !empty($request['old_images'])){
					$old_images = $request['old_images'];
					$attachments = array_merge($attachments, $old_images);

					if ($db_attachments!="") {
						foreach ($db_attachments as $img) {
							if (!in_array($img, $old_images) && file_exists($dir_path . '/' . $img)) {
								unlink($dir_path . '/' . $img);
							}
						}
					}
				}
				else {
					if ($db_attachments!="") {
						foreach ($db_attachments as $img) {
							if (file_exists($dir_path . '/' . $img)) {
								unlink($dir_path . '/' . $img);
							}
						}
					}
				}

				$params['positive_review'] = $request['positive_review'];
				$params['negative_review'] = $request['negative_review'];
				$params['total_reviews'] = $request['total_review'];
				$params['notes'] = $request['notes'];
				$params['is_responded'] = $request['is_responded'];
				$params['respond_date'] = $request['respond_date'];
				$params['positive_description'] = $request['positive_description'];
				$params['negative_description'] = $request['negative_description'];
				$params['updated_by'] = $user_id;
				$params['ip'] = $this->session->userdata('user_ip');
				$params['updated_at'] = date("Y-m-d H:i:s");
				$params['attachments'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";

				$this->RateAndReviewDb->where('id', $respond_id);
				$AddUpdate = $this->RateAndReviewDb->update('Responded_Reviews', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			}
			else {
				echo json_encode(['status' => 'error', 'error' => 'Something went wrong!!']);
				die();
			}
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function delete_respond()
	{
		if ($this->session->userdata('auth_key')) {
			$resp_id = $this->input->post('review_id');
			$user_id = $this->input->post('user_id');
			$date = $this->input->post('date');
			$hotelId = $this->input->post('hotelId');
			if ($user_id == "" || $user_id == "undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $resp_id);
			$res = $this->RateAndReviewDb->update('Responded_Reviews', array('is_deleted' => 1));

			$html = $this->get_respondlist_html($user_id, $date, $hotelId);
			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_client_respondlist()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->input->post('userId');
			if ($user_id=="" || $user_id=="undefined"){
				$user_id = $this->session->userdata('user_id');
			}
			$date = $this->input->post('date');
			$hotelId = $this->input->post('hotelId');
			$html = $this->get_respondlist_html($user_id, $date, $hotelId);
			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_respondlist_html($user_id = '', $date = '', $hotelId = '')
	{
		$GetReviewrespondList = $this->GetReviewrespondList('', $user_id, $date, $hotelId);

		$html = "";
		foreach ($GetReviewrespondList as $Resp) {
			$html .= '<tr>';
			$html .= '<td>' . $Resp['website'] . '</td>';
			$html .= '<td>' . $Resp['hotel_name'] . '</td>';
			$html .= '<td>' . $Resp['is_responded'] . '</td>';
			$html .= '<td>' . $Resp['positive_review'] . '</td>';
			$html .= '<td>' . $Resp['negative_review'] . '</td>';
			$html .= '<td>' . $Resp['total_reviews'] . '</td>';
			$html .= '<td>' . $Resp['link'] . '</td>';
			$html .= '<td>' . $Resp['respond_date'] . '</td>';
			$html .= '<td>' . $Resp['created_at'] . '</td>';

			$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">	
							<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_respond/' . $Resp['id'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>						
							<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_responded_review(' . $Resp['id'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>
						</ul>
					</td>';
			$html .= '</tr>';
		}
		return $html;
	}

	public function edit_respond()
	{
		$respond_id =  $this->uri->segment(2);

		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetReviewrespondList = $this->GetReviewrespondList($respond_id, '', '', '');

			// $this->RateAndReviewDb->reset_query();
			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$respond = $GetReviewrespondList[0];
			$page = "respond_review";
			$this->load->view('v_edit_respond', compact('GetAllWebsite', 'GetAllhotels', 'respond', 'page'));
		} else {
			redirect('login');
		}
	}

	public function save_conclusion()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$conclusion_id = '';
			if (isset($request['id'])) {
				$conclusion_id = $request['id'];
			}
			$user_id = $this->session->userdata('user_id');
			$hotel_id = $request['hotel_name'];
			$client_id = (isset($request['customer']) && $request['customer']!="undefined") ? $request['customer'] : $user_id;
			$respond_date = $request['respond_date'];

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->where('ch.client_id', $client_id);
			$this->RateAndReviewDb->where('rc.hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('rc.date', date('Y-m-d', strtotime($respond_date)));
			$this->RateAndReviewDb->where('rc.is_deleted', 0);
			if ($conclusion_id != '') {
				$this->RateAndReviewDb->where('rc.id', $conclusion_id);
			}
			$this->RateAndReviewDb->from('Review_Conclusion rc');
			$this->RateAndReviewDb->join('client_hotels as ch', 'ch.id = rc.hotel_id', 'left');
			$get_response_data = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($get_response_data->row_array()) && count($get_response_data->row_array()) > 0)) {
				$exist = true;
			}

			$status = 'error';
			if ($conclusion_id == '' && $exist) {
				echo json_encode(['status' => 0, 'error' => 'Conclusion record already added on this date.']);
				die();
			} elseif (($conclusion_id == '' && !$exist) || ($conclusion_id != '' && !$exist)) {
				$params['hotel_id'] = $request['hotel_name'];
				$params['conclusion'] = $request['conclusion'];
				$params['date'] = $request['respond_date'];

				$AddUpdate = $this->RateAndReviewDb->insert('Review_Conclusion', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} elseif ($conclusion_id != '' && $exist) {
				$params['conclusion'] = $request['conclusion'];

				$this->RateAndReviewDb->where('id', $conclusion_id);
				$AddUpdate = $this->RateAndReviewDb->update('Review_Conclusion', $params);

				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} else {
				echo json_encode(['status' => 'error', 'error' => 'Something went wrong']);
				die();
			}
		} else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function conclusion(){
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}

			$conclusions = $this->GetConclusionList('', $user_id, date('Y-m-d'), '');

			$page = "respond_review";
			$this->load->view('v_conclusion', compact('conclusions', 'page'));
		}
		else {
			redirect('login');
		}
	}

	public function edit_conclusion() {
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$conclusion_id = $this->uri->segment(2);

			$conclusions = $this->GetConclusionList($conclusion_id, '', '', '');
			$conclusion = $conclusions[0];

			$page = "respond_review";
			$this->load->view('v_edit_conclusion', compact('page', 'conclusion'));
		} else {
			redirect('login');
		}
	}

	public function delete_conclusion(){
		if ($this->session->userdata('auth_key')) {
			$conclusion_id = $this->input->post('conclusionId');
			$user_id = $this->input->post('userId');
			$date = $this->input->post('date');
			$hotelId = $this->input->post('hotelId');
			if ($user_id == "" || $user_id == "undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $conclusion_id);
			$res = $this->RateAndReviewDb->update('Review_Conclusion', array('is_deleted' => 1));

			$html = $this->get_conclusionlist_html($user_id, $date, $hotelId);
			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_conclusionlist_html($user_id = '', $date = '', $hotelId = '')
	{
		$GetConclusionList = $this->GetConclusionList('', $user_id, $date, $hotelId);

		$html = "";
		if (isset($GetConclusionList) && !empty($GetConclusionList)) {
			foreach ($GetConclusionList as $conclusion) {
				$html .= '<tr>';
				$html .= '<td>' . $conclusion['hotel_name'] . '</td>';
				$html .= '<td>' . $conclusion['date'] . '</td>';
				$html .= '<td>' . $conclusion['conclusion'] . '</td>';

				$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">	
							<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_conclusion/' . $conclusion['id'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>						
							<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_conclusion(' . $conclusion['id'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>
						</ul>
					</td>';
				$html .= '</tr>';
			}
		}

		return $html;
	}

	public function GetConclusionList($conclusion_id = '', $user_id = '', $date = '', $hotelId = '')
	{
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

		$this->RateAndReviewDb->select('ch.hotel_name, rc.date, rc.conclusion, rc.id, ch.client_id, rc.hotel_id');
		$this->RateAndReviewDb->from('Review_Conclusion rc');
		$this->RateAndReviewDb->join('client_hotels as ch', 'ch.id = rc.hotel_id', 'left');
		if ($user_id != '' && $user_id != "undefined") {
			$this->RateAndReviewDb->where('ch.client_id', $user_id);
		}
		if ($date != '' && $date != "undefined") {
			$this->RateAndReviewDb->where('rc.date', $date);
		}
		if ($hotelId != '' && $hotelId != "all" && $hotelId != "undefined") {
			$this->RateAndReviewDb->where('rc.hotel_id', $hotelId);
		}
		if ($conclusion_id != '') {
			$this->RateAndReviewDb->where('rc.id', $conclusion_id);
		}
		$this->RateAndReviewDb->where('rc.is_deleted', 0);
		$conclusions = $this->RateAndReviewDb->get();
		$conclusions = $conclusions->result_array();

		return $conclusions;
	}

	public function filter_conclusions() {
		$user_id = $this->input->post('userId');
		$date = $this->input->post('date');
		$hotelId = $this->input->post('hotelId');

		if ($this->session->userdata('auth_key')) {
			if ($user_id == "" || $user_id == "undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$html = $this->get_conclusionlist_html($user_id, $date, $hotelId);
			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
