<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$page = "dashboard";
			$user_id = $this->session->userdata('user_id');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('RR_Hotel');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
			$RR_customer = $this->RateAndReviewDb->get();
			$RR_customer = $RR_customer->result_array();

			$user_state = !empty($RR_customer) ? $RR_customer[0]['State'] : '';
			$user_city = !empty($RR_customer) ? $RR_customer[0]['City'] : '';

			$state_data = '';
			$brand_data = '';
			$tier_data = '';
			$websites = '';
			// $this->RateAndReviewDb->select('*');
			// $this->RateAndReviewDb->from('tbl_usa_states');
			// $get_state_result = $this->RateAndReviewDb->get();
			// $state_data = $get_state_result->result_array();

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('RR_WebSiteList');
			$get_website_data = $this->RateAndReviewDb->get();
			$websites = $get_website_data->result_array();

			$this->bookingcomDb = $this->load->database('bookingcom', true);
			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(cp.scrape_time) as scrape_time');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('check_in <=', date('Y-m-d H:i:s.v'));
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query2 = $this->bookingcomDb->get();
			$rate_data = $query2->result();

			// $rate_chart_labels = [];
			// $rate_chart_data = [];
			// foreach($rate_data as $dt)
			// {
			// 	$country = substr($dt->hotel_name, 0, 17);
			// 	$visits = round($dt->rate);
			// 	array_push($rate_chart_labels,$country);
			// 	array_push($rate_chart_data,$visits);
			// }
			// $rate_chart_labels  = json_encode($rate_chart_labels);
			// $rate_chart_data  = json_encode($rate_chart_data);

			$guest_scrore_data = array();
			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, th.rating as guest_score, Max(th.total_available_room) as number_of_room');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price !=', -2.00);
			$this->bookingcomDb->where('check_in <=', date('Y-m-d H:i:s.v'));
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.rating');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('guest_score', 'DESC');
			$query1 = $this->bookingcomDb->get();
			$guest_scrore_data = $query1->result();

			// $guestScrore_chart_labels = [];
			// $guestScrore_chart_data = [];
			// foreach($guest_scrore_data as $dt1)
			// {
			// 	$country = substr($dt1->hotel_name, 0, 25);
			// 	$litres = (float) $dt1->guest_score;
			// 	array_push($guestScrore_chart_labels,$country);
			// 	array_push($guestScrore_chart_data,$litres);
			// }
			// $guestScrore_chart_labels  = json_encode($guestScrore_chart_labels);
			// $guestScrore_chart_data  = json_encode($guestScrore_chart_data);

			$star_data = array();
			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, th.star as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score, Max(th.total_available_room) as number_of_room');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('check_in <=', date('Y-m-d H:i:s.v'));
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.star');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('star', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$star_data = $query3->result();

			// $star_chart_labels = [];
			// $star_chart_data = [];
			// foreach($star_data as $dt2)
			// {
			// 	$country = substr($dt2->hotel_name, 0, 25);
			// 	$litres = (float) $dt2->star;
			// 	array_push($star_chart_labels,$country);
			// 	array_push($star_chart_data,$litres);
			// }
			// $star_chart_labels  = json_encode($star_chart_labels);
			// $star_chart_data  = json_encode($star_chart_data);

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->bookingcomDb->where('check_in <=', date('Y-m-d H:i:s.v'));
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.Brand');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$brands_data = $query3->result();

			// $brand_chart_labels = [];
			// $brand_chart_data = [];
			// foreach($brands_data as $bd)
			// {
			// 	$category = $bd->Brand.'-'.substr($bd->hotel_name, 0, 17);
			// 	$value = (float) $bd->rate;
			// 	array_push($brand_chart_labels,$category);
			// 	array_push($brand_chart_data,$value);
			// }
			// $brand_chart_labels  = json_encode($brand_chart_labels);
			// $brand_chart_data  = json_encode($brand_chart_data);

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->bookingcomDb->where('check_in <=', date('Y-m-d H:i:s.v'));
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.tier');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$tiers_data = $query3->result();

			// $tier_chart_labels = [];
			// $tier_chart_data = [];
			// foreach($tiers_data as $tr)
			// {
			// 	$category = $tr->tier.'-'.substr($tr->hotel_name, 0,10);
			// 	$value = (float) $tr->rate;
			// 	array_push($tier_chart_labels,$category);
			// 	array_push($tier_chart_data,$value);
			// }
			// $tier_chart_labels  = json_encode($tier_chart_labels);
			// $tier_chart_data  = json_encode($tier_chart_data);

			$this->load->view('v_dashboard', compact('page', 'websites', 'rate_data', 'guest_scrore_data', 'star_data', 'brands_data', 'tiers_data', 'user_state', 'user_city'));
		} else {
			redirect('login');
		}
	}

	public function fetch_city()
	{
		extract($_REQUEST);
		/*$html='';
		if (in_array('AL',$state_code)){
			$html .= '<option value="AL1">AL1</option>';
			$html .= '<option value="AL2">AL2</option>';
			$html .= '<option value="AL3">AL3</option>';
		}
		if (in_array('AK',$state_code)){
			$html .= '<option value="AK1">AK1</option>';
			$html .= '<option value="AK2">AK2</option>';
			$html .= '<option value="AK3">AK3</option>';
		}
		if (in_array('AZ',$state_code)){
			$html .= '<option value="AZ1">AZ1</option>';
			$html .= '<option value="AZ2">AZ2</option>';
			$html .= '<option value="AZ3">AZ3</option>';
		}*/

		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('tbl_usa_cities');
			$this->RateAndReviewDb->where_in('state_code', $state_code);
			$get_city_result = $this->RateAndReviewDb->get();
			$city_data = $get_city_result->result();

			$html = '';
//			pre($selected_cities);
			foreach ($get_city_result->result() as $row) {
				$selected = "";
				if (isset($user_city) && $row->city_id == $user_city) {
					$selected = "selected";
				}
				if (isset($selected_cities) && in_array($row->city_id, $selected_cities)){
					$selected = "selected";
				}
				$html .= '<option value="' . $row->city_id . '" ' . $selected . '>' . $row->city . '</option>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filters()
	{
		if ($this->session->userdata('auth_key')) {
			$web_site = str_replace(".", "", $_REQUEST['web_table']);
			extract($_REQUEST);

			if (isset($_REQUEST['date'])) {
				$dates = explode(" - ", $_REQUEST['date']);
				$get_start = strtotime($dates[0]);
				$start = date('Y-m-d H:i:s.v', $get_start);

				$get_end = strtotime($dates[1]);
				$end = date('Y-m-d H:i:s.v', $get_end);
			}

			$this->websiteDb = $this->load->database($web_site, true);

			// Rate data
			$this->websiteDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score, Max(th.total_available_room) as number_of_room,Max(cp.scrape_time) as scrape_time');
			$this->websiteDb->from('tbl_pricing cp');
			$this->websiteDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (isset($_REQUEST['city'])) {
				$this->websiteDb->where_in('cp.city', $_REQUEST['city']);
			}
			if (isset($_REQUEST['state'])) {
				$this->websiteDb->where_in('cp.state', $_REQUEST['state']);
			}
			if (isset($from_rate) && isset($to_rate) && $from_rate != "" && $to_rate != "") {
				$from = $_REQUEST['from_rate'];
				$to = $_REQUEST['to_rate'];
				$this->websiteDb->where('cp.price BETWEEN ' . $from . ' AND ' . $to);
			}
			if (isset($start)) {
				$this->websiteDb->where('check_in <=', $start);
			}
			if (isset($end)) {
				//$this->websiteDb->where('check_out <=', $end);
			}
			if (isset($brand) && count($brand) > 0) {
				$this->websiteDb->where_in('th.Brand', $brand);
			}
			if (isset($tier) && count($tier) > 0) {
				$this->websiteDb->where_in('th.tier', $tier);
			}
			if (isset($star) && count($star) > 0) {
				$this->websiteDb->where_in('th.star', $star);
			}
			if (isset($guest) && count($guest) > 0) {
				sort($guest);
				$guest_where = '';
				foreach ($guest as $key => $gt) {
					$from = $gt - 0.5;
					$to = $gt + 0.5;
					if ($key == 0) {
						$guest_where .= '(th.rating BETWEEN ' . $from . ' AND ' . $to;
					} else {
						$guest_where .= ' or th.rating BETWEEN ' . $from . ' AND ' . $to;
					}
				}
				$guest_where .= ')';
				$this->websiteDb->where($guest_where);
			}
			$this->websiteDb->limit(10);
			$this->websiteDb->group_by('cp.hotel');
			$this->websiteDb->group_by('cp.hotel_id');
			$this->websiteDb->order_by('rate', 'DESC');
			$query1 = $this->websiteDb->get();
			$rate_data = $query1->result();

			//rate chart
			// $rate_chart_labels = [];
			// $rate_chart_data = [];
			// foreach($rate_data as $dt)
			// {
			// 	$country = substr($dt->hotel_name, 0, 17);
			// 	$visits = round($dt->rate);
			// 	array_push($rate_chart_labels,$country);
			// 	array_push($rate_chart_data,$visits);
			// }

			//Guest Score data
			$this->websiteDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score, Max(th.total_available_room) as number_of_room');
			$this->websiteDb->from('tbl_pricing cp');
			$this->websiteDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			$array_where_guest = array('cp.price !=' => -2.00);
			$this->websiteDb->where($array_where_guest);
			if (isset($_REQUEST['city'])) {
				$this->websiteDb->where_in('cp.city', $_REQUEST['city']);
			}
			if (isset($_REQUEST['state'])) {
				$this->websiteDb->where_in('cp.state', $_REQUEST['state']);
			}
			if (isset($from_rate) && isset($to_rate) && $from_rate != "" && $to_rate != "") {
				$from = $_REQUEST['from_rate'];
				$to = $_REQUEST['to_rate'];
				$this->websiteDb->where('cp.price BETWEEN ' . $from . ' AND ' . $to);
			}
			if (isset($start)) {
				$this->websiteDb->where('check_in <=', $start);
			}
			if (isset($end)) {
				//$this->websiteDb->where('check_out <=', $end);
			}
			if (isset($brand) && count($brand) > 0) {
				$this->websiteDb->where_in('th.Brand', $brand);
			}
			if (isset($tier) && count($tier) > 0) {
				$this->websiteDb->where_in('th.tier', $tier);
			}
			if (isset($star) && count($star) > 0) {
				$this->websiteDb->where_in('th.star', $star);
			}
			if (isset($guest) && count($guest) > 0) {
				sort($guest);
				$guest_where = '';
				foreach ($guest as $key => $gt) {
					$from = $gt - 0.5;
					$to = $gt + 0.5;
					if ($key == 0) {
						$guest_where .= '(th.rating BETWEEN ' . $from . ' AND ' . $to;
					} else {
						$guest_where .= ' or th.rating BETWEEN ' . $from . ' AND ' . $to;
					}
				}
				$guest_where .= ')';
				$this->websiteDb->where($guest_where);
			}
			$this->websiteDb->limit(10);
			$this->websiteDb->group_by('th.rating');
			$this->websiteDb->group_by('cp.hotel');
			$this->websiteDb->group_by('cp.hotel_id');
			$this->websiteDb->order_by('th.rating', 'DESC');
			$query2 = $this->websiteDb->get();
			$guest_scrore_data = $query2->result();

			//Guest Score chart
			// $guestScrore_chart_labels = [];
			// $guestScrore_chart_data = [];
			// foreach($guest_scrore_data as $dt1)
			// {
			// 	$country = substr($dt1->hotel_name, 0, 25);
			// 	$litres = (float) $dt1->guest_score;
			// 	array_push($guestScrore_chart_labels,$country);
			// 	array_push($guestScrore_chart_data,$litres);
			// }

			//Star data
			$this->websiteDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score, Max(th.total_available_room) as number_of_room');
			$this->websiteDb->from('tbl_pricing cp');
			$this->websiteDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (isset($_REQUEST['city'])) {
				$this->websiteDb->where_in('cp.city', $_REQUEST['city']);
			}
			if (isset($_REQUEST['state'])) {
				$this->websiteDb->where_in('cp.state', $_REQUEST['state']);
			}
			if (isset($from_rate) && isset($to_rate) && $from_rate != "" && $to_rate != "") {
				$from = $_REQUEST['from_rate'];
				$to = $_REQUEST['to_rate'];
				$this->websiteDb->where('cp.price BETWEEN ' . $from . ' AND ' . $to);
			}
			if (isset($start)) {
				$this->websiteDb->where('check_in <=', $start);
			}
			if (isset($end)) {
				//$this->websiteDb->where('check_out <=', $end);
			}
			if (isset($brand) && count($brand) > 0) {
				$this->websiteDb->where_in('th.Brand', $brand);
			}
			if (isset($tier) && count($tier) > 0) {
				$this->websiteDb->where_in('th.tier', $tier);
			}
			if (isset($star) && count($star) > 0) {
				$this->websiteDb->where_in('th.star', $star);
			}
			if (isset($guest) && count($guest) > 0) {
				sort($guest);
				$guest_where = '';
				foreach ($guest as $key => $gt) {
					$from = $gt - 0.5;
					$to = $gt + 0.5;
					if ($key == 0) {
						$guest_where .= '(th.rating BETWEEN ' . $from . ' AND ' . $to;
					} else {
						$guest_where .= ' or th.rating BETWEEN ' . $from . ' AND ' . $to;
					}
				}
				$guest_where .= ')';
				$this->websiteDb->where($guest_where);
			}
			$this->websiteDb->limit(10);
			$this->websiteDb->group_by('th.star');
			$this->websiteDb->group_by('cp.hotel');
			$this->websiteDb->group_by('cp.hotel_id');
			$this->websiteDb->order_by('star', 'DESC');
			$query3 = $this->websiteDb->get();
			$star_data = $query3->result();

			//Star Chart data
			// $star_chart_labels = [];
			// $star_chart_data = [];
			// foreach($star_data as $dt2)
			// {
			// 	$country = substr($dt2->hotel_name, 0, 25);
			// 	$litres = (float) $dt2->star;
			// 	array_push($star_chart_labels,$country);
			// 	array_push($star_chart_data,$litres);
			// }

			//Brand data
			$this->websiteDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->websiteDb->from('tbl_pricing cp');
			$this->websiteDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (isset($_REQUEST['city'])) {
				$this->websiteDb->where_in('cp.city', $_REQUEST['city']);
			}
			if (isset($_REQUEST['state'])) {
				$this->websiteDb->where_in('cp.state', $_REQUEST['state']);
			}
			if (isset($from_rate) && isset($to_rate) && $from_rate != "" && $to_rate != "") {
				$from = $_REQUEST['from_rate'];
				$to = $_REQUEST['to_rate'];
				$this->websiteDb->where('cp.price BETWEEN ' . $from . ' AND ' . $to);
			}
			if (isset($start)) {
				$this->websiteDb->where('check_in <=', $start);
			}
			if (isset($end)) {
				//	$this->websiteDb->where('check_out <=', $end);
			}
			if (isset($brand) && count($brand) > 0) {
				$this->websiteDb->where_in('th.Brand', $brand);
			}
			if (isset($tier) && count($tier) > 0) {
				$this->websiteDb->where_in('th.tier', $tier);
			}
			if (isset($star) && count($star) > 0) {
				$this->websiteDb->where_in('th.star', $star);
			}
			if (isset($guest) && count($guest) > 0) {
				sort($guest);
				$guest_where = '';
				foreach ($guest as $key => $gt) {
					$from = $gt - 0.5;
					$to = $gt + 0.5;
					if ($key == 0) {
						$guest_where .= '(th.rating BETWEEN ' . $from . ' AND ' . $to;
					} else {
						$guest_where .= ' or th.rating BETWEEN ' . $from . ' AND ' . $to;
					}
				}
				$guest_where .= ')';
				$this->websiteDb->where($guest_where);
			}
			$this->websiteDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->websiteDb->limit(10);
			$this->websiteDb->group_by('th.Brand');
			$this->websiteDb->group_by('cp.hotel');
			$this->websiteDb->group_by('cp.hotel_id');
			$this->websiteDb->order_by('rate', 'DESC');
			$query4 = $this->websiteDb->get();
			$brand_data = $query4->result();

			//Brand Chart data
			// $brand_chart_labels = [];
			// $brand_chart_data = [];
			// foreach($brand_data as $bd)
			// {
			// 	$category = $bd->Brand.'-'.substr($bd->hotel_name, 0, 17);
			// 	$value = (float) $bd->rate;
			// 	array_push($brand_chart_labels,$category);
			// 	array_push($brand_chart_data,$value);
			// }

			//Tier data
			$this->websiteDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->websiteDb->from('tbl_pricing cp');
			$this->websiteDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (isset($_REQUEST['city'])) {
				$this->websiteDb->where_in('cp.city', $_REQUEST['city']);
			}
			if (isset($_REQUEST['state'])) {
				$this->websiteDb->where_in('cp.state', $_REQUEST['state']);
			}
			if (isset($from_rate) && isset($to_rate) && $from_rate != "" && $to_rate != "") {
				$from = $_REQUEST['from_rate'];
				$to = $_REQUEST['to_rate'];
				$this->websiteDb->where('cp.price BETWEEN ' . $from . ' AND ' . $to);
			}
			if (isset($start)) {
				$this->websiteDb->where('check_in <=', $start);
			}
			if (isset($end)) {
				//$this->websiteDb->where('check_out <=', $end);
			}
			if (isset($brand) && count($brand) > 0) {
				$this->websiteDb->where_in('th.Brand', $brand);
			}
			if (isset($tier) && count($tier) > 0) {
				$this->websiteDb->where_in('th.tier', $tier);
			}
			if (isset($star) && count($star) > 0) {
				$this->websiteDb->where_in('th.star', $star);
			}
			if (isset($guest) && count($guest) > 0) {
				sort($guest);
				$guest_where = '';
				foreach ($guest as $key => $gt) {
					$from = $gt - 0.5;
					$to = $gt + 0.5;
					if ($key == 0) {
						$guest_where .= '(th.rating BETWEEN ' . $from . ' AND ' . $to;
					} else {
						$guest_where .= ' or th.rating BETWEEN ' . $from . ' AND ' . $to;
					}
				}
				$guest_where .= ')';
				$this->websiteDb->where($guest_where);
			}
			$this->websiteDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->websiteDb->limit(10);
			$this->websiteDb->group_by('th.tier');
			$this->websiteDb->group_by('cp.hotel');
			$this->websiteDb->group_by('cp.hotel_id');
			$this->websiteDb->order_by('rate', 'DESC');
			$query5 = $this->websiteDb->get();
			$tier_data = $query5->result();

			//Tier Chart data
			// $tier_chart_labels = [];
			// $tier_chart_data = [];
			// foreach($tier_data as $tr)
			// {
			// 	$category = $tr->tier.'-'.substr($tr->hotel_name, 0,10);
			// 	$value = (float) $tr->rate;
			// 	array_push($tier_chart_labels,$category);
			// 	array_push($tier_chart_data,$value);
			// }

			echo json_encode([
				'status' => 1,
				'rate_json' => $rate_data ?? "",
				// 'rate_chart_labels'=>$rate_chart_labels ?? "",
				// 'rate_chart_data'=>$rate_chart_data ?? "",
				'guest_scrorejson' => $guest_scrore_data ?? "",
				// 'guestScrore_chart_labels'=>$guestScrore_chart_labels ?? "",
				// 'guestScrore_chart_data'=>$guestScrore_chart_data ?? "",
				'star_json' => $star_data ?? "",
				// 'star_chart_labels'=>$star_chart_labels ?? "",
				// 'star_chart_data'=>$star_chart_data ?? "",
				'brand_json' => $brand_data ?? "",
				// 'brand_chart_labels'=>$brand_chart_labels ?? "",
				// 'brand_chart_data'=>$brand_chart_data ?? "",
				'tier_json' => $tier_data ?? "",
				// 'tier_chart_labels'=>$tier_chart_labels ?? "",
				// 'tier_chart_data'=>$tier_chart_data ?? "",
			]);
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_single_hotel_data()
	{
		$hotel_id =  $this->uri->segment(2);
		$website =  $this->uri->segment(3);
		$web_site = str_replace(".", "", $website);

		$this->websiteDb = $this->load->database($web_site, true);
		$this->websiteDb->select('hotel_id as hotelid,hotel as hotel_name,star as star,rating as guest_score,total_available_room as number_of_room,brand,tier,total_reviews as reviews,street_address,city,state,zipcode');
		$this->websiteDb->from('tbl_hotels');
		$this->websiteDb->where('hotel_id =', $hotel_id);
		$query = $this->websiteDb->get();
		$hotel_data = $query->result_array();

		$this->cityDb = $this->load->database("RateAndReview", true);
		$this->cityDb->select('city,state');
		$this->cityDb->from('tbl_usa_cities');
		$this->cityDb->where('city_id =', $hotel_data[0]['city']);
		$query = $this->cityDb->get();
		$city_data = $query->result_array();

		$this->load->view('v_single_hotel', compact('hotel_data', 'city_data'));
	}

	public function clear_all()
	{
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$user_id = $this->session->userdata('user_id');
			$this->RateAndReviewDb->select('State, City');
			$this->RateAndReviewDb->from('RR_Hotel');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
			$RR_customer = $this->RateAndReviewDb->get();
			$RR_customer = $RR_customer->result_array();

			$user_state = !empty($RR_customer) ? $RR_customer[0]['State'] : '';
			$user_city = !empty($RR_customer) ? $RR_customer[0]['City'] : '';

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('tbl_usa_states');
			$get_state_result = $this->RateAndReviewDb->get();
			$state_data = $get_state_result->result();

			$html = '';
			foreach ($get_state_result->result() as $row) {
				$selected = "";
				if ($row->state_code == $user_state) {
					$selected = "selected";
				}
				$html .= '<option value="' . $row->state_code . '" ' . $selected . '>' . $row->state . '</option>';
			}

			$this->bookingcomDb = $this->load->database('bookingcom', true);
			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(cp.scrape_time) as scrape_time');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query2 = $this->bookingcomDb->get();
			$rate_data = $query2->result();

			// $rate_chart_labels = [];
			// $rate_chart_data = [];
			// foreach($rate_data as $dt)
			// {
			// 	$country = substr($dt->hotel_name, 0, 17);
			// 	$visits = round($dt->rate);
			// 	array_push($rate_chart_labels,$country);
			// 	array_push($rate_chart_data,$visits);
			// }

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, th.rating as guest_score, Max(th.total_available_room) as number_of_room');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price !=', -2.00);
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.rating');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('guest_score', 'DESC');
			$query1 = $this->bookingcomDb->get();
			$guest_scrore_data = $query1->result();

			// $guestScrore_chart_labels = [];
			// $guestScrore_chart_data = [];
			// foreach($guest_scrore_data as $dt1)
			// {
			// 	$country = substr($dt1->hotel_name, 0, 25);
			// 	$litres = (float) $dt1->guest_score;
			// 	array_push($guestScrore_chart_labels,$country);
			// 	array_push($guestScrore_chart_data,$litres);
			// }

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, th.star as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score, Max(th.total_available_room) as number_of_room');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.star');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('star', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$star_data = $query3->result();

			// $star_chart_labels = [];
			// $star_chart_data = [];
			// foreach($star_data as $dt2)
			// {
			// 	$country = substr($dt2->hotel_name, 0, 25);
			// 	$litres = (float) $dt2->star;
			// 	array_push($star_chart_labels,$country);
			// 	array_push($star_chart_data,$litres);
			// }

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.Brand');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$brands_data = $query3->result();

			// $brand_chart_labels = [];
			// $brand_chart_data = [];
			// foreach($brands_data as $bd)
			// {
			// 	$category = $bd->Brand.'-'.substr($bd->hotel_name, 0, 17);
			// 	$value = (float) $bd->rate;
			// 	array_push($brand_chart_labels,$category);
			// 	array_push($brand_chart_data,$value);
			// }

			$this->bookingcomDb->select('cp.hotel_id as hotelid,cp.hotel as hotel_name, Min(cp.price) as rate, Max(th.star) as star, Max(cp.room_type) as room_type, Max(th.rating) as guest_score,Max(th.total_available_room) as number_of_room,Max(th.Tier) As tier, Max(th.Brand) as Brand');
			$this->bookingcomDb->from('tbl_pricing cp');
			$this->bookingcomDb->join('tbl_hotels as th', 'th.hotel_id = cp.hotel_id', 'left');
			if (!empty($user_state)) {
				$this->bookingcomDb->where('cp.state', $user_state);
			}
			if (!empty($user_city)) {
				$this->bookingcomDb->where('cp.city', $user_city);
			}
			$this->bookingcomDb->where('cp.price != -2')->or_where('th.Brand', '!=', NULL);
			$this->bookingcomDb->limit(10);
			$this->bookingcomDb->group_by('th.tier');
			$this->bookingcomDb->group_by('cp.hotel');
			$this->bookingcomDb->group_by('cp.hotel_id');
			$this->bookingcomDb->order_by('rate', 'DESC');
			$query3 = $this->bookingcomDb->get();
			$tiers_data = $query3->result();

			// $tier_chart_labels = [];
			// $tier_chart_data = [];
			// foreach($tiers_data as $tr)
			// {
			// 	$category = $tr->tier.'-'.substr($tr->hotel_name, 0,10);
			// 	$value = (float) $tr->rate;
			// 	array_push($tier_chart_labels,$category);
			// 	array_push($tier_chart_data,$value);
			// }

			echo json_encode([
				'status' => 1,
				'state_data' => $html ?? "",
				'rate_json' => $rate_data ?? "",
				// 'rate_chart_labels'=>$rate_chart_labels ?? "",
				// 'rate_chart_data'=>$rate_chart_data ?? "",
				'guest_scrorejson' => $guest_scrore_data ?? "",
				// 'guestScrore_chart_labels'=>$guestScrore_chart_labels ?? "",
				// 'guestScrore_chart_data'=>$guestScrore_chart_data ?? "",
				'star_json' => $star_data ?? "",
				// 'star_chart_labels'=>$star_chart_labels ?? "",
				// 'star_chart_data'=>$star_chart_data ?? "",
				'brand_json' => $brands_data ?? "",
				// 'brand_chart_labels'=>$brand_chart_labels ?? "",
				// 'brand_chart_data'=>$brand_chart_data ?? "",
				'tier_json' => $tiers_data ?? "",
				// 'tier_chart_labels'=>$tier_chart_labels ?? "",
				// 'tier_chart_data'=>$tier_chart_data ?? "",
				'user_state' => $user_state,
				'user_city' => $user_city,
			]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_data_filter()
	{
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('tbl_usa_states');
			$get_state_result = $this->RateAndReviewDb->get();
			$state_data = $get_state_result->result_array();

			$this->RateAndReviewDb->select('DISTINCT(brand)');
			$this->RateAndReviewDb->from('BrandMaster');
			$qr = $this->RateAndReviewDb->get();
			$brand_data = $qr->result_array();

			$this->RateAndReviewDb->select('DISTINCT(tier)');
			$this->RateAndReviewDb->from('BrandMaster');
			$this->RateAndReviewDb->where('tier !=', null);
			$qr1 = $this->RateAndReviewDb->get();
			$tier_data = $qr1->result_array();

			echo json_encode(['status' => 1, 'states' => $state_data, 'brands' => $brand_data, 'tiers' => $tier_data]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}
}
