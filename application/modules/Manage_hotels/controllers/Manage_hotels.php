<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_hotels extends MX_Controller  {
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

			$GetHotelList = $this->getHotelList($user_id, '');
			$page = "manage_hotels";
			$this->load->view('v_manage_hotels', compact('GetHotelList', 'page'));
		}else {
			redirect('login');
		}
	}

	public function getHotelList($user_id='', $hotel_id=''){
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

		$this->RateAndReviewDb->select('ch.id,ch.hotel_name,ch.email,ch.copy_recipients,ch.state,ch.city as city_id,tblc.city,ch.address,ch.image,ch.logo,ch.client_id,rrcd.user_name,rrcd.user_email,ch.hotel_code');
		$this->RateAndReviewDb->from('client_hotels ch');
		$this->RateAndReviewDb->join('RR_customer as rrc', 'rrc.user_id = ch.client_id', 'left');
		$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = rrc.user_id', 'left');
		$this->RateAndReviewDb->join('tbl_usa_cities as tblc', 'tblc.city_id = ch.city', 'left');
		if ($user_id != '') {
			$this->RateAndReviewDb->where('rrc.user_id', $user_id);
		}
		if ($hotel_id != '') {
			$this->RateAndReviewDb->where('ch.id', $hotel_id);
		}
		$this->RateAndReviewDb->where('rrcd.user_status',1);
		$this->RateAndReviewDb->where('ch.is_deleted',0);

		$get_website_data = $this->RateAndReviewDb->get();
		$GetHotelList = $get_website_data->result_array();
		return $GetHotelList;
	}

	public function add_hotels(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$GetAllState = call_api_get($auth_key, 'hotel/GetAllState');
			$GetAllState = json_decode($GetAllState, true);

			$page = "manage_hotels";
			$this->load->view('v_add_hotels', compact('GetAllWebsite', 'GetAllState', 'page'));
		}else {
			redirect('login');
		}
	}

	public function edit_hotels(){
		if ($this->session->userdata('auth_key')) {
			$hotel_id =  $this->uri->segment(2);

			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$GetAllState = call_api_get($auth_key, 'hotel/GetAllState');
			$GetAllState = json_decode($GetAllState, true);

			$GetHotelList = $this->getHotelList('', $hotel_id);

			$GetAllCityByState = call_api_get($auth_key, 'hotel/GetAllCityByState/' .  $GetHotelList[0]['state']);
			$GetAllCityByState = json_decode($GetAllCityByState, true);

			$page = "manage_hotels";
			$this->load->view('v_edit_hotels', compact('GetAllWebsite', 'GetAllState', 'page', 'GetHotelList', 'GetAllCityByState'));
		}else {
			redirect('login');
		}
	}

	public function save_clients_hotel(){
//		print_r($_FILES["cover_image"]);
//		die();
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$hotel_id = '';

			$request = $this->input->post();
			if (isset($request['id'])) {
				$hotel_id = $request['id'];
			}
			$hotel_name = $request['hotel_name'];
			$client_id = (isset($request['customer']) && $request['customer']!="undefined") ? $request['customer'] : $this->session->userdata('user_id');

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('image, logo');
			$this->RateAndReviewDb->from('client_hotels');
			$this->RateAndReviewDb->where('client_id', $client_id);
			$this->RateAndReviewDb->where('hotel_name', $hotel_name, 'both');
			$this->RateAndReviewDb->where('is_deleted', 0);
			if ($hotel_id != '') {
				$this->RateAndReviewDb->where('id', $hotel_id);
			}
			$get_hotels_data = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($get_hotels_data->row_array()) && count($get_hotels_data->row_array()) > 0)) {
				$exist = true;
			}

			$status = 'error';
			if ($hotel_id == '' && $exist) {
				echo json_encode(['status' => 'failed', 'error' => 'Hotel is already added for this website so you can not add more hotels.']);
				die();
			}
			elseif (($hotel_id == '' && !$exist) || ($hotel_id != '' && !$exist)) {
				if (isset($_FILES['cover_image'])) {
					if (!empty($_FILES['cover_image']['name'])) {
						$dir_path = FCPATH . 'assets/hotel_cover_picture';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}

						$file_ext = pathinfo($_FILES["cover_image"]["name"], PATHINFO_EXTENSION);
						$file_name = mt_rand(100000, 999999) . time() .".".$file_ext;
						move_uploaded_file($_FILES['cover_image']['tmp_name'], $dir_path . '/' . $file_name);
						$cover_picture = $file_name;
						$params['image'] = $cover_picture;
					}
				}

				if (isset($_FILES['hotel_logo'])) {
					if (!empty($_FILES['hotel_logo']['name'])) {
						$dir_path = FCPATH . 'assets/hotel_logo';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}

						$file_ext = pathinfo($_FILES["hotel_logo"]["name"], PATHINFO_EXTENSION);
						$file_name = mt_rand(100000, 999999) . time() .".".$file_ext;
						move_uploaded_file($_FILES['hotel_logo']['tmp_name'], $dir_path . '/' . $file_name);
						$params['logo'] = $file_name;
					}
				}

				$params['address'] = $request['address'];
				$params['city'] = $request['city'];
				$params['hotel_name'] = $request['hotel_name'];
				$params['State'] = $request['state'];
				$params['client_id'] = $client_id;
				$params['country_name'] = "US";
				$params['created_by'] = $this->session->userdata('user_id');
//				$params['created_at'] = date("Y-m-d H:i:s");
				$params['ip'] = $this->session->userdata('user_ip');
				$params['email'] = trim($request['email']);
				$params['copy_recipients'] = $request['copy_recipients'];
				$params['hotel_code'] = $request['hotel_code'];

				$AddUpdateHotel = $this->RateAndReviewDb->insert('client_hotels', $params);

				if ($AddUpdateHotel) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			}
			elseif ($hotel_id != '' && $exist) {
				if (isset($_FILES['cover_image'])) {
					if (!empty($_FILES['cover_image']['name'])) {
						$dir_path = FCPATH . 'assets/hotel_cover_picture';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}
						$image = $get_hotels_data->row_array();
						if ($image['image']!="") {
							if (file_exists($dir_path . '/' . $image['image'])) {
								unlink($dir_path . '/' . $image['image']);
							}
						}

						$file_ext = pathinfo($_FILES["cover_image"]["name"], PATHINFO_EXTENSION);
						$file_name = mt_rand(100000, 999999) . time() .".".$file_ext;
						move_uploaded_file($_FILES['cover_image']['tmp_name'], $dir_path . '/' . $file_name);
						$cover_picture = $file_name;
						$params['image'] = $cover_picture;
					}
				}

				if (isset($_FILES['hotel_logo'])) {
					if (!empty($_FILES['hotel_logo']['name'])) {
						$dir_path = FCPATH . 'assets/hotel_logo';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}
						$image = $get_hotels_data->row_array();
						if ($image['logo']!="") {
							if (file_exists($dir_path . '/' . $image['logo'])) {
								unlink($dir_path . '/' . $image['logo']);
							}
						}

						$file_ext = pathinfo($_FILES["hotel_logo"]["name"], PATHINFO_EXTENSION);
						$file_name = mt_rand(100000, 999999) . time() .".".$file_ext;
						move_uploaded_file($_FILES['hotel_logo']['tmp_name'], $dir_path . '/' . $file_name);
						$params['logo'] = $file_name;
					}
				}

				$params['address'] = $request['address'];
				$params['city'] = $request['city'];
				$params['State'] = $request['state'];
				$params['email'] = trim($request['email']);
				$params['copy_recipients'] = $request['copy_recipients'];
				$params['updated_by'] = $this->session->userdata('user_id');
				$params['ip'] = $this->session->userdata('user_ip');
				$params['updated_date'] = date("Y-m-d H:i:s");
				$params['hotel_code'] = $request['hotel_code'];

				$this->RateAndReviewDb->where('id', $hotel_id);
				$updateHotel = $this->RateAndReviewDb->update('client_hotels', $params);
				if ($updateHotel) {
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
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_client_hotellist_html($userid=''){
		$GetHotelList = $this->getHotelList($userid, '');
		
		$html = "";
		foreach ($GetHotelList as $Hotel){
			$html .= '<tr>';
			// $html .= '<td>'.$Hotel['user_name'].'</td>';
//			$html .= '<td>'.$Hotel['website'].'</td>';
			$html .= '<td>'.$Hotel['hotel_name'].'</td>';
//			$html .= '<td>'.$Hotel['link'].'</td>';
			$html .= '<td>'.$Hotel['state'].'</td>';
			$html .= '<td>'.$Hotel['city'].'</td>';
			// $html .= '<td>'.$Hotel['user_email'].'</td>';
			//'.base_url().'edit_Hotel/'.$Hotel['id'].'
			$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">
							<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="'.base_url('edit_hotels/'.$Hotel['id']).'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>
							<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel('.$Hotel['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>
						</ul>
					</td>';
			$html .= '</tr>';
		}
		return $html;
	}

	public function delete_client_hotel(){
		if ($this->session->userdata('auth_key')) {
			$hotel_id = $this->input->post('HotelId');
			$user_id = $this->input->post('userId');

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $hotel_id);
			$res = $this->RateAndReviewDb->update('client_hotels', array('is_deleted' => 1));

			if ($user_id=="" || $user_id=="undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$html = $this->get_client_hotellist_html($user_id);

			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_client_hotellist(){
		if ($this->session->userdata('auth_key')) {
			$userid = $this->uri->segment(2);

			if ($userid=="" || $userid=="undefined" || $userid=="null") {
				$userid = $this->session->userdata('user_id');
			}

			$html = $this->get_client_hotellist_html($userid);

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
