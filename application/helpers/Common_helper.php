<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function call_api_post($auth_key,$url,$params = array())
{
	$url = API_URL.$url;
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic '.$auth_key
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => json_encode($params),
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response, true);
}

function call_api_get($auth_key,$url)
{
	$url = str_replace(" ","%20",API_URL.$url);
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic '.$auth_key
	);
//	echo $url; die();

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);
	//	pre($response);

	return json_decode($response, true);
}

function call_api_delete($auth_key,$url){
	$url = API_URL.$url;
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic '.$auth_key
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'DELETE',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response, true);
}

function get_ip(){
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json'
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://jsonip.com/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response, true);
}

function ip_details($ip){
	$url = "https://ipapi.co/163.53.179.150/json";
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json'
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response, true);
}

function call_chart_api($auth_key,$url){
	$url = API_URL.$url;
	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic '.$auth_key
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{"query":"","variables":{}}',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	$response =	json_decode($response, true);
	return $response;
}

function check_permission($page_name){
	$ci =& get_instance();

	$permission_data = $ci->session->userdata('user_permissions');
	$add = "";
	$edit = "";
	$delete = "";
	foreach ($permission_data as $permission){
		if ($permission['display_name'] == trim($page_name)){
			$add = $permission['is_add'];
			$edit = $permission['is_edit'];
			$delete = $permission['is_delete'];
		}
	}

	$response['add'] = $add;
	$response['edit'] = $edit;
	$response['delete'] = $delete;

	return $response;
}

function send() {
	$CI =& get_instance();
	$CI->load->config('email');
	$CI->load->library('email');

	$from = $CI->config->item('smtp_user');
	$to = "inn501.inngenius@gmail.com";
	$subject = "Test mail";
	$message = "<h1>Hello, this is test mail.</h1>";

	$CI->email->from($from);
	$CI->email->to($to);
	$CI->email->subject($subject);
	$CI->email->message($message);

	if ($CI->email->send()) {
		echo 'Your Email has successfully been sent.';
		die();
	} else {
		show_error($CI->email->print_debugger());
	}
}

function send_mail($data)
{
	$CI =& get_instance();
	$CI->load->config('email');
	$CI->load->library('email');
	$from = $CI->config->item('smtp_user');

	$CI->email->from($from);
	$CI->email->to($data['to_email']);
	$CI->email->subject($data['subject']);
	$CI->email->message($data['body']);
	//Send mail
	if($CI->email->send()) {
		$data = array(
			'from_mail' => $from,
			'to_mail' => $data['to_email'],
			'body' => $data['body'],
			'subject' => $data['subject'],
			'client_id' => $data['client_id'],
			'is_deleted' => $data['is_deleted'],
			'hotel_id' => $data['hotel_id'],
			'website_id' => $data['website_id'],
			'status' => 1,
			'date' => date("Y-m-d H:i:s")
		);

		$CI->db->insert('mail_logs', $data);
		return true;
	}
	else {
		$data = array(
			'from_mail' => $data['from_email'],
			'to_mail' => $data['to_email'],
			'body' => $data['body'],
			'subject' => $data['subject'],
			'client_id' => $data['client_id'],
			'is_deleted' => $data['is_deleted'],
			'hotel_id' => $data['hotel_id'],
			'website_id' => $data['website_id'],
			'status' => 0,
			'date' => date("Y-m-d H:i:s")
		);

		$CI->db->insert('mail_logs', $data);
		return false;
	}
}

function pre($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die();
}

function call_DashboardRateAnalysistableList($auth_key,$url){
	$url = str_replace(" ","%20",API_URL.$url);
//	$url = API_URL.$url;

	$headers = array(
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: Basic '.$auth_key
	);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => '{"query":"","variables":{}}',
		CURLOPT_HTTPHEADER => $headers
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response, true);
}

function pagination_links($allcount, $rowperpage, $url){
	$CI =& get_instance();

	$CI->load->library('pagination');

	$config['base_url'] = $url;
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
	$CI->pagination->initialize($config);
	$pagination = $CI->pagination->create_links();

	return $pagination;
}

function get_websitename_by_id($website_id){
	$CI =& get_instance();
	$CI->RateAndReviewDb = $CI->load->database('RateAndReview', true);
	$CI->RateAndReviewDb->select('name');
	$CI->RateAndReviewDb->from('RR_WebsiteList');
	$CI->RateAndReviewDb->where('id', $website_id);
	$websitename = $CI->RateAndReviewDb->get();
	$websitename = $websitename->row_array();
	if(!empty($websitename)){
		$websitename = $websitename['name'];
	}else{
		$websitename ='';
	}		
	return $websitename;
}

