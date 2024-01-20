<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{

		//echo 'yes';
		parent::__construct();
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->session->userdata('auth_key')) {
			//			$send_mail = send();
			$user_permissions = $this->session->userdata('user_permissions');
			foreach ($user_permissions as $permission_page) {
				if ($permission_page['display_name'] == "Rate Dashboard") {
					redirect('dashboard');
				} else if ($permission_page['parent_id'] == 9) {
					if (array_search("Settings", array_column($user_permissions, 'display_name')) !== FALSE) {
						redirect(ltrim($permission_page['router_link'], '/'));
					}
				}
			}
		}

		if ($this->form_validation->run() == FALSE) {

			// Here is where you do stuff when the submitted form is invalid.
			$errors = $this->form_validation->error_array();
			$data = array();
			if (!empty($errors) && isset($errors['username'])) {
				$data['username_err'] = $errors['username'];
			}
			if (!empty($errors) && isset($errors['password'])) {
				$data['password_err'] = $errors['password'];
			}
			$this->load->view('login', $data);
		} else {
			// Here is where you do stuff when the submitted form is valid.
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$auth_key = base64_encode($username . ":" . $password);

			$params = array(
				"Email" => $username,
				"Password" => $password,
				"ip" => null
			);
			$result = call_api_post($auth_key, "customer/CheckCustomerValid", $params);
			if (!empty($result)) {
				$user_data = json_decode(trim($result), true);
			}
			/*echo "<pre>";
			print_r($user_data);
			echo "</pre>";
			die();*/
			if (isset($user_data) && !empty($user_data)) {
				if ($user_data[0][0]['Status'] == -1) {
					$data['username_err'] = 'E-mail Invalid. Please try Again.';
					$this->load->view('login', $data);
				} elseif ($user_data[0][0]['Status'] == 0) {
					$data['username_err'] = 'Invalid Credentials. Please try Again.';
					$this->load->view('login', $data);
				} else {
					$this->session->set_userdata('username', $user_data[0][0]['user_name']);
					$this->session->set_userdata('auth_key', $auth_key);
					$this->session->set_userdata('user_id', $user_data[0][0]['id']);
					$this->session->set_userdata('user_permissions', $user_data[1]);
					$this->session->set_userdata('role_name', $user_data[1][0]['name']);
					$this->session->set_userdata('is_review_customer', $user_data[0][0]['is_review_customer']);

					//$GetUsers = call_api_get($auth_key, 'Customer/GetUsers');
					//$GetUsers = json_decode($GetUsers, true);
					//print_r($GetUsers);
					$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

					$this->RateAndReviewDb->select('id, user_name');
					$this->RateAndReviewDb->from('RR_CustomerDetail');
					$this->RateAndReviewDb->where('user_status', 1);
					if ($user_data[0][0]['is_review_customer'] == 1) {
						$this->RateAndReviewDb->where('is_review_customer', 1);
					} else {
						$this->RateAndReviewDb->where('is_review_customer', 0);
					}
					$this->RateAndReviewDb->order_by('user_name', 'ASC');
					$GetUsers = $this->RateAndReviewDb->get();
					$GetUsers = $GetUsers->result_array();
					$this->session->set_userdata('all_users', $GetUsers);

					/*$this->session->set_userdata('own_hotel_id', $RR_customer['SystemHotel']);
					$this->session->set_userdata('own_hotel_name', $RR_customer[0]['MappedHotelName']);
					$this->session->set_userdata('own_hotel_color', $RR_customer['HotelColor']);*/

					$ip = get_ip();
					$this->session->set_userdata('user_ip', $ip['ip']);
					//					$send_mail = send();
					redirect(ltrim($user_data[1][0]['router_link'], '/'));
				}
			} else {
				$data['username_err'] = 'Invalid Credentials. Please try Again.';
				$this->load->view('login', $data);
			}
		}
	}

	public function GetOwnHotelsByCustomer()
	{
		$user_id = $this->input->post('user_id');
		$this->session->set_userdata('new_user_id', $user_id);
		$page = $this->input->post('page');

		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			if ($page!="" && ($page=="manage_hotels" || $page=="respond_review" || $page=="manage_credentials" || $page=="review_summary" || $page=="review_report" || $page=="rr_dashboard" || $page=="manage_website" || $page=="view_report")){
				$this->RateAndReviewDb->select('ch.id,ch.hotel_name,ch.email,ch.copy_recipients');
				$this->RateAndReviewDb->from('client_hotels ch');
				$this->RateAndReviewDb->join('RR_customer as rrc', 'rrc.user_id = ch.client_id', 'left');
				$this->RateAndReviewDb->where('rrc.user_id',$user_id);
				$this->RateAndReviewDb->where('ch.is_deleted',0);
				$hotels = $this->RateAndReviewDb->get();
				$hotels = $hotels->result_array();

				$html = '';
				if (isset($hotels) && !empty($hotels)){
					$html .= '<option value="all" selected>All Hotels</option>';
					foreach ($hotels as $key => $hotel) {
						$html .= '<option value="' . $hotel['id'] . '" email="'.$hotel['email'].'" copy_recipients="'.$hotel['copy_recipients'].'">' . $hotel['hotel_name'] . '</option>';
					}
				}

				echo json_encode(['status' => 1, 'html' => $html]);
				exit;
			}
			else {
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, HotelColor, HotelCode');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsDelete', 0);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
				$own_hotels = $this->RateAndReviewDb->get();
				$own_hotels = $own_hotels->result_array();
				/*echo $user_id;
				pre($own_hotels);*/
				$MappedHotelNames = array_column($own_hotels, 'MappedHotelName');
				$MappedHotelNames = array_unique($MappedHotelNames);
				$own_hotels = array_filter($own_hotels, function ($key, $value) use ($MappedHotelNames) {
					return in_array($value, array_keys($MappedHotelNames));
				}, ARRAY_FILTER_USE_BOTH);

				$html = '';
				foreach ($own_hotels as $key => $own_hotel) {
					$selected = "";
					if ($key == 0) {
						$selected = "selected";
					}
					$html .= '<option value="' . $own_hotel['HotelCode'] . '" ' . $selected . '>' . $own_hotel['MappedHotelName'] . '</option>';
				}

				$hotel_color = "";
				$MappedHotelName = "";
				if (isset($own_hotels) && !empty($own_hotels)) {
					$hotel_color = $own_hotels[0]['HotelColor'];
					$MappedHotelName = $own_hotels[0]['MappedHotelName'];
				}

				echo json_encode(['status' => 1, 'html' => $html, 'hotel_color' => $hotel_color, 'hotel_name' => $MappedHotelName]);
				exit;
			}
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
