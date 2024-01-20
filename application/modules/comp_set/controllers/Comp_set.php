<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comp_set extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetAllState = call_api_get($auth_key, 'hotel/GetAllState');
			if ($GetAllState!="") {
				$GetAllState = json_decode($GetAllState, true);
			}
			/*print_r($GetAllState);
			die();*/
			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			if ($GetAllWebsite!="") {
				$GetAllWebsite = json_decode($GetAllWebsite, true);
			}
			$this->load->view('v_comp_set', compact('GetAllState', 'GetAllWebsite'));
		}else {
			redirect('login');
		}
	}

	public function GetAllCityByState(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$state = $this->input->post('state');
			$GetAllCityByState = call_api_get($auth_key, 'hotel/GetAllCityByState/' . $state);
			$GetAllCityByState = json_decode($GetAllCityByState, true);

			$html = '';
			$html .= '<option value=""></option>';
			foreach ($GetAllCityByState as $city) {
				$html .= '<option value="' . $city['Id'] . '">' . $city['Name'] . '</option>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function GetHotelName(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$city_id = $this->input->post('city_id');
			$website_id = $this->input->post('website_id');
			$state = $this->input->post('state');

			$GetHotelName = call_api_get($auth_key, 'hotel/GetHotelName/' . $website_id . '/' . $state . '/' . $city_id);
			$GetHotelName = json_decode($GetHotelName, true);

			$html = '';
			$html .= '<option value=""></option>';
			foreach ($GetHotelName as $hotel) {
				$html .= '<option value="' . $hotel['HotelId'] . '" hotel-name="' . $hotel['HotelName'] . '" lat="' . $hotel['latitude'] . '" long="' . $hotel['longitude'] . '">' . $hotel['HotelName'] . '</option>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function Gethotelwithinradius(){
		if ($this->session->userdata('auth_key')) {
			$state_code = $this->input->post('state_code');
			$hotel_name = str_replace(" ", "%20", $this->input->post('hotel_name'));
			$lat = $this->input->post('lat');
			$long = $this->input->post('long');
			$website_id = $this->input->post('website_id');
			$city_id = $this->input->post('city_id');
			$radius = $this->input->post('radius');

			$auth_key = $this->session->userdata('auth_key');
			$Gethotelwithinradius = call_api_get($auth_key, 'Hotel/Gethotelwithinradius?websiteId=' . $website_id . '&state=' . $state_code . '&cityId=' . $city_id . '&hotelname=' . $hotel_name . '&lat=' . $lat . '&lng=' . $long . '&radius=' . $radius);
			$html = '';
			if ($Gethotelwithinradius != "" && !empty($Gethotelwithinradius)) {
				$Gethotelwithinradius = json_decode($Gethotelwithinradius, true);

				$check_permission = check_permission("Comp Set");
				$add = $check_permission['add'];
				$edit = $check_permission['edit'];
				$delete = $check_permission['delete'];

				foreach ($Gethotelwithinradius['Table'] as $table_data) {
					if ($table_data['isOwnHotel'] == 1) {
						$type = "Own";
					} else {
						$type = "Competitors";
					}

					$btn = '';
					if ($add == 1) {
						$btn .= '<button type="button" id="map_hotel_btn" class="btn btn-secondary w-sm waves-effect waves-light" hotel-type="' . $type . '" hotel-name="' . $table_data['hotel'] . '" rating="' . $table_data['rating'] . '" total-reviews="' . $table_data['total_reviews'] . '" star="' . $table_data['star'] . '" hotel-id="' . $table_data['hotel_id'] . '" address="' . $table_data['address'] . '">Map Hotel</button>';
					}
					$html .= '<tr>';
					$html .= '<td>' . $btn . '</td>';
					$html .= '<td>' . $table_data['hotel'] . '</td>';
					$html .= '<td>' . $type . '</td>';
					$html .= '<td>' . $table_data['cityName'] . '</td>';
					$html .= '<td>' . $table_data['state'] . '</td>';
					$html .= '</tr>';
				}
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function GetAllHotelsRoomTypeByParam(){
		if ($this->session->userdata('auth_key')) {
			$websiteId = $this->input->post('websiteId');
			$hotelId = $this->input->post('hotelId');

			$auth_key = $this->session->userdata('auth_key');
			$GetAllHotelsRoomTypeByParam = call_api_get($auth_key, 'hotel/GetAllHotelsRoomTypeByParam/' . $websiteId . '/' . $hotelId);
			$GetAllHotelsRoomTypeByParam = json_decode($GetAllHotelsRoomTypeByParam, true);

			$GetMappedRoomType = call_api_get($auth_key, 'hotel/GetMappedRoomType');
			$GetMappedRoomType = json_decode($GetMappedRoomType, true);

			echo json_encode(['status' => 1, 'GetAllHotelsRoomTypeByParam' => $GetAllHotelsRoomTypeByParam, 'GetMappedRoomType' => $GetMappedRoomType]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function GetUsers(){
		$auth_key = $this->session->userdata('auth_key');

		$GetUsers = call_api_get($auth_key, 'Customer/GetUsers');
		$GetUsers = json_decode($GetUsers, true);

		$html = '';
		$html .= '<option value="" selected disabled>Select Customer</option>';
		foreach($GetUsers as $user)
		{
			$html .= '<option value="'.$user['id'].'">'.$user['user_name'].'</option>';
		}

		echo $html;
		die();
	}

	public function save_mapped_hotel(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->input->post('user_id');
			if ($user_id == "") {
				$user_id = $this->session->userdata('user_id');
			}
			/*echo $user_id;
			die();*/
			$website_id = $this->input->post('website_id');
			$hotel_id = $this->input->post('hotel_id');
			$type = $this->input->post('type');
			$CreatedBy = $this->session->userdata('user_id');
			$State = $this->input->post('State');
			$City = $this->input->post('City');
			$MappedHotelName = trim($this->input->post('MappedHotelName'));
			$HotelCode = trim($this->input->post('HotelCode'));
			$Address = trim($this->input->post('Address'));
			$hotelRoomMapDetails = $this->input->post('hotelRoomMapDetails');
			$ip = $this->session->userdata('user_ip');
//		$ip_details = ip_details($ip);
//		print_r($ip_details);
//		die();
			$CountryName = "US";

			$CheckHotelValidation = call_api_get($auth_key, 'hotel/CheckHotelValidation/' . $website_id . '/' . $user_id . '/' . $hotel_id . '/' . $type . '/' . $HotelCode);
			$CheckHotelValidation = json_decode($CheckHotelValidation, true);

			if ($CheckHotelValidation[0][0]['CanAdd'] == 0) {
				echo json_encode(['status' => 'failed', 'error' => 'Own hotel is already added for this website so you can not add more hotels.']);
				die();
			} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1) {
				if ($CheckHotelValidation[0][0]['SystemHotel'] == 1) {
					echo json_encode(['status' => 'failed', 'error' => 'Hotel name already exist in websitename for this customer so please select different hotel.']);
					die();
				} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1 && $CheckHotelValidation[0][0]['SystemHotel'] == 0) {
					$final_arr = [];
					$final_arr['CreatedBy'] = $CreatedBy;
					$final_arr['CountryName'] = $CountryName;
					$final_arr['State'] = $State;
					$final_arr['City'] = (int)$City;
					$final_arr['MappedHotelName'] = $MappedHotelName;
					$final_arr['HotelCode'] = $HotelCode;
					$final_arr['Address'] = $Address;
					$final_arr['UserId'] = (int)$user_id;
					$final_arr['Ip'] = $ip;
					$final_arr['hotelRoomMapDetails'] = $hotelRoomMapDetails;

					$AddUpdateHotel = call_api_post($auth_key, 'hotel/AddUpdateHotel/Compset/' . $type, $final_arr);

					echo json_encode(['status' => 200, 'success' => $AddUpdateHotel], JSON_FORCE_OBJECT);
					die();
				}
			}
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function CheckHotelValidation(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->input->post('user_id');
			$website_id = $this->input->post('website_id');
			$hotel_id = $this->input->post('hotel_id');
			$HotelCode = $this->input->post('HotelCode');
			$type = $this->input->post('type');
			if ($user_id == "") {
				$user_id = $this->session->userdata('user_id');
			}

			$CheckHotelValidation = call_api_get($auth_key, 'hotel/CheckHotelValidation/' . $website_id . '/' . $user_id . '/' . $hotel_id . '/' . $type . '/' . $HotelCode);
			$CheckHotelValidation = json_decode($CheckHotelValidation, true);

			if ($CheckHotelValidation[0][0]['CanAdd'] == 0) {
				echo json_encode(['status' => 'failed', 'error' => 'Own hotel is already added for this website so you can not add more hotels.']);
				die();
			} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1) {
				if ($CheckHotelValidation[0][0]['SystemHotel'] == 1) {
					echo json_encode(['status' => 'failed', 'error' => 'Hotel name already exist in websitename for this customer so please select different hotel.']);
					die();
				} elseif ($CheckHotelValidation[0][0]['CanAdd'] == 1 && $CheckHotelValidation[0][0]['SystemHotel'] == 0) {
					echo json_encode(['status' => 200]);
					die();
				}
			}
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}
}
