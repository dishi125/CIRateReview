<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_summary extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id') != "") {
				$user_id = $this->session->userdata('new_user_id');
			}
			$curr_date = date('Y-m-d');

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name');
			$this->RateAndReviewDb->from('Responded_Reviews rv');
			$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
			$this->RateAndReviewDb->where('rv.client_id', $user_id);
			$this->RateAndReviewDb->where('respond_date', $curr_date);
			$this->RateAndReviewDb->where('rv.is_deleted', 0);
			$Responded_Reviews = $this->RateAndReviewDb->get();
			$Responded_Reviews = $Responded_Reviews->result_array();

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $user_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$username = $this->RateAndReviewDb->get();
			$username = $username->row_array();

			$page = "review_summary";
			$this->load->view('v_review_summary', compact('Responded_Reviews', 'username', 'page'));
		} else {
			redirect('login');
		}
	}

	public function filter_review_Summary()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->input->post('user_id');
			$user_name = $this->input->post('user_name');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			if ($user_id == ""){
				$user_id = $this->session->userdata('user_id');

				$this->RateAndReviewDb->select('user_name');
				$this->RateAndReviewDb->from('RR_CustomerDetail');
				$this->RateAndReviewDb->where('id', $user_id);
				$this->RateAndReviewDb->where('user_status', 1);
				$username = $this->RateAndReviewDb->get();
				$username = $username->row_array();
				$user_name = $username['user_name'];
			}
			$date = $this->input->post('date');
			$hotelId = $this->input->post('hotelId');

			$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name');
			$this->RateAndReviewDb->from('Responded_Reviews rv');
			$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
			$this->RateAndReviewDb->where('rv.client_id', $user_id);
			$this->RateAndReviewDb->where('respond_date', $date);
			if ($hotelId!="" && $hotelId!="all" && $hotelId!="undefined"){
				$this->RateAndReviewDb->where('ht.id', $hotelId);
			}
			$this->RateAndReviewDb->where('rv.is_deleted', 0);
			$Responded_Reviews = $this->RateAndReviewDb->get();
			$Responded_Reviews = $Responded_Reviews->result_array();

			$html = "";
			if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
				$keys = array_column($Responded_Reviews, 'website_id');
				array_multisort($keys, SORT_ASC, $Responded_Reviews);
				$first_website_id = 0;
				foreach ($Responded_Reviews as $Responded_Review) {
					$rowspan = array_count_values(array_column($Responded_Reviews, 'website_id'))[$Responded_Review['website_id']];
					if ($first_website_id == $Responded_Review['website_id']) {
						$html .= '<tr>
									<td>' . $Responded_Review['hotel_name'] . '</td>
									<td>' . $Responded_Review['positive_review'] . '</td>
									<td>' . $Responded_Review['negative_review'] . '</td>
									<td>' . $Responded_Review['total_reviews'] . '</td>
									<td>' . $Responded_Review['notes'] . '</td>
								</tr>';
					} else {
						$html .= '<tr>
									<td rowspan="' . $rowspan . '" style="text-align: center; vertical-align: middle">' . $Responded_Review['Name'] . '</td>
									<td>' . $Responded_Review['hotel_name'] . '</td>
									<td>' . $Responded_Review['positive_review'] . '</td>
									<td>' . $Responded_Review['negative_review'] . '</td>
									<td>' . $Responded_Review['total_reviews'] . '</td>
									<td>' . $Responded_Review['notes'] . '</td>
								</tr>';
					}
					$first_website_id = $Responded_Review['website_id'];
				}
			} else {
				$html .= '<tr>
							<td colspan="6" style="text-align: center">No records found</td>
						</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html, 'user_name' => $user_name]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function send_mail_review_summary()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->input->post('user_id');
			$username = $this->input->post('user_name');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			if ($user_id == ""){
				$user_id = $this->session->userdata('user_id');

				$this->RateAndReviewDb->select('user_name');
				$this->RateAndReviewDb->from('RR_CustomerDetail');
				$this->RateAndReviewDb->where('id', $user_id);
				$this->RateAndReviewDb->where('user_status', 1);
				$username = $this->RateAndReviewDb->get();
				$username = $username->row_array();
				$username = $username['user_name'];
			}
			$date = $this->input->post('date');

			$this->RateAndReviewDb->select('user_email');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $user_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$user_email = $this->RateAndReviewDb->get();
			$user_email = $user_email->row_array();

			$hotel_id = $this->input->post('hotelId');

			$this->RateAndReviewDb->select('email,copy_recipients');
			$this->RateAndReviewDb->from('client_hotels');
			$this->RateAndReviewDb->where('client_id', $user_id);
			if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="undefined"){
				$this->RateAndReviewDb->where('id', $hotel_id);
			}
			$this->RateAndReviewDb->where('is_deleted', 0);
			$hotel_data = $this->RateAndReviewDb->get();
			$hotel_data = $hotel_data->result_array();
			if (isset($hotel_data) && !empty($hotel_data)) {
				$hotel_data = array_filter($hotel_data, function ($var) {
					return ($var['email'] != "");
				});
				$to_mail = array_unique(array_column($hotel_data, 'email'));
				$hotel_data = array_filter($hotel_data, function ($var) {
					return ($var['copy_recipients'] != "");
				});
				$cc_mail = array_unique(array_column($hotel_data, 'copy_recipients'));
				if (!empty($cc_mail)){
					$cc_mail = implode(",",$cc_mail);
					$cc_mail = explode(",",$cc_mail);
					$cc_mail = array_unique($cc_mail);
				}
			}

			if (!isset($to_mail) || empty($to_mail) || $to_mail=="" || $to_mail=="undefined"){
				$to_mail = $user_email['user_email'];
			}
			if (!isset($cc_mail) || empty($cc_mail) || $cc_mail=="" || $cc_mail=="undefined"){
				$cc_mail = $user_email['user_email'];
			}

			$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name');
			$this->RateAndReviewDb->from('Responded_Reviews rv');
			$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
			$this->RateAndReviewDb->where('rv.client_id', $user_id);
			if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="undefined"){
				$this->RateAndReviewDb->where('ht.id', $hotel_id);
			}
			$this->RateAndReviewDb->where('respond_date', $date);
			$Responded_Reviews = $this->RateAndReviewDb->get();
			$Responded_Reviews = $Responded_Reviews->result_array();

			$body = $this->load->view('v_respond_email', compact('username', 'Responded_Reviews', 'date'), TRUE);
			$this->load->config('email');
			$this->load->library('email');
			$from = $this->config->item('smtp_user');
			$this->email->from($from);
			//$this->email->to($to_mail);
			$this->email->to($cc_mail);
			$this->email->cc('vixuti.psmtech@gmail.com,patelnaren@gmail.com');

			//$this->email->cc($cc_mail);
			$this->email->subject("Review Summary");
			$this->email->message($body);
			if ($hotel_id=="" || $hotel_id=="all" || $hotel_id=="undefined"){
				$hotel_id = 0;
			}
			if ($this->email->send()) {
				$data = array(
					'client_id' => $user_id,
					'hotel_id' => $hotel_id,
					'status' => 1,
					'datetime' => date("Y-m-d H:i:s")
				);
				$this->RateAndReviewDb->insert('mail_log', $data);
				echo json_encode(['status' => 1]);
				exit;
			} else {
				$errors = $this->email->print_debugger();
				$data = array(
					'client_id' => $user_id,
					'hotel_id' => $hotel_id,
					'status' => 0,
					'datetime' => date("Y-m-d H:i:s"),
					'message' => $errors
				);
				$this->RateAndReviewDb->insert('mail_log', $data);

				$this->email->from($from);
				$this->email->to("vixuti.psmtech@gmail.com");
				$this->email->subject("Failed to send Report");
				$this->email->message($body);
				$this->email->send();

				echo json_encode(['status' => 'failed']);
				exit;
			}
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}
}
