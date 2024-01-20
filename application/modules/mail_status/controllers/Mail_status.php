<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mail_status extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$curr_date = date('Y-m-d');
			$week_start_date = date('Y-m-d',(strtotime ('-7 day' , strtotime ($curr_date))));

			$this->RateAndReviewDb->select('rrcd.user_name, ch.hotel_name, ml.datetime, ml.status');
			$this->RateAndReviewDb->from('mail_log ml');
			$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = ml.client_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ch', 'ch.id = ml.hotel_id', 'left');
//			$this->RateAndReviewDb->where('ml.datetime', date('Y-m-d'));
			$this->RateAndReviewDb->where("ml.datetime BETWEEN '$week_start_date' AND '$curr_date'");
			$mail_log_data = $this->RateAndReviewDb->get();
			$mail_logs = $mail_log_data->result_array();

			$this->load->view('v_mail_status', compact('mail_logs'));
		}
		else {
			redirect('login');
		}
	}

}
