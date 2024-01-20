<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends MX_Controller  {

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
			$route = $this->uri->segment(2);
			$own_hotel_code = $this->session->userdata('own_hotel_code');
			if ($route == "hotel"){
				$url = 'hotel/GetHotelList/false/'.$user_id.'/'.$own_hotel_code;
				$type = "Hotel";
				$check_permission = check_permission("Add your hotel");
			}
			else{
				$url = 'hotel/GetHotelList/true/'.$user_id.'/'.$own_hotel_code;
				$type = "Competitor Hotel";
				$check_permission = check_permission("Add Competitor’s Hotel");
			}
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$GetHotelList = call_api_get($auth_key, $url);
			if ($GetHotelList!="") {
				$GetHotelList = json_decode($GetHotelList, true);
			}
			/*echo "<pre>";
			print_r($GetHotelList);
			echo "</pre>";
			die();*/
			$this->load->view('v_hotel', compact('GetHotelList', 'type', 'add', 'edit', 'delete'));
		}else {
			redirect('login');
		}
	}

	public function add_hotel(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}
			$type = str_replace("%20"," ", $this->uri->segment(2));

			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			$GetAllWebsite = json_decode($GetAllWebsite, true);

			$GetAllState = call_api_get($auth_key, 'hotel/GetAllState');
			$GetAllState = json_decode($GetAllState, true);

			$GetUsers = call_api_get($auth_key, 'Customer/GetUsers');
			$GetUsers = json_decode($GetUsers, true);

			$GetMappedRoomType = call_api_get($auth_key, 'hotel/GetMappedRoomType');
			$GetMappedRoomType = json_decode($GetMappedRoomType, true);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			/*$this->RateAndReviewDb->select('HotelCode, PropertyName');
			$this->RateAndReviewDb->from('RR_Property');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$Property_codes = $this->RateAndReviewDb->get();
			$Property_codes = $Property_codes->result_array();*/

			$own_hotels = array();
			if ($type=="Competitor Hotel") {
				$this->RateAndReviewDb->select('MappedHotelName, HotelCode');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsDelete', 0);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
				$own_hotels = $this->RateAndReviewDb->get();
				$own_hotels = $own_hotels->result_array();
				$MappedHotelNames = array_column($own_hotels, 'MappedHotelName');
				$MappedHotelNames = array_unique($MappedHotelNames);
				$own_hotels = array_filter($own_hotels, function ($key, $value) use ($MappedHotelNames) {
					return in_array($value, array_keys($MappedHotelNames));
				}, ARRAY_FILTER_USE_BOTH);
			}

			$this->load->view('v_add_hotel', compact('type', 'GetAllWebsite', 'GetAllState', 'GetUsers', 'GetMappedRoomType', 'own_hotels'));
		}else {
			redirect('login');
		}
	}

	public function getAddress_RoomTypes(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$hotel_id = $this->input->post('hotel_id');
			$website_id = $this->input->post('website_id');
			$state_name = $this->input->post('state_name');
			$city_id = $this->input->post('city_id');

			$GetHotelAddressByHotelId = call_api_get($auth_key, 'hotel/GetHotelAddressByHotelId/' . $hotel_id . '/' . $website_id . '/' . $state_name . '/' . $city_id);
			$GetHotelAddressByHotelId = json_decode($GetHotelAddressByHotelId, true);

			$GetAllHotelsRoomTypeByParam = call_api_get($auth_key, 'hotel/GetAllHotelsRoomTypeByParam/' . $website_id . '/' . $hotel_id);
			$GetAllHotelsRoomTypeByParam = json_decode($GetAllHotelsRoomTypeByParam, true);
			$html = "<option value=''></option>";
			foreach ($GetAllHotelsRoomTypeByParam as $room_type) {
				$html .= '<option value="' . $room_type['Id'] . '">' . $room_type['RoomType'] . '</option>';
			}

			echo json_encode(['status' => 1, 'address' => $GetHotelAddressByHotelId[0]['AddressTbl'], 'roomtype_html' => $html, 'GetAllHotelsRoomTypeByParam' => $GetAllHotelsRoomTypeByParam]);
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function save_hotel(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			if ($request['type'] == "Hotel") {
				$type = "false";
			} else {
				$type = "true";
			}

			$user_id = $this->session->userdata('user_id');
			if (isset($request['user_id']) && $request['user_id'] != "" && $request['user_id'] != "undefined") {
				$user_id = (int)$request['user_id'];
			}
//		echo $user_id;die();

			$website = (int)$request['website'];
			$hotel_id = (int)$request['hotel_name'];

			$CheckHotelValidation = call_api_get($auth_key, 'hotel/CheckHotelValidation/' . $website . '/' . $user_id . '/' . $hotel_id . '/' . $type . '/' . $request['hotel_code']);
			$CheckHotelValidation = json_decode($CheckHotelValidation, true);

			if ($CheckHotelValidation[0][0]['CanAdd'] == 0) {
				echo json_encode(['status' => 'failed', 'error' => 'Own hotel is already added for this website so you can not add more hotels.']);
				die();
			} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1) {
				if ($CheckHotelValidation[0][0]['SystemHotel'] == 1) {
					echo json_encode(['status' => 'failed', 'error' => 'Hotel name already exist in websitename for this customer so please select different hotel.']);
					die();
				} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1 && $CheckHotelValidation[0][0]['SystemHotel'] == 0) {
					$params['Address'] = $request['address'];
					$params['City'] = $request['city'];
					$params['Hotel'] = $request['hotel_name'];
					$params['MappedHotelName'] = $request['mapped_hotel_name'];
					$params['State'] = $request['state'];
					$params['UserId'] = $user_id;
					$params['Website'] = $request['website'];
					$params['HotelCode'] = $request['hotel_code'];
					$params['country_name'] = "US";
					$params['created_by'] = $this->session->userdata('user_id');
					$params['id'] = 0;
					$params['ip'] = $this->session->userdata('user_ip');
					$params['RoomType'] = $request['RoomType_1'];
					$params['RoomTypeTwo'] = isset($request['RoomType_2']) ? $request['RoomType_2'] : null;
					$params['RoomTypeThree'] = isset($request['RoomType_3']) ? $request['RoomType_3'] : null;
					$params['MappedRoomType'] = $request['MappedRoomType_1'];
					$params['MappedRoomTypeTwo'] = isset($request['MappedRoomType_2']) ? $request['MappedRoomType_2'] : null;
					$params['MappedRoomTypeThree'] = isset($request['MappedRoomType_3']) ? $request['MappedRoomType_3'] : null;

					$AddUpdateHotel = call_api_post($auth_key, 'hotel/AddUpdateHotel/' . $type, $params);
					echo json_encode(['status' => $AddUpdateHotel]);
					die();
				}
			}
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function edit_hotel(){
		$hotel_id =  $this->uri->segment(2);
		$type =  $this->uri->segment(3);

		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}
			$type = str_replace("%20"," ", $this->uri->segment(3));
			if (isset($type) && $type=="Hotel"){
				$bool_type = "false";
			}
			else{
				$bool_type = "true";
			}

			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			$GetAllWebsite = json_decode($GetAllWebsite, true);

			$GetAllState = call_api_get($auth_key, 'hotel/GetAllState');
			$GetAllState = json_decode($GetAllState, true);

			$GetUsers = call_api_get($auth_key, 'Customer/GetUsers');
			$GetUsers = json_decode($GetUsers, true);

			$GetMappedRoomType = call_api_get($auth_key, 'hotel/GetMappedRoomType');
			$GetMappedRoomType = json_decode($GetMappedRoomType, true);

			$GetHotelById = call_api_get($auth_key, 'hotel/GetHotelById/'.$hotel_id.'/'.$bool_type);
			$GetHotelById = json_decode($GetHotelById, true);

			/*echo "<pre>";
			print_r($GetHotelById);
			echo "</pre>";
			die();*/

			$GetAllCityByState = call_api_get($auth_key, 'hotel/GetAllCityByState/'.$GetHotelById[0]['State']);
			$GetAllCityByState = json_decode($GetAllCityByState, true);

			$GetHotelName = call_api_get($auth_key, 'hotel/GetHotelName/'.$GetHotelById[0]['WebSite'].'/'.$GetHotelById[0]['State'].'/'.$GetHotelById[0]['City']);
			$GetHotelName = json_decode($GetHotelName, true);

			$GetAllHotelsRoomTypeByParam = call_api_get($auth_key, 'hotel/GetAllHotelsRoomTypeByParam/'.$GetHotelById[0]['WebSite'].'/'.$GetHotelById[0]['SystemHotel']);
			$GetAllHotelsRoomTypeByParam = json_decode($GetAllHotelsRoomTypeByParam, true);

			$room_type_ids = array();
			$mapped_room_type_ids = array();
			foreach ($GetHotelById as $hotel){
				if (isset($hotel['RoomType']) && isset($hotel['MappedRoomType'])) {
					array_push($room_type_ids, $hotel['RoomType']);
					array_push($mapped_room_type_ids, $hotel['MappedRoomType']);
				}
			}

			$own_hotels = array();
			if ($type=="Competitor Hotel") {
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('MappedHotelName, HotelCode');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsDelete', 0);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
				$own_hotels = $this->RateAndReviewDb->get();
				$own_hotels = $own_hotels->result_array();
				$MappedHotelNames = array_column($own_hotels, 'MappedHotelName');
				$MappedHotelNames = array_unique($MappedHotelNames);
				$own_hotels = array_filter($own_hotels, function ($key, $value) use ($MappedHotelNames) {
					return in_array($value, array_keys($MappedHotelNames));
				}, ARRAY_FILTER_USE_BOTH);
			}
			$this->load->view('v_edit_hotel', compact('type', 'GetAllWebsite', 'GetAllState', 'GetUsers', 'GetMappedRoomType', 'GetAllCityByState', 'GetHotelName', 'GetAllHotelsRoomTypeByParam', 'GetHotelById', 'room_type_ids', 'mapped_room_type_ids', 'own_hotels'));
		}else {
			redirect('login');
		}
	}

	public function delete_hotel(){
		if ($this->session->userdata('auth_key')) {
			$type = $this->uri->segment(2);
			$hotel_id = $this->input->post('hotelId');
			$user_id = $this->input->post('user_id');
			$own_hotel_code = $this->input->post('own_hotel');
			$auth_key = $this->session->userdata('auth_key');
			$res = call_api_get($auth_key, 'hotel/DeleteHotel/' . $hotel_id);

			if ($user_id == "" || $user_id == "null") {
				$user_id = $this->session->userdata('user_id');
			}

			if ($type == "Hotel") {
				$url = 'hotel/GetHotelList/false/' . $user_id . '/' . $own_hotel_code;
				$check_permission = check_permission("Add your hotel");
			} else {
				$url = 'hotel/GetHotelList/true/' . $user_id . '/' . $own_hotel_code;
				$check_permission = check_permission("Add Competitor’s Hotel");
			}
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$GetHotelList = call_api_get($auth_key, $url);
			if ($GetHotelList != "") {
				$GetHotelList = json_decode($GetHotelList, true);
			}
			$html = "";
			if (isset($GetHotelList) && !empty($GetHotelList) && $GetHotelList != "") {
				foreach ($GetHotelList as $hotel) {
					$action = "";
					if ($edit == 1) {
						$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_hotel/' . $hotel['HotelId'] . '/' . $type . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>';
					}
					if ($delete == 1) {
						$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel(' . $hotel['HotelId'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
					}

					$html .= '<tr>';
					$html .= '<td>' . $hotel['WebSiteName'] . '</td>';
					$html .= '<td>' . $hotel['StateName'] . '</td>';
					$html .= '<td>' . $hotel['CityName'] . '</td>';
					$html .= '<td>' . $hotel['HotelName'] . '</td>';
					$html .= '<td>' . $hotel['MappedHotelName'] . '</td>';
					$html .= '<td>' . $hotel['RoomType'] . '</td>';
					$html .= '<td>' . $hotel['MappedRoomType'] . '</td>';
					$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
					</td>';
					$html .= '</tr>';
				}
			} else {
				$html .= '<tr>
						<td colspan="8" style="text-align: center">No records found</td>
					</tr>';
			}

			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function filter_hotel(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$type = $this->uri->segment(2);
			$user_id = $this->input->post('user_id');
			if ($user_id == "") {
				$user_id = $this->session->userdata('user_id');
			}
			$own_hotel_code = $this->input->post('own_hotel');

			if ($type == "Hotel") {
				$url = 'hotel/GetHotelList/false/' . $user_id . '/' . $own_hotel_code;
				$check_permission = check_permission("Add your hotel");
			} else {
				$url = 'hotel/GetHotelList/true/' . $user_id . '/' . $own_hotel_code;
				$check_permission = check_permission("Add Competitor’s Hotel");
			}
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$GetHotelList = call_api_get($auth_key, $url);
			if ($GetHotelList != "") {
				$GetHotelList = json_decode($GetHotelList, true);
			}
			$html = '';
			if (isset($GetHotelList) && !empty($GetHotelList) && $GetHotelList != "") {
				foreach ($GetHotelList as $hotel) {
					$action = "";
					if ($edit == 1) {
						$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_hotel/' . $hotel['HotelId'] . '/' . $type . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>';
					}
					if ($delete == 1) {
						$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel(' . $hotel['HotelId'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
					}

					$html .= '<tr>';
					$html .= '<td>' . $hotel['WebSiteName'] . '</td>';
					$html .= '<td>' . $hotel['StateName'] . '</td>';
					$html .= '<td>' . $hotel['CityName'] . '</td>';
					$html .= '<td>' . $hotel['HotelName'] . '</td>';
					$html .= '<td>' . $hotel['MappedHotelName'] . '</td>';
					$html .= '<td>' . $hotel['RoomType'] . '</td>';
					$html .= '<td>' . $hotel['MappedRoomType'] . '</td>';
					$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
					</td>';
					$html .= '</tr>';
				}
			} else {
				$html .= '<tr>
						<td colspan="8" style="text-align: center">No records found</td>
					</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function update_hotel(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			if ($request['type'] == "Hotel") {
				$type = "false";
			} else {
				$type = "true";
			}

			$user_id = $this->session->userdata('user_id');
			if (isset($request['user_id']) && $request['user_id'] != "" && $request['user_id'] != "undefined") {
				$user_id = (int)$request['user_id'];
			}
//		echo $user_id;die();

			$params['Address'] = $request['address'];
			$params['City'] = $request['city'];
			$params['Hotel'] = $request['hotel_name'];
			$params['MappedHotelName'] = $request['mapped_hotel_name'];
			$params['State'] = $request['state'];
			$params['UserId'] = $user_id;
			$params['Website'] = $request['website'];
			$params['HotelCode'] = $request['hotel_code'];
			$params['country_name'] = "US";
			$params['created_by'] = $this->session->userdata('user_id');
			$params['id'] = $request['id'];
			$params['ip'] = $this->session->userdata('user_ip');
			$params['RoomType'] = $request['RoomType_1'];
			$params['RoomTypeTwo'] = isset($request['RoomType_2']) ? $request['RoomType_2'] : null;
			$params['RoomTypeThree'] = isset($request['RoomType_3']) ? $request['RoomType_3'] : null;
			$params['MappedRoomType'] = $request['MappedRoomType_1'];
			$params['MappedRoomTypeTwo'] = isset($request['MappedRoomType_2']) ? $request['MappedRoomType_2'] : null;
			$params['MappedRoomTypeThree'] = isset($request['MappedRoomType_3']) ? $request['MappedRoomType_3'] : null;

			$AddUpdateHotel = call_api_post($auth_key, 'hotel/AddUpdateHotel/' . $type, $params);
			echo json_encode(['status' => $AddUpdateHotel]);
			die();
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function getProperty(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->uri->segment(2);
			if ($user_id == "" || $user_id == "null") {
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('MappedHotelName, HotelCode');
			$this->RateAndReviewDb->from('RR_Hotel');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsDelete', 0);
			$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
			$own_hotels = $this->RateAndReviewDb->get();
			$own_hotels = $own_hotels->result_array();
			$MappedHotelNames = array_column($own_hotels, 'MappedHotelName');
			$MappedHotelNames = array_unique($MappedHotelNames);
			$own_hotels = array_filter($own_hotels, function ($key, $value) use ($MappedHotelNames) {
				return in_array($value, array_keys($MappedHotelNames));
			}, ARRAY_FILTER_USE_BOTH);

			echo json_encode(['status' => 1, 'own_hotels' => $own_hotels]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}
}
