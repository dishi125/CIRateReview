<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_Credentials extends MX_Controller  {

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
			$getCredentialsList = $this->getCredentialsList('', $user_id);

			$page = "manage_credentials";
			$this->load->view('v_manage_credentials', compact('getCredentialsList', 'page'));
		}else {
			redirect('login');
		}
	}

	public function getIsSuperAdmin(){
		$user_permissions = $this->session->userdata('user_permissions');
		//  print_r($user_permissions);
		//$this->RateAndReviewDb->select('id,hotelname,state,city,adress,website');
		//$this->RateAndReviewDb->from('ci_websites');
		$flag = false;
		foreach ($user_permissions as $permission_page){
			if ($permission_page['parent_id'] == 0){
				if ($permission_page['display_name'] == "Review Management"){
					foreach ($user_permissions as $permission_page){
						if ($permission_page['parent_id'] == 11) {
							if($permission_page['display_name'] == 'Manage Website' && $permission_page['is_view'] == 1 )
							{
								// $user_id = $this->session->userdata('user_id');
								$flag = false;
							}
							else if($permission_page['display_name'] == 'Manage Hotels' && $permission_page['is_view'] == 1 )
							{
								//$user_id = $this->session->userdata('user_id');
								$flag = true;
							}
						}
					}
				}
			}
		}
		return $flag;
	}

	public function getCredentialsList($credid = '',$user_id=''){
		//$user_id = 0;
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
		// $this->RateAndReviewDb->distinct('cm.client_id,ciw.id as website_id,ch.id as hotel_id');
		$this->RateAndReviewDb->select('cm.id,cm.user_name,cm.password,ciw.name as website,ciw.id as website_id,ciw.link,rrcd.user_name as client,cm.client_id,ch.id as hotel_id,rrcd.user_email,ch.hotel_name,cm.created_at');
		$this->RateAndReviewDb->from('credential_management cm');
		$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = cm.website_id', 'left');
		$this->RateAndReviewDb->join('RR_customer as rrc', 'rrc.user_id = cm.client_id', 'left');
		$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = rrc.user_id', 'left');
		$this->RateAndReviewDb->join('client_hotels as ch', 'ch.id = cm.hotel_id', 'left');
		if($user_id != '') {
			$this->RateAndReviewDb->where('rrc.user_id', $user_id);
		}
		if($credid != ''){
			$this->RateAndReviewDb->where('cm.id',$credid);
		}
		$this->RateAndReviewDb->where('rrcd.user_status',1);
		//	$this->RateAndReviewDb->group_by('cm.client_id,ciw.id as website_id,ch.id as hotel_id');
		$this->RateAndReviewDb->where('cm.updated_at',NULL);
		$this->RateAndReviewDb->where('cm.is_deleted',0);
		//	$this->RateAndReviewDb->group_by('cm.created_at');
		$get_website_data = $this->RateAndReviewDb->get();
		$getCredentialsList = $get_website_data->result_array();
		return $getCredentialsList;
	}
	
	public function get_client_credlist(){
		if ($this->session->userdata('auth_key')) {
			$userid = $this->uri->segment(2);
			$html = $this->get_credentiallist_html('', $userid);

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function add_cred(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}
			// $this->RateAndReviewDb->reset_query();
			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('client_id',$user_id);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$page = "manage_credentials";
			$this->load->view('v_add_credentials', compact('GetAllWebsite','GetAllhotels', 'page'));
		}else {
			redirect('login');
		}
	}

	public function save_credentials(){
		$auth_key = $this->session->userdata('auth_key');
		$cred_id= '';
		if ($this->session->userdata('auth_key')) {
			$request = $this->input->post();
			if (isset($request['id'])) {
				$cred_id = $request['id'];
			}
			$website = (int)$request['website'];
			$hotel_id = $request['cred_hotel_name'];
			$client_id = isset($request['customer']) ? $request['customer'] : $this->session->userdata('user_id');

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->where('client_id', $client_id);
			$this->RateAndReviewDb->where('website_id', $website);
			$this->RateAndReviewDb->where('hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('is_deleted', 0);
			if ($cred_id != '') {
				$this->RateAndReviewDb->where('id', $cred_id);
			}
			$this->RateAndReviewDb->from('credential_management');
			$get_cred_data = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($get_cred_data->row_array()) && count($get_cred_data->row_array()) > 0)) {
				$exist = true;
			}
			// print_r($request);
			// echo $customer;
			$status = 'error';
			if ($cred_id == '' && $exist) {
				echo json_encode(['status' => 0, 'error' => 'Credentials is already added for this website so you can not add more credentials.']);
				die();
			} elseif (($cred_id == '' && !$exist) || ($cred_id != '' && !$exist)) {
				$params['user_name'] = $request['user_name'];
				$params['password'] = $request['password'];
				$params['hotel_id'] = $request['cred_hotel_name'];
				$params['client_id'] = $client_id;
				$params['Website_id'] = $request['website'];
				$params['created_by'] = $this->session->userdata('user_id');
				$params['ip'] = $this->session->userdata('user_ip');
				$params['created_at'] = date("Y-m-d H:i:s");
				$AddUpdateCred = $this->RateAndReviewDb->insert('credential_management', $params);
				if ($AddUpdateCred) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} elseif ($cred_id != '' && $exist) {
				$params['updated_by'] = $this->session->userdata('user_id');
				$params['ip'] = $this->session->userdata('user_ip');
				$params['updated_at'] = date("Y-m-d H:i:s");
				$this->RateAndReviewDb->where('id', $cred_id);
				$updatecred = $this->RateAndReviewDb->update('credential_management', $params);
				unset($params);

				$params['user_name'] = $request['user_name'];
				$params['password'] = $request['password'];
				$params['hotel_id'] = $request['cred_hotel_name'];
				$params['client_id'] = $client_id;
				$params['Website_id'] = $request['website'];
				$params['created_by'] = $this->session->userdata('user_id');
				$params['ip'] = $this->session->userdata('user_ip');
				$params['created_at'] = date("Y-m-d H:i:s");
				$AddUpdatecredentials = $this->RateAndReviewDb->insert('credential_management', $params);

				if ($AddUpdatecredentials) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} else {
				echo json_encode(['status' => 'error', 'error' => 'Something went wrong']);
				die();
			}
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function delete_credentials(){
		if ($this->session->userdata('auth_key')) {
			$credId = $this->input->post('credId');
			$user_id = $this->input->post('userId');
			if ($user_id == ""){
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $credId);
			$res = $this->RateAndReviewDb->update('credential_management', array('is_deleted' => 1));

			$html = $this->get_credentiallist_html('', $user_id);
			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_credentiallist_html($credid='',$userid=''){
		$getCredentialsList = $this->getCredentialsList($credid,$userid);
		
		$html = "";
		foreach ($getCredentialsList as $Cred){
			$html .= '<tr>';
			//$html .= '<td>'.$Cred['user_name'].'</td>';
			$html .= '<td>'.$Cred['website'].'</td>';
			$html .= '<td>'.$Cred['hotel_name'].'</td>';
			$html .= '<td><a target="_blank" href="'. $Cred['link'].'">'. $Cred['link'].'</a></td>';			
			$html .= '<td>'.$Cred['user_name'].'</td>';
			$html .= '<td>'.$Cred['password'].'</td>';
			//$html .= '<td>'.$Cred['user_email'].'</td>';
			$html .= '<td>'.$Cred['created_at'].'</td>';
			$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">	
						<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="'.base_url().'edit_credentials/'.$Cred['id'].'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>						
							<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_cred('.$Cred['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>
						</ul>
					</td>';
			$html .= '</tr>';
		}
		return $html;
	}

	public function edit_credentials(){
		$cred_id =  $this->uri->segment(2);
		
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$getCredentialsList = $this->getCredentialsList($cred_id, '');

			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('client_id',$user_id);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$this->RateAndReviewDb->select('id,name,link');
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllWebsite = $get_website_data->result_array();

			$cred = $getCredentialsList[0];
			$page = "manage_credentials";
			$this->load->view('v_edit_credentials', compact('GetAllWebsite', 'GetAllhotels','cred', 'page'));
		}else {
			redirect('login');
		}
	}

	public function GetHotelNameByWebsite(){
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$website_id = $this->input->post('website_id');
			$user_id = $this->input->post('customer');
			if ($user_id == '') {
				$user_id = $this->session->userdata('user_id');
			}
			// $this->RateAndReviewDb->reset_query();
			$this->RateAndReviewDb->select('id,hotel_name');
			$this->RateAndReviewDb->where('client_id', $user_id);
			if ($website_id != '') {
				$this->RateAndReviewDb->where('website_id', $website_id);
			}
			$this->RateAndReviewDb->where('is_deleted', 0);
			$this->RateAndReviewDb->from('client_hotels');
			$get_hotel_data = $this->RateAndReviewDb->get();
			$GetAllhotels = $get_hotel_data->result_array();

			$html = '<option value=""></option>';
			if (isset($GetAllhotels) && !empty($GetAllhotels)) {
				foreach ($GetAllhotels as $hotels) {
					$html .= '<option value="' . $hotels['id'] . '">' . $hotels['hotel_name'] . '</option>';
				}
			}

			echo json_encode(['status' => 1, 'html' => $html, 'GetAllhotels' => $GetAllhotels]);
			exit;
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
