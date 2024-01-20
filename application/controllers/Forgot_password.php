<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			// Here is where you do stuff when the submitted form is invalid.
			$errors = $this->form_validation->error_array();
			$data = array();
			if (!empty($errors) && isset($errors['email'])) {
				$data['useremail_err'] = $errors['email'];
			}
			$this->load->view('forgot_password', $data);
		} else {
			$email = trim($this->input->post('email'));
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->where('user_email', $email);
			$this->RateAndReviewDb->where('user_status', 1);
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$is_exist = $this->RateAndReviewDb->get();
			$is_exist = $is_exist->num_rows();
			if ($is_exist == 0){
				$data = array();
				$data['useremail_err'] = 'E-mail does not exist.';
				$this->load->view('forgot_password', $data);
			}
			else{
				$data = array();
				$this->load->helper('string');
				$token = random_string('alnum', 64);
				$insert_data = array(
					'email' => $email,
					'token' => $token,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->RateAndReviewDb->insert('password_resets', $insert_data);

				$this->load->config('email');
				$this->load->library('email');
				$from = $this->config->item('smtp_user');
				$data['token'] = $token;
//				$body = $this->load->view('email_forgot_password', $data);
				$body = '<h1>Forgot Password Email</h1>
						<p>You can reset password from below link:</p>
						<a href="'.base_url('reset_password/').$token.'">Reset Password</a>';
				$this->email->from($from);
				$this->email->to($email);
				$this->email->subject("Reset Password");
				$this->email->message($body);
				if ($this->email->send()) {
					$data['success_msg'] = "Reset Password Link Sent Successfully.";
				} else {
					$data['error_msg'] = "Something went wrong. please try again!!";
				}
				$this->load->view('forgot_password', $data);
			}
		}
	}

	public function reset_password(){
		$auth_key = $this->session->userdata('auth_key');
		$token = $this->uri->segment(2);
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

		$data['token'] = $token;
		if ($this->form_validation->run() == FALSE)
		{
			// Here is where you do stuff when the submitted form is invalid.
			$errors = $this->form_validation->error_array();
			if (!empty($errors) && isset($errors['email'])) {
				$data['user_email_err'] = $errors['email'];
			}
			if (!empty($errors) && isset($errors['password'])) {
				$data['user_password_err'] = $errors['password'];
			}
			if (!empty($errors) && isset($errors['cpassword'])) {
				$data['user_cpassword_err'] = $errors['cpassword'];
			}
			$this->load->view('reset_password', $data);
		}
		else{
			$request = $this->input->post();

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->where('email', $request['email']);
			$this->RateAndReviewDb->where('token', $token);
			$this->RateAndReviewDb->from('password_resets');
			$is_exist = $this->RateAndReviewDb->get();
			$is_exist = $is_exist->num_rows();
			if ($is_exist == 0){
				$data['error_msg'] = 'Invalid token!';
				$this->load->view('reset_password', $data);
			}
			else{
				$params = array();
				$params['customer_email'] = trim($request['email']);
				$params['customer_password'] = $request['cpassword'];
				$params['type'] = "edit_password";
				$params['id'] = -1;
				$res = call_api_post($auth_key, "customer/AddUpdateCustomer", $params);
				$this->RateAndReviewDb->delete('password_resets', array('email' => $request['email']));

//				$data['success_msg'] = 'Your password has been changed!';
				$this->session->set_userdata('success_msg', 'Your password has been changed!');
				redirect('login');
//				$this->load->view('login', $data);
			}
		}
	}
}
