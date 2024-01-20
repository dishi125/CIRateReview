<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate_analysis extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			$data = array();
			//$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$data['tab_type'] = 'rate_analysis_tab';
			$tab_type = $this->uri->segment(3);
			if ($tab_type == "rate_analysis_tab") {
				$data['tab_type'] = 'rate_analysis_tab';
			} elseif ($tab_type == "website_analysis_tab") {
				$data['tab_type'] = 'website_analysis_tab';
			} elseif ($tab_type == "hotels_historical_rate_tab") {
				$data['tab_type'] = 'hotels_historical_rate_tab';
			} elseif ($tab_type == "website_historical_rate_tab") {
				$data['tab_type'] = 'website_historical_rate_tab';
			}

			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			if ($GetAllWebsite != "") {
				$GetAllWebsite = json_decode($GetAllWebsite, true);
				$data['websites'] = $GetAllWebsite;
			}

			$own_hotel_code = $this->session->userdata('own_hotel_code');

			$res_data = "";
			if (isset($own_hotel_code) && $own_hotel_code!="") {
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$res_data = $this->RateAndReviewDb->query("select rrh.* ,rrw.Name FROM RR_Hotel rrh left join RR_WebSiteList rrw on rrw.id=rrh.website where Website in (select id from RR_WebSiteList where website != 6) and UserId = " . $user_id . " and HotelCode='" . $own_hotel_code . "' and isdelete=0");
				$res_data = $res_data->result_array();
				$data['added_hotels'] = $res_data;
			}

			$this->load->view('v_rate_analysis', $data);
		} else {
			redirect('login');
		}
	}

	public function ajax_call()
	{
		$tab_type = $this->input->post('tab_type');
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}

		if ($this->session->userdata('auth_key')) {
			$html = "";
			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			if ($GetAllWebsite != "") {
				$GetAllWebsite = json_decode($GetAllWebsite, true);
				$data['GetAllWebsite'] = $GetAllWebsite;
			}

			$GetRoomTypeList = call_api_get($auth_key, 'Hotel/GetRoomTypeList');
			if ($GetRoomTypeList != "") {
				$GetRoomTypeList = json_decode($GetRoomTypeList, true);
				$data['GetRoomTypeList'] = $GetRoomTypeList;
			}

			if ($tab_type == "rate_analysis_tab") {
				/*$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$check_hotel_data = $this->RateAndReviewDb->query("select rrh.* ,rrw.Name FROM RR_Hotel rrh left join RR_WebSiteList rrw on rrw.id= rrh.website where Website in (select id from RR_WebSiteList where website != 6) and UserId = 10 and isdelete =0 ");
				pre($check_hotel_data->result_array());*/
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetHotelReviewRateCompareChart = call_chart_api($auth_key, 'Customer/GetHotelReviewRateCompareChart?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
					if ($GetHotelReviewRateCompareChart != "") {
						$GetHotelReviewRateCompareChart = json_decode($GetHotelReviewRateCompareChart, true);
						$websites = $GetHotelReviewRateCompareChart['Table'];
						$hotel_rates = $GetHotelReviewRateCompareChart['Table1'];
						$data['websites'] = $websites;
						$data['hotel_rates'] = $hotel_rates;
					}
				}

				$page_no = 1;
				$rowperpage = 10;
				$GetDashboardHotelList = "";
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=1&highlow=0&days=1&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode'] . '&PageNumber=1&RowsOfPage=200');
				}
				if ($GetDashboardHotelList != "") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
					$GetDashboardHotelList = $GetDashboardHotelList['Table'];
					$data['GetDashboardHotelList'] = $GetDashboardHotelList;
				}
				/*$GetDashboardHotelList = call_api_get($auth_key,'Customer/GetDashboardHotelList?websiteId=1&roomtypeId=1&highlow=0&days=1&UserId='.$user_id.'&currentPage=1&pageSize=10');
				if($GetDashboardHotelList!="") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
					$data['GetDashboardHotelList'] = $GetDashboardHotelList;
				}*/
				$pagination = "";
				if (isset($GetDashboardHotelList) && !empty($GetDashboardHotelList) && $GetDashboardHotelList != "") {

					$allcount = $GetDashboardHotelList[0]['totalcount'];

					$config['base_url'] = base_url() . 'rate_analysis/filter_data';
					$config['use_page_numbers'] = TRUE;
					$config['total_rows'] = $allcount;
					$config['per_page'] = $rowperpage;
					$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
					$config['full_tag_close'] = '</ul></nav></div>';
					$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['num_tag_close'] = '</span></li>';
					$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
					$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
					$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
					$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['prev_tag_close'] = '</span></li>';
					$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['first_tag_close'] = '</span></li>';
					$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['last_tag_close'] = '</span></li>';
					$this->pagination->initialize($config);
					$pagination = $this->pagination->create_links();
					$result = $GetDashboardHotelList;
				}
				$data['pagination'] = $pagination;
				$html = $this->load->view('rate_analysis_graph_table', $data, TRUE);
			}
			elseif ($tab_type == "website_analysis_tab") {
				$page_no = 1;
				$rowperpage = 10;
				//own
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
				$this->RateAndReviewDb->where('IsDelete', 0);
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
				}
				$this->RateAndReviewDb->group_by('SystemHotel');
				$this->RateAndReviewDb->group_by('MappedHotelName');
				$this->RateAndReviewDb->group_by('IsCompetitorHotel');
				$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
				$own_hotel = $this->RateAndReviewDb->get();
				$own_hotel = $own_hotel->result_array();
				$ownGetDashboardHotelList = "";
				$ownhotelName = "";
				if (!empty($own_hotel) && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$ownhotelName = $own_hotel[0]['MappedHotelName'];
					$ownGetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&UserId=' . $user_id . '&hotelname=' . $ownhotelName . '&PageNumber=' . $page_no . '&hotelcode=' . $request['hotelCode'] . '&RowsOfPage=' . $rowperpage);
					if ($ownGetDashboardHotelList != "") {
						$ownGetDashboardHotelList = json_decode($ownGetDashboardHotelList, true);
					}
				}

				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel,website');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 1);
				$this->RateAndReviewDb->where('website', 1);
				$this->RateAndReviewDb->where('IsDelete', 0);
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
				}
				$this->RateAndReviewDb->group_by('SystemHotel');
				$this->RateAndReviewDb->group_by('MappedHotelName');
				$this->RateAndReviewDb->group_by('IsCompetitorHotel,website');
				$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
				$competitor_hotels = $this->RateAndReviewDb->get();
				$competitor_hotels = $competitor_hotels->result_array();
				$data['competitor_hotels'] = $competitor_hotels;

				if (isset($request['hotelCode']) && !empty($request['hotelCode'])) {
					$GetHotelReviewRateCompareChartByWebsite = call_chart_api($auth_key, 'Customer/GetHotelReviewRateCompareChartByWebsite?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&websiteid=' . $request['websiteId'] . '&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode']);
					if ($GetHotelReviewRateCompareChartByWebsite != "") {
						$GetHotelReviewRateCompareChartByWebsite = json_decode($GetHotelReviewRateCompareChartByWebsite, true);
						$data['GetHotelReviewRateCompareChartByWebsite'] = $GetHotelReviewRateCompareChartByWebsite['Table'];
					}
				}

				$hotel_name = (isset($competitor_hotels) && isset($competitor_hotels[0]['MappedHotelName'])) ? $competitor_hotels[0]['MappedHotelName'] : '';
				$GetDashboardHotelList = "";
				if ($hotel_name != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=1&highlow=0&days=1&UserId=' . $user_id . '&hotelname=' . $hotel_name . '&hotelcode=' . $request['hotelCode'] . '&PageNumber=1&RowsOfPage=10');
					if ($GetDashboardHotelList != "") {
						$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
						$GetDashboardHotelList = $GetDashboardHotelList['Table'];
						$ownGetDashboardHotelList = $ownGetDashboardHotelList['Table'];
						$GetDashboardHotelList = array_merge($ownGetDashboardHotelList, $GetDashboardHotelList);
						$data['GetDashboardHotelList'] = $GetDashboardHotelList;
					}
				}

				$pagination = "";
				if (isset($GetDashboardHotelList) && !empty($GetDashboardHotelList) && $GetDashboardHotelList != "") {
					$allcount = $GetDashboardHotelList[0]['totalcount'];
					$pagination = pagination_links($allcount, 10, base_url() . 'website_analysis/filter_data_hotelwise');
				}
				$data['pagination'] = $pagination;

				$GetDashboardHotelList = "";
				if (isset($hotel_name) && $hotel_name != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=1&highlow=0&days=1&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode'] . '&hotelname=' . $hotel_name);
				}
				$ownGetDashboardHotelList = "";
				if (isset($ownhotelName) && $ownhotelName != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$ownGetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=1&highlow=0&days=1&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode'] . '&hotelname=' . $ownhotelName);
				}

				if ($GetDashboardHotelList != "") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
				}
				if ($ownGetDashboardHotelList != "") {
					$ownGetDashboardHotelList = json_decode($ownGetDashboardHotelList, true);
				}

				$data['chart_data'] = ($ownGetDashboardHotelList != "" && $GetDashboardHotelList != "") ? array_merge($ownGetDashboardHotelList['Table'], $GetDashboardHotelList['Table']) : ($ownGetDashboardHotelList != "" ? $ownGetDashboardHotelList['Table'] : ($GetDashboardHotelList != "" ? $GetDashboardHotelList['Table'] : ""));

				$html = $this->load->view('website_analysis_graph_table', $data, TRUE);
			}
			elseif ($tab_type == "hotels_historical_rate_tab") {
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 1);
				$this->RateAndReviewDb->where('website', 1);
				$this->RateAndReviewDb->where('IsDelete', 0);
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
				}
				$this->RateAndReviewDb->group_by('SystemHotel');
				$this->RateAndReviewDb->group_by('MappedHotelName');
				$this->RateAndReviewDb->group_by('IsCompetitorHotel');
				$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
				$competitor_hotels = $this->RateAndReviewDb->get();
				$competitor_hotels = $competitor_hotels->result_array();
				$hotelId = "";
				if (isset($competitor_hotels) && !empty($competitor_hotels)) {
					$data['Hoteldropdownfilter'] = $competitor_hotels;
					$hotelId = $competitor_hotels[0]['SystemHotel'];
				}

				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					if ($hotelId != "") {
						$HistoricalData = call_api_get($auth_key, 'Customer/GetDashboardHistoricalDataByHotels?hotelId=' . $hotelId . '&siteID=' . $request['websiteId'] . '&roomType=' . $request['roomTypeId'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
					} else {
						$HistoricalData = call_api_get($auth_key, 'Customer/GetDashboardHistoricalDataByHotels?siteID=' . $request['websiteId'] . '&roomType=' . $request['roomTypeId'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
					}
					if ($HistoricalData != "") {
						$HistoricalData = json_decode($HistoricalData, true);
						$scrape_dates = array_column($HistoricalData, 'scrapedate');
						$data['scrape_dates'] = array_map(function ($v) {
							return date("m/d/Y h:i A", strtotime($v));
						}, $scrape_dates);
					}
					if (!empty($HistoricalData) && $HistoricalData != "") {
						$competitorHistoricalData = array_filter($HistoricalData, function ($var) {
							return ($var['IscompetitorHotel'] == 1);
						});
						$ownHistoricalData = array_filter($HistoricalData, function ($var) {
							return ($var['IscompetitorHotel'] != 1);
						});
						$data['competitorHistoricalData'] = array_values($competitorHistoricalData);
						$data['ownHistoricalData'] = array_values($ownHistoricalData);
					}
				}

				$html = $this->load->view('hotels_historical_rate_graph_table', $data, TRUE);
			}
			elseif ($tab_type == "website_historical_rate_tab") {
				//			$curMonth = date('F');
				//			$curYear  = date('Y');
				//			$timestamp = strtotime($curMonth.' '.$curYear);
				$start_date = date('Y-m-01');
				$end_date = date('Y-m-t');

				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetWebsiteHistoricalRate = call_api_get($auth_key, 'rate/GetWebsiteHistoricalRate?websiteId=' . $request['websiteId'] . '&startDate=' . $start_date . '&endDate=' . $end_date . '&hotelcode=' . $request['hotelCode'] . '&UserId=' . $user_id);
					if ($GetWebsiteHistoricalRate != "") {
						$GetWebsiteHistoricalRate = json_decode($GetWebsiteHistoricalRate, true);
						$data['GetWebsiteHistoricalRate'] = $GetWebsiteHistoricalRate['Table'];
					}
				}
				//			pre($GetWebsiteHistoricalRate);
				$html = $this->load->view('website_historical_rate_graph_table', $data, TRUE);
			}

//			return $html;
			echo json_encode(['status' => 1, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function ajax_website_historical_rate()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$tab_type = $this->input->post('tab_type');
			$request = $this->input->post();
			$user_id = $this->session->userdata('user_id');
			if (isset($request['userId']) && $request['userId'] != "") {
				$user_id = $request['userId'];
			}

			if ($tab_type == "calender_view") {
				/*$curMonth = date('F');
				$curYear  = date('Y');
				$timestamp = strtotime($curMonth.' '.$curYear);
				$start_date = date('Y-m-01', $timestamp);
				$end_date  = date('Y-m-t', $timestamp);*/
				$start_date = date('Y-m-01');
				$end_date = date('Y-m-t');

				$GetWebsiteHistoricalRate = "";
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetWebsiteHistoricalRate = call_api_get($auth_key, 'rate/GetWebsiteHistoricalRate?websiteId=' . $request['websiteId'] . '&startDate=' . $start_date . '&endDate=' . $end_date . '&hotelcode=' . $request['hotelCode'] . '&UserId=' . $user_id);
					if ($GetWebsiteHistoricalRate != "") {
						$GetWebsiteHistoricalRate = json_decode($GetWebsiteHistoricalRate, true);
						$GetWebsiteHistoricalRate = $GetWebsiteHistoricalRate['Table'];
					}
				}
				//print_r($GetWebsiteHistoricalRate);
				echo json_encode(['status' => 1, 'event_data' => $GetWebsiteHistoricalRate]);
				die();
			} else if ($tab_type == "table_view") {
				$page_no = 1;
				$rowperpage = 10;
				$start_date = date('Y-m-d');
				$end_date = date("Y-m-d", strtotime("+ 1 day"));

				$getDateWiseBookingDetails = "";
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$getDateWiseBookingDetails = call_api_get($auth_key, 'rate/getDateWiseBookingDetails?websiteId=' . $request['websiteId'] . '&startDate=' . $start_date . '&endDate=' . $end_date . '&hotelcode=' . $request['hotelCode'] . '&currentPage=1&pageSize=10&UserId=' . $user_id);
					if ($getDateWiseBookingDetails != "") {
						$getDateWiseBookingDetails = json_decode($getDateWiseBookingDetails, true);
					}
				}
				$table_data = "";
				$pagination = "";
				if ($getDateWiseBookingDetails != "" && !empty($getDateWiseBookingDetails) && !empty($getDateWiseBookingDetails['Table'])) {
					$array_index_last = count($getDateWiseBookingDetails['Table']) - 1;
					$allcount = $getDateWiseBookingDetails['Table'][$array_index_last]['TotRows'];

					$config['base_url'] = base_url() . 'website_historical_rate/filter_data';
					$config['use_page_numbers'] = TRUE;
					$config['total_rows'] = $allcount;
					$config['per_page'] = $rowperpage;
					$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
					$config['full_tag_close'] = '</ul></nav></div>';
					$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['num_tag_close'] = '</span></li>';
					$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
					$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
					$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
					$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['prev_tag_close'] = '</span></li>';
					$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['first_tag_close'] = '</span></li>';
					$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
					$config['last_tag_close'] = '</span></li>';
					$this->pagination->initialize($config);
					$pagination = $this->pagination->create_links();
					$result = $getDateWiseBookingDetails['Table'];

					foreach ($getDateWiseBookingDetails['Table'] as $booking_data) {
						$table_data .= '<tr>
									<td>' . $booking_data['hotel'] . '</td>
									<td>' . date('d/m/Y', strtotime($booking_data['check_in'])) . '</td>
									<td>' . $booking_data['price'] . '</td>
									<td>' . $booking_data['no_of_person'] . '</td>
									<td>' . $booking_data['room_type'] . '</td>
								</tr>';
					}
				} else {
					$table_data .= '<tr>
									<td colspan="5" style="text-align: center">No records found</td>
								</tr>';
				}

				$html = '<div class="row">
					<div class="col-8"></div>
					<div class="col-4 mb-3"><input type="text" id="filter_date" class="form-control" readonly="readonly"></div>
					</div>
					<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered align-middle table-nowrap mb-0" id="website_historical_rate_table_data">
							<thead>
							<tr>
								<th scope="col">Hotel Name</th>
								<th scope="col">Date</th>
								<th scope="col">Price</th>
								<th scope="col">No. of Person</th>
								<th scope="col">Room Type</th>
							</tr>
							</thead>
							<tbody>' . $table_data . '</tbody>
						</table>
						<div id="pagination_website_historical_rate" style="float: right" class="mt-2">' . $pagination . '</div>
					</div></div>';

				echo json_encode(['status' => 1, 'table_view_html' => $html]);
				die();
			}
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_data()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}
		$page_no = $request['page_no'];
		$rowperpage = 100;

		if ($this->session->userdata('auth_key')) {
			$GetDashboardHotelList = "";
			if ($request['websiteId'] == "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode'] . '&PageNumber=' . $page_no . '&RowsOfPage=' . $rowperpage);
				if ($GetDashboardHotelList != "") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
					$GetDashboardHotelList = $GetDashboardHotelList['Table'];
				}
			} else {
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetDashboardHotelList = call_api_get($auth_key, 'Customer/GetDashboardHotelList?websiteId=' . $request['websiteId'] . '&roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&UserId=' . $user_id . '&hotelcode=' . $request['hotelCode'] . '&currentPage=' . $page_no . '&pageSize=100');
					if ($GetDashboardHotelList != "") {
						$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
					}
				}
			}

			$pagination = "";
			$html = "";
			if (isset($GetDashboardHotelList) && !empty($GetDashboardHotelList) && $GetDashboardHotelList != "") {
				$allcount = $GetDashboardHotelList[0]['totalcount'];

				$config['base_url'] = base_url() . 'rate_analysis/filter_data';
				$config['use_page_numbers'] = TRUE;
				$config['total_rows'] = $allcount;
				$config['per_page'] = $rowperpage;
				$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav></div>';
				$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['num_tag_close'] = '</span></li>';
				$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
				$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
				$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
				$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['prev_tag_close'] = '</span></li>';
				$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['first_tag_close'] = '</span></li>';
				$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['last_tag_close'] = '</span></li>';
				$this->pagination->initialize($config);
				$pagination = $this->pagination->create_links();
				$result = $GetDashboardHotelList;

				$html = '';
				foreach ($GetDashboardHotelList as $hotel) {
					if ($hotel['CRate'] == "-1") {
						$CRate = "Sold Out";
					} elseif ($hotel['CRate'] == "-2") {
						$CRate = "Not Available";
					} else {
						$CRate = '$' . round($hotel['CRate']);
					}

					if ($hotel['Rate'] == "-1") {
						$rate = "Sold Out";
					} elseif ($hotel['Rate'] == "-2") {
						$rate = "Not Available";
					} else {
						$rate = '$' . round($hotel['Rate']);
					}

					if ($hotel['CRate'] != "-1" && $hotel['CRate'] != "-2" && $hotel['Rate'] != "-1" && $hotel['Rate'] != "-2") {
						$change = round($hotel['CRate'] - $hotel['Rate']);
					} else {
						$change = $hotel['Rate'];
					}
					//$change = $hotel['CRate'] - $hotel['Rate'];
					if ($change == "-1") {
						$change = "Sold Out";
					} elseif ($change == "-2") {
						$change = "Not Available";
					} else {
						if ($hotel['CRate'] > $hotel['Rate']) {
							$change = '<p style="color: limegreen; margin: 0"><i class="ri-arrow-up-s-fill" style="font-size: large"></i>+$' . $change . '</p>';
						} else if ($hotel['CRate'] < $hotel['Rate']) {
							$change = '<p style="color: red; margin: 0"><i class="ri-arrow-down-s-fill" style="font-size: large"></i>-$' . $change . '</p>';
						} else {
							$change = '$' . round($change);
						}
					}

					$style = "";
					if ($hotel['IsCompetitorHotel'] == 0) {
						$style = "color: darkblue";
					}

					$html .= '<tr style="' . $style . '">
							<td>' . $hotel['HotelName'] . '</td>
							<td>' . $hotel['WebSite'] . '</td>
							<td>' . $hotel['OriginalRoomType'] . '</td>
							<td>' . $CRate . '</td>
							<td>1 Day</td>
							<td>' . $rate . '</td>
							<td>' . $change . '</td>
						</tr>';
				}
			} else {
				$html .= '<tr>
						<td colspan="7" style="text-align: center">No Records Found</td>
					</tr>';
			}

			echo json_encode(['status' => 1, 'pagination' => $pagination, 'html' => $html]);
			exit;
		}
		else{
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_website_historical_rate_data()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$user_id = $this->session->userdata('user_id');
			if (isset($request['userId']) && $request['userId'] != "") {
				$user_id = $request['userId'];
			}

			if (isset($_REQUEST['date'])) {
				$dates = explode(" - ", $_REQUEST['date']);
				$get_start = strtotime($dates[0]);
				$start_date = date('Y-m-d', $get_start);

				$get_end = strtotime($dates[1]);
				$end_date = date('Y-m-d', $get_end);
			}

			$page_no = $request['page_no'];
			$rowperpage = 10;
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$getDateWiseBookingDetails = call_api_get($auth_key, 'rate/getDateWiseBookingDetails?websiteId=' . $request['websiteId'] . '&startDate=' . $start_date . '&endDate=' . $end_date . '&currentPage=' . $page_no . '&hotelcode=' . $request['hotelCode'] . '&pageSize=10&UserId=' . $user_id);
				if ($getDateWiseBookingDetails != "") {
					$getDateWiseBookingDetails = json_decode($getDateWiseBookingDetails, true);
				}
			}

			$pagination = "";
			$html = "";
			if ($getDateWiseBookingDetails != "" && !empty($getDateWiseBookingDetails['Table'])) {
				$array_index_last = count($getDateWiseBookingDetails['Table']) - 1;
				$allcount = $getDateWiseBookingDetails['Table'][$array_index_last]['TotRows'];

				$config['base_url'] = base_url() . 'website_historical_rate/filter_data';
				$config['use_page_numbers'] = TRUE;
				$config['total_rows'] = $allcount;
				$config['per_page'] = $rowperpage;
				$config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav></div>';
				$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['num_tag_close'] = '</span></li>';
				$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
				$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
				$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
				$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['prev_tag_close'] = '</span></li>';
				$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['first_tag_close'] = '</span></li>';
				$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
				$config['last_tag_close'] = '</span></li>';
				$this->pagination->initialize($config);
				$pagination = $this->pagination->create_links();
				$result = $getDateWiseBookingDetails['Table'];

				$html = '';
				foreach ($getDateWiseBookingDetails['Table'] as $booking_data) {
					$html .= '<tr>
							<td>' . $booking_data['hotel'] . '</td>
							<td>' . date('d/m/Y', strtotime($booking_data['check_in'])) . '</td>
							<td>' . $booking_data['price'] . '</td>
							<td>' . $booking_data['no_of_person'] . '</td>
							<td>' . $booking_data['room_type'] . '</td>
						</tr>';
				}
			} else {
				$html .= '<tr><td colspan="5" style="text-align: center">No records found</td></tr>';
			}

			echo json_encode(['status' => 1, 'pagination' => $pagination, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_calender_data()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$user_id = $this->session->userdata('user_id');
			if (isset($request['userId']) && $request['userId'] != "") {
				$user_id = $request['userId'];
			}
			$end_date = date('Y-m-d', strtotime('-1 day', strtotime($request['end_date'])));
			//	print_r($end_date);
			//$start_date = date('Y-m-01', $timestamp);
			//$end_date  = date('Y-m-t', $timestamp);
			$GetWebsiteHistoricalRate = "";
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$GetWebsiteHistoricalRate = call_api_get($auth_key, 'rate/GetWebsiteHistoricalRate?websiteId=' . $request['websiteId'] . '&startDate=' . $request['start_date'] . '&endDate=' . $end_date . '&hotelcode=' . $request['hotelCode'] . '&UserId=' . $user_id);
				if ($GetWebsiteHistoricalRate != "") {
					$GetWebsiteHistoricalRate = json_decode($GetWebsiteHistoricalRate, true);
					$GetWebsiteHistoricalRate = $GetWebsiteHistoricalRate['Table'];
				}
			}
			echo json_encode(['status' => 1, 'event_data' => $GetWebsiteHistoricalRate]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function getDateWiseBookingDetails()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$request = $this->input->post();
			$user_id = $this->session->userdata('user_id');
			if (isset($request['userId']) && $request['userId'] != "") {
				$user_id = $request['userId'];
			}

			$getDateWiseBookingDetails = "";
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$getDateWiseBookingDetails = call_api_get($auth_key, 'rate/getDateWiseBookingDetails?websiteId=' . $request['websiteId'] . '&startDate=' . $request['eventDate'] . '&endDate=' . $request['eventDate'] . '&hotelcode=' . $request['hotelCode'] . '&currentPage=1&pageSize=0&UserId=' . $user_id);
			}
			$table_data = "";
			if ($getDateWiseBookingDetails != "") {
				$getDateWiseBookingDetails = json_decode($getDateWiseBookingDetails, true);
				$keys = array_column($getDateWiseBookingDetails['Table'], 'hotel_id');
				array_multisort($keys, SORT_ASC, $getDateWiseBookingDetails['Table']);
				$first_hotel_id = 0;
				foreach ($getDateWiseBookingDetails['Table'] as $bookingDetail) {
					$rowspan = array_count_values(array_column($getDateWiseBookingDetails['Table'], 'hotel_id'))[$bookingDetail['hotel_id']];

					if ($first_hotel_id == $bookingDetail['hotel_id']) {
						$table_data .= '<tr>
								<td>' . $bookingDetail['price'] . '</td>
								<td>' . $bookingDetail['no_of_person'] . '</td>
								<td>' . $bookingDetail['room_type'] . '</td>
							  </tr>';
					} else {
						$table_data .= '<tr>
								<td rowspan="' . $rowspan . '">' . $bookingDetail['hotel'] . '</td>
								<td>' . $bookingDetail['price'] . '</td>
								<td>' . $bookingDetail['no_of_person'] . '</td>
								<td>' . $bookingDetail['room_type'] . '</td>
							  </tr>';
					}
					$first_hotel_id = $bookingDetail['hotel_id'];
				}
			}

			if ($table_data == "") {
				$table_data .= '<tr>
								<td colspan="4" style="text-align: center">No records found</td>
						  </tr>';
			}

			$html = '<table class="table table-bordered align-middle table-nowrap mb-0" id="website_historical_table">
						<thead>
						<tr>
							<th scope="col">Hotel Name</th>
							<th scope="col">Price</th>
							<th scope="col">No. of Person</th>
							<th scope="col">Room Type</th>
						</tr>
						</thead>
						<tbody>' . $table_data . '</tbody>
					</table>';

			$date = date_create($request['eventDate']);
			$date = date_format($date, "l, F j, Y");
			echo json_encode(['status' => 1, 'html' => $html, 'date' => $date]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_chart()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}

		if ($this->session->userdata('auth_key')) {
			$GetHotelReviewRateCompareChart = "";
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$GetHotelReviewRateCompareChart = call_chart_api($auth_key, 'Customer/GetHotelReviewRateCompareChart?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
			}
			$websites = "";
			$hotel_rates = "";
			if ($GetHotelReviewRateCompareChart != "") {
				$GetHotelReviewRateCompareChart = json_decode($GetHotelReviewRateCompareChart, true);
				$websites = $GetHotelReviewRateCompareChart['Table'];
				$hotel_rates = $GetHotelReviewRateCompareChart['Table1'];
			}
			echo json_encode(['status' => 1, 'websites' => $websites, 'hotel_rates' => $hotel_rates]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_website_analysis_chart()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}

		if ($this->session->userdata('auth_key')) {
			$GetHotelReviewRateCompareChartByWebsite = "";
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$GetHotelReviewRateCompareChartByWebsite = call_chart_api($auth_key, 'Customer/GetHotelReviewRateCompareChartByWebsite?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&websiteid=' . $request['websiteId'] . '&UserId=' . $user_id);
				if ($GetHotelReviewRateCompareChartByWebsite != "") {
					$GetHotelReviewRateCompareChartByWebsite = json_decode($GetHotelReviewRateCompareChartByWebsite, true);
					$GetHotelReviewRateCompareChartByWebsite = $GetHotelReviewRateCompareChartByWebsite['Table'];
				}
			}

			$html = "";
			if (isset($GetHotelReviewRateCompareChartByWebsite) && !empty($GetHotelReviewRateCompareChartByWebsite) && $GetHotelReviewRateCompareChartByWebsite != "") {
				foreach ($GetHotelReviewRateCompareChartByWebsite as $hotel) {
					if ($hotel['value'] == "-1") {
						$price = "Sold Out";
					} elseif ($hotel['value'] == "-2") {
						$price = "Not Available";
					} else {
						$price = '$' . round($hotel['value']);
					}

					$style = "";
					if ($hotel['IsCompetitorHotel'] != 1) {
						$style = "color: darkblue";
					}

					if ($hotel['IsCompetitorHotel'] == 1) {
						$type = 'Competitor';
					} else {
						$type = 'Own';
					}

					$html .= '<tr style="' . $style . '">
								<td>' . $hotel['HotelName'] . '</td>
								<td>' . $price . '</td>
								<td>' . $hotel['MappedRoom'] . '</td>
								<td>' . $hotel['ActualRoomType'] . '</td>
								<td>' . $type . '</td>
						 </tr>';
				}
			} else {
				$html .= '<tr>
							<td colspan="4" style="text-align: center">No Records Found</td>
					  </tr>';
			}

			echo json_encode(['status' => 1, 'data' => $GetHotelReviewRateCompareChartByWebsite, 'html' => $html]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function Hoteldropdownfilter()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$Hoteldropdownfilter = call_api_get($auth_key, 'Hotel/Hoteldropdownfilter?siteid=' . $request['websiteId']);
		if ($Hoteldropdownfilter != "") {
			$Hoteldropdownfilter = json_decode($Hoteldropdownfilter, true);
		}
		echo json_encode(['hotels' => $Hoteldropdownfilter]);
		die();
	}

	public function filter_hotels_historical_rate_data()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}

		if ($this->session->userdata('auth_key')) {
			$hotel_id = isset($request['hotelId']) ? $request['hotelId'] : "";
			$hotel_dropdown_html = "";
			if (isset($request['is_change_hotels']) && $request['is_change_hotels'] == "true") {
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 1);
				$this->RateAndReviewDb->where('website', $request['websiteId']);
				$this->RateAndReviewDb->where('IsDelete', 0);
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
				}
				$this->RateAndReviewDb->group_by('SystemHotel');
				$this->RateAndReviewDb->group_by('MappedHotelName');
				$this->RateAndReviewDb->group_by('IsCompetitorHotel');
				$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
				$competitor_hotels = $this->RateAndReviewDb->get();
				$competitor_hotels = $competitor_hotels->result_array();
				$Hoteldropdownfilter = $competitor_hotels;
				if ($Hoteldropdownfilter != "" && !empty($Hoteldropdownfilter)) {
					$hotel_id = $Hoteldropdownfilter[0]['SystemHotel'];
				} else {
					$hotel_id = "";
				}

				if (isset($Hoteldropdownfilter) && !empty($Hoteldropdownfilter)) {
					foreach ($Hoteldropdownfilter as $key => $hotel) {
						$selected = "";
						if ($key == 0) {
							$selected = "selected";
						}
						$hotel_dropdown_html .= '<option value="' . $hotel['SystemHotel'] . '" ' . $selected . '>' . $hotel['MappedHotelName'] . '</option>';
					}
				} else {
					$hotel_dropdown_html .= '<option value="" selected disabled>No competitor\'s hotels found</option>';
				}
			}

			$scrape_dates = "";
			$HistoricalData = "";
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				if ($hotel_id != "") {
					$HistoricalData = call_api_get($auth_key, 'Customer/GetDashboardHistoricalDataByHotels?hotelId=' . $hotel_id . '&siteID=' . $request['websiteId'] . '&roomType=' . $request['roomTypeId'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
				} else {
					$HistoricalData = call_api_get($auth_key, 'Customer/GetDashboardHistoricalDataByHotels?siteID=' . $request['websiteId'] . '&roomType=' . $request['roomTypeId'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id);
				}
				if ($HistoricalData != "") {
					$HistoricalData = json_decode($HistoricalData, true);
					$scrape_dates = array_column($HistoricalData, 'scrapedate');
					$scrape_dates = array_map(function ($v) {
						return date("m/d/Y h:i A", strtotime($v));
					}, $scrape_dates);
				}
			}

			$competitorHistoricalData = "";
			$ownHistoricalData = "";
			if (!empty($HistoricalData) && $HistoricalData != "") {
				$competitorHistoricalData = array_filter($HistoricalData, function ($var) {
					return ($var['IscompetitorHotel'] == 1);
				});
				$ownHistoricalData = array_filter($HistoricalData, function ($var) {
					return ($var['IscompetitorHotel'] != 1);
				});
				$competitorHistoricalData = array_values($competitorHistoricalData);
				$ownHistoricalData = array_values($ownHistoricalData);
			}

			$competitor_html = "";
			if (isset($competitorHistoricalData) && !empty($competitorHistoricalData) && $competitorHistoricalData != "") {
				$all_dates_cnt = array_count_values(array_column($competitorHistoricalData, 'date'));
				$competitor_date_html = "";
				foreach ($all_dates_cnt as $key => $val) {
					$competitor_date_html .= '<th colspan="' . $val . '" style="text-align: center">' . $key . '</th>';
				}
				$competitor_time_html = "";
				foreach ($competitorHistoricalData as &$competitor_data) {
					$competitor_data['scrapedate'] = date("m/d/Y h:i A", strtotime($competitor_data['scrapedate']));
					$competitor_data['time'] = date("g:i A", strtotime($competitor_data['time']));
					$competitor_time_html .= '<th>' . $competitor_data['time'] . '</th>';
				}
				$competitor_price_html = "";
				foreach ($competitorHistoricalData as &$competitor_data) {
					$competitor_data['price'] = round((float)$competitor_data['price']);
					if ($competitor_data['price'] == "-1") {
						$price = "Sold Out";
					} elseif ($competitor_data['price'] == "-2") {
						$price = "Not Available";
					} else {
						$price = '$' . $competitor_data['price'];
					}
					$competitor_price_html .= '<td>' . $price . '</td>';
				}
				$competitor_html .= '<thead>
						<tr>
							<th rowspan="2" style="text-align: center; vertical-align: middle">Competitor Hotel</th>
							' . $competitor_date_html . '
						</tr>
						<tr>
							' . $competitor_time_html . '
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>' . $competitorHistoricalData[0]['hotelname'] . '</td>
							' . $competitor_price_html . '
						</tr>
						</tbody>';
			} else {
				$competitor_html .= '<tbody>
						<tr>
							<td>Competitor Historical Data</td>
						</tr>
						<tr>
							<td style="text-align: center">No records found</td>
						</tr>
						</tbody>';
			}

			$own_html = "";
			if (isset($ownHistoricalData) && !empty($ownHistoricalData) && $ownHistoricalData != "") {
				$all_dates_cnt = array_count_values(array_column($ownHistoricalData, 'date'));
				$own_date_html = "";
				foreach ($all_dates_cnt as $key => $val) {
					$own_date_html .= '<th colspan="' . $val . '" style="text-align: center">' . $key . '</th>';
				}
				$own_time_html = "";
				foreach ($ownHistoricalData as &$own_data) {
					$own_data['scrapedate'] = date("m/d/Y h:i A", strtotime($own_data['scrapedate']));
					$own_data['time'] = date("g:i A", strtotime($own_data['time']));
					$own_time_html .= '<th>' . $own_data['time'] . '</th>';
				}
				$own_price_html = "";
				foreach ($ownHistoricalData as &$own_data) {
					$own_data['price'] = round((float)$own_data['price']);
					if ($own_data['price'] == "-1") {
						$price = "Sold Out";
					} elseif ($own_data['price'] == "-2") {
						$price = "Not Available";
					} else {
						$price = '$' . $own_data['price'];
					}
					$own_price_html .= '<td>' . $price . '</td>';
				}
				$own_html .= '<thead>
						<tr>
							<th rowspan="2" style="text-align: center; vertical-align: middle">Own Hotel</th>
							' . $own_date_html . '
						</tr>
						<tr>
							' . $own_time_html . '
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>' . $ownHistoricalData[0]['hotelname'] . '</td>
							' . $own_price_html . '
						</tr>
						</tbody>';
			} else {
				$own_html .= '<tbody>
						<tr>
							<td>Own Historical Data</td>
						</tr>
						<tr>
							<td style="text-align: center">No records found</td>
						</tr>
						</tbody>';
			}

			echo json_encode(['status' => 1, 'scrape_dates' => $scrape_dates, 'ownHistoricalData' => $ownHistoricalData, 'competitorHistoricalData' => $competitorHistoricalData, 'own_html' => $own_html, 'competitor_html' => $competitor_html, 'hotel_dropdown_html' => $hotel_dropdown_html]);
			exit;
		}
		else{
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function filter_data_hotelwise()
	{
		$auth_key = $this->session->userdata('auth_key');
		$request = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		if (isset($request['userId']) && $request['userId'] != "") {
			$user_id = $request['userId'];
		}
		$hotelName = isset($request['hotelName']) ? $request['hotelName'] : "";
		$page_no = $request['page_no'];
		$rowperpage = 10;

		if ($this->session->userdata('auth_key')) {
			$competitor_hotels = "";
			if ($request['is_change_hotels'] == "true") {
				$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
				$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel');
				$this->RateAndReviewDb->from('RR_Hotel');
				$this->RateAndReviewDb->where('UserId', $user_id);
				$this->RateAndReviewDb->where('IsCompetitorHotel', 1);
				$this->RateAndReviewDb->where('website', 1);
				$this->RateAndReviewDb->where('IsDelete', 0);
				if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
				}
				$this->RateAndReviewDb->group_by('SystemHotel');
				$this->RateAndReviewDb->group_by('MappedHotelName');
				$this->RateAndReviewDb->group_by('IsCompetitorHotel');
				$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
				$competitor_hotels = $this->RateAndReviewDb->get();
				$competitor_hotels = $competitor_hotels->result_array();
				$hotelName = (!empty($competitor_hotels) && isset($competitor_hotels[0]['MappedHotelName'])) ? $competitor_hotels[0]['MappedHotelName'] : "";
			}

			//own
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, IsCompetitorHotel');
			$this->RateAndReviewDb->from('RR_Hotel');
			$this->RateAndReviewDb->where('UserId', $user_id);
			$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
			$this->RateAndReviewDb->where('IsDelete', 0);
			if (isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$this->RateAndReviewDb->where('HotelCode', $request['hotelCode']);
			}
			$this->RateAndReviewDb->group_by('SystemHotel');
			$this->RateAndReviewDb->group_by('MappedHotelName');
			$this->RateAndReviewDb->group_by('IsCompetitorHotel');
			$this->RateAndReviewDb->order_by('MappedHotelName', 'ASC');
			$own_hotel = $this->RateAndReviewDb->get();
			$own_hotel = $own_hotel->result_array();
			$ownhotelName = (!empty($own_hotel) && isset($own_hotel[0]['MappedHotelName'])) ? $own_hotel[0]['MappedHotelName'] : "";
			$ownGetDashboardHotelList = "";
			if ($ownhotelName != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$ownGetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&UserId=' . $user_id . '&hotelname=' . $ownhotelName . '&hotelcode=' . $request['hotelCode'] . '&PageNumber=' . $page_no . '&RowsOfPage=' . $rowperpage);
				if ($ownGetDashboardHotelList != "") {
					$ownGetDashboardHotelList = json_decode($ownGetDashboardHotelList, true);
					$ownGetDashboardHotelList = $ownGetDashboardHotelList['Table'];
				}
			}

			//compe
			$GetDashboardHotelList = "";
			if ($hotelName != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
				$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&days=1&UserId=' . $user_id . '&hotelname=' . $hotelName . '&hotelcode=' . $request['hotelCode'] . '&PageNumber=' . $page_no . '&RowsOfPage=' . $rowperpage);
				if ($GetDashboardHotelList != "") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
					$GetDashboardHotelList = $GetDashboardHotelList['Table'];
				}
			}
			$GetDashboardHotelList = ($ownGetDashboardHotelList != "" && $GetDashboardHotelList != "") ? array_merge($ownGetDashboardHotelList, $GetDashboardHotelList) : ($ownGetDashboardHotelList != "" ? $ownGetDashboardHotelList : ($GetDashboardHotelList != "" ? $GetDashboardHotelList : ""));

			$pagination = "";
			$html = "";
			if (isset($GetDashboardHotelList) && !empty($GetDashboardHotelList) && $GetDashboardHotelList != "") {
				$allcount = $GetDashboardHotelList[0]['totalcount'];
				$pagination = pagination_links($allcount, 10, base_url() . 'website_analysis/filter_data_hotelwise');
				foreach ($GetDashboardHotelList as $hotel) {
					if ($hotel['CRate'] == "-1") {
						$price = "Sold Out";
					} elseif ($hotel['CRate'] == "-2") {
						$price = "Not Available";
					} else {
						$price = '$' . round($hotel['CRate']);
					}

					$style = "";
					if ($hotel['IsCompetitorHotel'] != 1) {
						$style = "color: darkblue";
					}

					if ($hotel['IsCompetitorHotel'] == 1) {
						$type = "Competitor";
					} else {
						$type = "Own";
					}

					$html .= '<tr style="' . $style . '">
							<td>' . get_websitename_by_id($hotel['WebSiteId']) . '</td>
							<td>' . $hotel['MappedHotelName'] . '</td>
							<td>' . $price . '</td>
							<td>' . $hotel['OriginalRoomType'] . '</td>
							<td>' . $type . '</td>
						</tr>';
				}
			} else {
				$html .= '<tr>
						<td colspan="4" style="text-align: center">No Records Found</td>
					</tr>';
			}

			$chart_data = "";
			if ($request['is_change_chart'] == true) {
				$GetDashboardHotelList = "";
				if ($hotelName != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$GetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id . '&hotelname=' . $hotelName);
				}
				$ownGetDashboardHotelList = "";
				if ($ownhotelName != "" && isset($request['hotelCode']) && $request['hotelCode'] != "") {
					$ownGetDashboardHotelList = call_DashboardRateAnalysistableList($auth_key, 'Customer/GetDashboardRateAnalysistableList?roomtypeId=' . $request['roomTypeId'] . '&highlow=' . $request['price'] . '&hotelcode=' . $request['hotelCode'] . '&days=1&UserId=' . $user_id . '&hotelname=' . $ownhotelName);
				}

				if ($ownGetDashboardHotelList != "") {
					$ownGetDashboardHotelList = json_decode($ownGetDashboardHotelList, true);
				}
				if ($GetDashboardHotelList != "") {
					$GetDashboardHotelList = json_decode($GetDashboardHotelList, true);
				}

				$GetDashboardHotelList = ($ownGetDashboardHotelList != "" && $GetDashboardHotelList != "") ? array_merge($ownGetDashboardHotelList['Table'], $GetDashboardHotelList['Table']) : ($ownGetDashboardHotelList != "" ? $ownGetDashboardHotelList['Table'] : ($GetDashboardHotelList != "" ? $GetDashboardHotelList['Table'] : ""));
				$chart_data = $GetDashboardHotelList;
			}

			$GetAllWebsite = call_api_get($auth_key, 'hotel/GetAllWebsite');
			if ($GetAllWebsite != "") {
				$GetAllWebsite = json_decode($GetAllWebsite, true);
			}

			echo json_encode(['status' => 1, 'pagination' => $pagination, 'html' => $html, 'chart_data' => $chart_data, 'websites' => $GetAllWebsite, 'hotels' => $competitor_hotels]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
