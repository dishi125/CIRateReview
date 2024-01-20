<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_analysis_dashboard extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->from('RR_WebSiteList');
			$get_website_data = $this->RateAndReviewDb->get();
			$websites = $get_website_data->result_array();
//			pre($websites);
			$website_wise_cnt = array();
			foreach ($websites as $website) {
				$web_site_db= strtolower(str_replace(".","",$website['Name']));
				$this->websiteDb = $this->load->database($web_site_db, true);
				$this->websiteDb->select('count(DISTINCT(hotel_id)) as total_hotels, count(DISTINCT(state)) as total_states, count(DISTINCT(city)) as total_cities');
				$this->websiteDb->from('tbl_hotels');
				$query = $this->websiteDb->get();
				$data = $query->result_array();
//				pre($data[0]);
				$temp['website_name'] = $website['Name'];
				$temp['website_db'] = $web_site_db;
				$temp['total_states'] = $data[0]['total_states'];
				$temp['total_cities'] = $data[0]['total_cities'];
				$temp['total_hotels'] = $data[0]['total_hotels'];
				array_push($website_wise_cnt, $temp);
			}
//			pre($website_wise_cnt);
			$bg_colors = array('bg-soft-primary', 'bg-soft-secondary', 'bg-soft-success', 'bg-soft-info', 'bg-soft-warning', 'bg-soft-danger', 'bg-soft-dark');

			$this->load->view('v_system_analysis_dashboard', compact('website_wise_cnt', 'bg_colors'));
		}else {
			redirect('login');
		}
	}

	public function view_states(){
		$website_db = $this->uri->segment(2);
		if ($this->session->userdata('auth_key')) {
			$this->websiteDb = $this->load->database($website_db, true);
			$this->websiteDb->select('DISTINCT(state)');
			$this->websiteDb->from('tbl_hotels');
			$this->websiteDb->order_by('state', 'ASC');
			$query = $this->websiteDb->get();
			$all_states = $query->result_array();

			$this->load->view('v_view_all_states', compact('all_states', 'website_db'));
		}else {
			redirect('login');
		}
	}

	public function get_state_list(){
		$website_db = $this->uri->segment(2);
		$search_state = $this->input->post('search_state');

		if ($this->session->userdata('auth_key')) {
			$this->websiteDb = $this->load->database($website_db, true);
			$this->websiteDb->select('DISTINCT(state)');
			if (isset($search_state) && $search_state!=""){
				$this->websiteDb->where('state', $search_state);
			}
			$this->websiteDb->from('tbl_hotels');
			$this->websiteDb->order_by('state', 'ASC');
			$query = $this->websiteDb->get();
			$all_states = $query->result_array();

			echo json_encode(['status' => 1, "states" => $all_states, "website_db" => $website_db]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_city_list(){
		$website_db = $this->uri->segment(2);
		$states = $this->input->post('states');
		$search_state = $this->input->post('search_state');
		$search_city = $this->input->post('search_city');

		$page_no = (int)$this->uri->segment(3);

		if ($this->session->userdata('auth_key')) {
//			$this->websiteDb = $this->load->database($website_db, true);
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('count(DISTINCT(city_id)) as total_rows');
			$this->RateAndReviewDb->from('tbl_usa_cities');
			if (isset($states) && $states!="") {
				$this->RateAndReviewDb->where_in('state_code', $states);
			}
			if (isset($search_state) && $search_state!="") {
				$this->RateAndReviewDb->where('state_code', $search_state);
			}
			if (isset($search_city) && $search_city!="") {
				$this->RateAndReviewDb->where('city', $search_city);
			}
			$cnt = $this->RateAndReviewDb->get()->result_array();

			if ($page_no == 1){
				$offset = 1;
			}
			else{
				$offset = (($page_no-1) * 10) + 1;
			}

			$this->RateAndReviewDb->select('state_code,city,city_id');
			$this->RateAndReviewDb->group_by('state_code,city,city_id');
			$this->RateAndReviewDb->from('tbl_usa_cities');
			if (isset($states) && $states!="") {
				$this->RateAndReviewDb->where_in('state_code', $states);
			}
			if (isset($search_state) && $search_state!="") {
				$this->RateAndReviewDb->where('state_code', $search_state);
			}
			if (isset($search_city) && $search_city!="") {
				$this->RateAndReviewDb->where('city', $search_city);
			}
			if ($cnt[0]['total_rows'] > 10) {
				$this->RateAndReviewDb->limit(10, $offset);
			}
			$this->RateAndReviewDb->order_by('city', 'ASC');
			$query = $this->RateAndReviewDb->get();
			$cities = $query->result_array();

			/*foreach ($cities as &$city){
				$this->RateAndReviewDb->select('city');
				$this->RateAndReviewDb->from('tbl_usa_cities');
				$this->RateAndReviewDb->where_in('city_id', $city['city']);
				$get_city_result = $this->RateAndReviewDb->get();
				$city_data = $get_city_result->row_array();
				$city['city_name'] = $city_data['city'];
			}*/

			$pagination = "";
			if ($cnt[0]['total_rows'] > 10) {
				$pagination = pagination_links($cnt[0]['total_rows'], 10, base_url() . 'get_city_list/' . $website_db);
			}

			echo json_encode(['status' => 1, "cities" => $cities, "website_db" => $website_db, "pagination" => $pagination, "total_records" => $cnt[0]['total_rows']]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_hotel_list(){
		$website_db = $this->uri->segment(2);
		$cities = $this->input->post('cities');
		$search_state = $this->input->post('search_state');
		$search_city = $this->input->post('search_city');
		$search_hotel = $this->input->post('search_hotel');
		$search_scrape_time = $this->input->post('search_scrape_time');

		$page_no = (int)$this->uri->segment(3);

		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->websiteDb = $this->load->database($website_db, true);

			if (isset($search_city) && $search_city!="") {
				$this->RateAndReviewDb->select('city_id');
				$this->RateAndReviewDb->from('tbl_usa_cities');
				$this->RateAndReviewDb->where('city', $search_city);
				$get_city_result = $this->RateAndReviewDb->get();
				$city_data = $get_city_result->row_array();
				$search_city_id = (!empty($city_data)) ? $city_data['city_id'] : "";
			}
			if (isset($search_scrape_time) && $search_scrape_time!="") {
				$this->websiteDb->select('hotel_id');
				$this->websiteDb->from('tbl_pricing');
				$this->websiteDb->where('scrape_time', $search_scrape_time);
				$get_pricing_result = $this->websiteDb->get();
				$pricing_data = $get_pricing_result->row_array();
				$search_hotel_id = (!empty($pricing_data)) ? $pricing_data['hotel_id'] : "";
			}

			$this->websiteDb->select('count(DISTINCT(hotel_id)) as total_rows');
			$this->websiteDb->from('tbl_hotels');
			if (isset($cities) && $cities!="") {
				$this->websiteDb->where_in('city', $cities);
			}
			if (isset($search_state) && $search_state!=""){
				$this->websiteDb->where('state', $search_state);
			}
			if (isset($search_city_id) && $search_city_id!=""){
				$this->websiteDb->where('city', $search_city_id);
			}
			if (isset($search_hotel) && $search_hotel!=""){
				$this->websiteDb->where('hotel', $search_hotel);
			}
			if (isset($search_hotel_id) && $search_hotel_id!=""){
				$this->websiteDb->where('hotel_id', $search_hotel_id);
			}
			$cnt = $this->websiteDb->get()->result_array();

			if (isset($search_city) && $search_city!="" && (!isset($search_city_id) || $search_city_id=="")){
				$cnt[0]['total_rows'] = 0;
			}
			else if (isset($search_scrape_time) && $search_scrape_time!="" && (!isset($search_hotel_id) || $search_hotel_id=="")){
				$cnt[0]['total_rows'] = 0;
			}

			if ($page_no == 1){
				$offset = 1;
			}
			else{
				$offset = (($page_no-1) * 10) + 1;
			}

			$this->websiteDb->select('state,city,hotel_id,hotel');
			$this->websiteDb->group_by('state,city,hotel_id,hotel');
			$this->websiteDb->from('tbl_hotels');
			if (isset($cities) && $cities!="") {
				$this->websiteDb->where_in('city', $cities);
			}
			if (isset($search_state) && $search_state!=""){
				$this->websiteDb->where('state', $search_state);
			}
			if (isset($search_city_id) && $search_city_id!=""){
				$this->websiteDb->where('city', $search_city_id);
			}
			if (isset($search_hotel) && $search_hotel!=""){
				$this->websiteDb->where('hotel', $search_hotel);
			}
			if (isset($search_hotel_id) && $search_hotel_id!=""){
				$this->websiteDb->where('hotel_id', $search_hotel_id);
			}
			if ($cnt[0]['total_rows'] > 10) {
				$this->websiteDb->limit(10, $offset);
			}
			$this->websiteDb->order_by('hotel', 'ASC');
			$query = $this->websiteDb->get();
			$hotels = $query->result_array();

			if (isset($search_city) && $search_city!="" && (!isset($search_city_id) || $search_city_id=="")){
				$hotels = array();
			}
			else if (isset($search_scrape_time) && $search_scrape_time!="" && (!isset($search_hotel_id) || $search_hotel_id=="")){
				$hotels = array();
			}

			foreach ($hotels as &$hotel){
				$this->RateAndReviewDb->select('city');
				$this->RateAndReviewDb->from('tbl_usa_cities');
				$this->RateAndReviewDb->where_in('city_id', $hotel['city']);
				$get_city_result = $this->RateAndReviewDb->get();
				$city_data = $get_city_result->row_array();
				$hotel['city_name'] = $city_data['city'];

				$this->websiteDb->select('scrape_time');
				$this->websiteDb->from('tbl_pricing');
				$this->websiteDb->where('hotel_id', $hotel['hotel_id']);
				$get_pricing_result = $this->websiteDb->get();
				$pricing_data = $get_pricing_result->row_array();
				$hotel['scrape_time'] = (!empty($pricing_data)) ? $pricing_data['scrape_time'] : "";
			}

			$pagination = "";
			if ($cnt[0]['total_rows'] > 10) {
				$pagination = pagination_links($cnt[0]['total_rows'], 10, base_url() . 'get_hotel_list/' . $website_db);
			}

			echo json_encode(['status' => 1, "hotels" => $hotels, "website_db" => $website_db, "pagination" => $pagination, "total_records" => $cnt[0]['total_rows']]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function view_cities(){
		$website_db = $this->uri->segment(2);
		$page_no = 1;

		if ($this->session->userdata('auth_key')) {
//			$this->websiteDb = $this->load->database($website_db, true);
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('count(DISTINCT(city_id)) as total_rows');
			$this->RateAndReviewDb->from('tbl_usa_cities');
			$cnt = $this->RateAndReviewDb->get()->result_array();

			if ($page_no == 1){
				$offset = 1;
			}
			else{
				$offset = (($page_no-1) * 10) + 1;
			}

			$this->RateAndReviewDb->select('state_code,city,city_id');
			$this->RateAndReviewDb->group_by('state_code,city,city_id');
			$this->RateAndReviewDb->from('tbl_usa_cities');
			if ($cnt[0]['total_rows'] > 10) {
				$this->RateAndReviewDb->limit(10, $offset);
			}
			$this->RateAndReviewDb->order_by('city', 'ASC');
			$query = $this->RateAndReviewDb->get();
			$cities = $query->result_array();

			/*foreach ($cities as &$city){
				$this->RateAndReviewDb->select('city');
				$this->RateAndReviewDb->from('tbl_usa_cities');
				$this->RateAndReviewDb->where_in('city_id', $city['city']);
				$get_city_result = $this->RateAndReviewDb->get();
				$city_data = $get_city_result->row_array();
				$city['city_name'] = $city_data['city'];
			}*/

			$pagination = "";
			if ($cnt[0]['total_rows'] > 10) {
				$pagination = pagination_links($cnt[0]['total_rows'], 10, base_url() . 'get_city_list/' . $website_db);
			}

			$total_records = $cnt[0]['total_rows'];
			$this->load->view('v_view_all_cities', compact('cities', 'website_db', 'pagination', 'total_records'));
		}
		else {
			redirect('login');
		}
	}

	public function view_hotels(){
		$website_db = $this->uri->segment(2);
		$page_no = 1;

		if ($this->session->userdata('auth_key')) {
			$this->websiteDb = $this->load->database($website_db, true);
			$this->websiteDb->select('count(DISTINCT(hotel_id)) as total_rows');
			$this->websiteDb->from('tbl_hotels');
			$cnt = $this->websiteDb->get()->result_array();

			if ($page_no == 1){
				$offset = 1;
			}
			else{
				$offset = (($page_no-1) * 10) + 1;
			}

			$this->websiteDb->select('state,city,hotel_id,hotel');
			$this->websiteDb->group_by('state,city,hotel_id,hotel');
			$this->websiteDb->from('tbl_hotels');
			if ($cnt[0]['total_rows'] > 10) {
				$this->websiteDb->limit(10, $offset);
			}
			$this->websiteDb->order_by('hotel', 'ASC');
			$query = $this->websiteDb->get();
			$hotels = $query->result_array();

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			foreach ($hotels as &$hotel){
				$this->RateAndReviewDb->select('city');
				$this->RateAndReviewDb->from('tbl_usa_cities');
				$this->RateAndReviewDb->where_in('city_id', $hotel['city']);
				$get_city_result = $this->RateAndReviewDb->get();
				$city_data = $get_city_result->row_array();
				$hotel['city_name'] = $city_data['city'];

				$this->websiteDb->select('scrape_time');
				$this->websiteDb->from('tbl_pricing');
				$this->websiteDb->where('hotel_id', $hotel['hotel_id']);
				$get_pricing_result = $this->websiteDb->get();
				$pricing_data = $get_pricing_result->row_array();
				$hotel['scrape_time'] = (!empty($pricing_data)) ? $pricing_data['scrape_time'] : "";
			}

			$pagination = "";
			if ($cnt[0]['total_rows'] > 10) {
				$pagination = pagination_links($cnt[0]['total_rows'], 10, base_url() . 'get_hotel_list/' . $website_db);
			}

			$total_records = $cnt[0]['total_rows'];
			$this->load->view('v_view_all_hotels', compact('hotels', 'website_db', 'pagination', 'total_records'));
		}
		else {
			redirect('login');
		}
	}
}
