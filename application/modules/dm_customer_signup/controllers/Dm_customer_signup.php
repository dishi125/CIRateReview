<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dm_customer_signup extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
//		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('Is_socialmedia', 1);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllSocialmedia = $get_website_data->result_array();

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('Is_socialmedia', 0);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllReputation = $get_website_data->result_array();

			$this->load->view('v_dm_customer_signup', compact('GetAllSocialmedia', 'GetAllReputation'));
		/*}
		else {
			redirect('login');
		}*/
	}

	public function save_customer_signup(){
//		if ($this->session->userdata('auth_key')) {
			$request = $this->input->post();
//			pre($request);
//			pre($_FILES['images_1']);

//			$data = json_decode(file_get_contents('php://input'), true);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			/*$this->RateAndReviewDb->empty_table('dms_corporate');
			$this->RateAndReviewDb->empty_table('dms_hotels');
			$this->RateAndReviewDb->empty_table('dms_manage_credentials');*/

			$params['corporation_name'] = trim($request['corporation_name']);
			$Add = $this->RateAndReviewDb->insert('dms_corporate', $params);
			$dm_corporate_id = $this->RateAndReviewDb->insert_id();

			$total_forms = $request['form_cnt'];
			for($i=1; $i<=$total_forms; $i++){
				$ind="formdata_".$i;
				parse_str($request[$ind],$myValue);
//				pre($myValue);

				$attachments = array();
				if (isset($_FILES['images_'.$i])) {
					$countfiles = count($_FILES['images_'.$i]['name']);
					for ($j = 0; $j < $countfiles; $j++) {
						if (!empty($_FILES['images_'.$i]['name'][$j])) {
							$dir_path = FCPATH . 'assets/dm_customer_hotels';
							if (!is_dir($dir_path)) {
								mkdir($dir_path, 0777, TRUE);
							}
							$file_ext = pathinfo($_FILES['images_'.$i]["name"][$j], PATHINFO_EXTENSION);
							$file_name = rand(1,9).time().".".$file_ext;
							move_uploaded_file($_FILES['images_'.$i]['tmp_name'][$j], $dir_path . '/' . $file_name);
							array_push($attachments, $file_name);
						}
					}
				}

				$params = array();
				$params['dm_corporate_id'] = $dm_corporate_id;
				$params['brand_name'] = $myValue['brand_name'];
				$params['hotel_name'] = $myValue['hotel_name'];
				$params['hotel_address'] = $myValue['hotel_address'];
				$params['phone'] = $myValue['phone'];
				$params['email'] = $myValue['email'];
				$params['hotel_domain'] = $myValue['hotel_domain'];
				$params['franchise_hotel_website_link'] = $myValue['Franchise_hotel_website'];
				$params['images'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";
				$Add = $this->RateAndReviewDb->insert('dms_hotels', $params);
				$dm_hotel_id = $this->RateAndReviewDb->insert_id();

				$total_reput = count($request['repu_web_'.$i]);
				for ($repu=0; $repu<$total_reput; $repu++){
					$params = array();
					$params['dm_hotel_id'] = $dm_hotel_id;
					$params['dm_corporate_id'] = $dm_corporate_id;
					$params['website_id'] = $request['repu_web_'.$i][$repu];
					$params['username'] = $request['repu_user_'.$i][$repu];
					$params['password'] = $request['repu_pwd_'.$i][$repu];
					$Add = $this->RateAndReviewDb->insert('dms_manage_credentials', $params);
				}

				if (isset($request['social_web_'.$i])) {
					$total_social = count($request['social_web_' . $i]);
					for ($social = 0; $social < $total_social; $social++) {
						$params = array();
						$params['dm_hotel_id'] = $dm_hotel_id;
						$params['dm_corporate_id'] = $dm_corporate_id;
						$params['website_id'] = $request['social_web_' . $i][$social];
						$params['username'] = $request['social_user_' . $i][$social];
						$params['password'] = $request['social_pwd_' . $i][$social];
						$Add = $this->RateAndReviewDb->insert('dms_manage_credentials', $params);
					}
				}
			}

			echo json_encode(['status' => 1]);
			die();
		/*}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}*/
	}

	public function customer_signup_list(){
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('dmc.corporation_name, dmh.hotel_name, dmh.brand_name, dmh.dm_corporate_id, dmh.id, dmh.dm_corporate_id');
			$this->RateAndReviewDb->from('dms_corporate dmc');
			$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.dm_corporate_id = dmc.id', 'left');
			$this->RateAndReviewDb->where('dmc.is_delete', 0);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_hotels = $this->RateAndReviewDb->get();
			$dms_hotels = $dms_hotels->result_array();

			$this->load->view('v_dm_customer_signup_list', compact('dms_hotels'));
		}
		else {
			redirect('login');
		}
	}

	public function edit_dm_hotel(){
		$hotel_id = $this->uri->segment(2);
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('Is_socialmedia', 1);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllSocialmedia = $get_website_data->result_array();

			$this->RateAndReviewDb->select('*');
			$this->RateAndReviewDb->where('Is_socialmedia', 0);
			$this->RateAndReviewDb->where('is_deleted',0);
			$this->RateAndReviewDb->from('ci_websites');
			$get_website_data = $this->RateAndReviewDb->get();
			$GetAllReputation = $get_website_data->result_array();

			$this->RateAndReviewDb->select('dmh.id, dmh.dm_corporate_id, dmc.corporation_name, dmh.brand_name, dmh.hotel_name, dmh.hotel_address, dmh.phone, dmh.email, dmh.hotel_domain, dmh.franchise_hotel_website_link, dmh.images');
			$this->RateAndReviewDb->from('dms_hotels dmh');
			$this->RateAndReviewDb->join('dms_corporate as dmc', 'dmc.id = dmh.dm_corporate_id', 'left');
			$this->RateAndReviewDb->where('dmh.id', $hotel_id);
			$this->RateAndReviewDb->where('dmc.is_delete', 0);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_hotel = $this->RateAndReviewDb->get();
			$dms_hotel = $dms_hotel->row_array();

			$this->RateAndReviewDb->select('dmcr.website_id, dmcr.username, dmcr.password, ciw.link');
			$this->RateAndReviewDb->from('dms_manage_credentials dmcr');
			$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.id = dmcr.dm_hotel_id', 'left');
			$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = dmcr.website_id', 'left');
			$this->RateAndReviewDb->where('dmcr.dm_hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('ciw.Is_socialmedia', 0);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_reputation = $this->RateAndReviewDb->get();
			$dms_reputation = $dms_reputation->result_array();

			$this->RateAndReviewDb->select('dmcr.website_id, dmcr.username, dmcr.password, ciw.link');
			$this->RateAndReviewDb->from('dms_manage_credentials dmcr');
			$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.id = dmcr.dm_hotel_id', 'left');
			$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = dmcr.website_id', 'left');
			$this->RateAndReviewDb->where('dmcr.dm_hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('ciw.Is_socialmedia', 1);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_social_media = $this->RateAndReviewDb->get();
			$dms_social_media = $dms_social_media->result_array();

			$this->load->view('v_edit_dm_hotel', compact('GetAllSocialmedia', 'GetAllReputation', 'dms_hotel', 'dms_reputation', 'dms_social_media'));
		}
		else {
			redirect('login');
		}
	}

	public function update_customer_signup(){
		$request = $this->input->post();
//		pre($request);
//		pre($_FILES['images']);

		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$params['corporation_name'] = trim($request['corporation_name']);
			$this->RateAndReviewDb->where('id', $request['dm_corporate_id']);
			$update = $this->RateAndReviewDb->update('dms_corporate', $params);

			$attachments = array();
			if (isset($_FILES['images'])) {
				$countfiles = count($_FILES['images']['name']);
				for ($j = 0; $j < $countfiles; $j++) {
					if (!empty($_FILES['images']['name'][$j])) {
						$dir_path = FCPATH . 'assets/dm_customer_hotels';
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}
						$file_ext = pathinfo($_FILES['images']["name"][$j], PATHINFO_EXTENSION);
						$file_name = rand(1, 9) . time() . "." . $file_ext;
						move_uploaded_file($_FILES['images']['tmp_name'][$j], $dir_path . '/' . $file_name);
						array_push($attachments, $file_name);
					}
				}
			}
			$db_attachments = (isset($request['db_images']) && $request['db_images'] != "") ? explode(",", $request['db_images']) : "";
			$dir_path = FCPATH . 'assets/dm_customer_hotels';
			if (isset($request['old_images']) && !empty($request['old_images'])) {
				$old_images = $request['old_images'];
				$attachments = array_merge($attachments, $old_images);

				if ($db_attachments != "") {
					foreach ($db_attachments as $img) {
						if (!in_array($img, $old_images) && file_exists($dir_path . '/' . $img)) {
							unlink($dir_path . '/' . $img);
						}
					}
				}
			} else {
				if ($db_attachments != "") {
					foreach ($db_attachments as $img) {
						if (file_exists($dir_path . '/' . $img)) {
							unlink($dir_path . '/' . $img);
						}
					}
				}
			}

			$params = array();
			$params['brand_name'] = $request['brand_name'];
			$params['hotel_name'] = $request['hotel_name'];
			$params['hotel_address'] = $request['hotel_address'];
			$params['phone'] = $request['phone'];
			$params['email'] = $request['email'];
			$params['hotel_domain'] = $request['hotel_domain'];
			$params['franchise_hotel_website_link'] = $request['Franchise_hotel_website'];
			$params['images'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";

			$this->RateAndReviewDb->where('id', $request['hotel_id']);
			$update = $this->RateAndReviewDb->update('dms_hotels', $params);

			$this->RateAndReviewDb->delete('dms_manage_credentials', array('dm_hotel_id' => $request['hotel_id'], 'dm_corporate_id' => $request['dm_corporate_id']));

			$total_reput = count($request['repu_web']);
			for ($repu = 0; $repu < $total_reput; $repu++) {
				$params = array();
				$params['dm_hotel_id'] = $request['hotel_id'];
				$params['dm_corporate_id'] = $request['dm_corporate_id'];
				$params['website_id'] = $request['repu_web'][$repu];
				$params['username'] = $request['repu_user'][$repu];
				$params['password'] = $request['repu_pwd'][$repu];
				$Add = $this->RateAndReviewDb->insert('dms_manage_credentials', $params);
			}

			if (isset($request['social_web'])) {
				$total_social = count($request['social_web']);
				for ($social = 0; $social < $total_social; $social++) {
					$params = array();
					$params['dm_hotel_id'] = $request['hotel_id'];
					$params['dm_corporate_id'] = $request['dm_corporate_id'];
					$params['website_id'] = $request['social_web'][$social];
					$params['username'] = $request['social_user'][$social];
					$params['password'] = $request['social_pwd'][$social];
					$Add = $this->RateAndReviewDb->insert('dms_manage_credentials', $params);
				}
			}

			echo json_encode(['status' => 1]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			die();
		}
	}

	public function delete_dm_hotel(){
		if ($this->session->userdata('auth_key')) {
			$hotel_id = $this->uri->segment(2);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $hotel_id);
			$res = $this->RateAndReviewDb->update('dms_hotels', array('is_delete' => 1));

			$this->RateAndReviewDb->where('dm_hotel_id', $hotel_id);
			$res = $this->RateAndReviewDb->update('dms_manage_credentials', array('is_delete' => 1));

			$getHotelList = $this->getDmHotelList();

			$html = "";
			if (isset($getHotelList) && !empty($getHotelList)){
				$keys = array_column($getHotelList, 'dm_corporate_id');
				array_multisort($keys, SORT_ASC, $getHotelList);
				$first_corporate_id = 0;
				foreach ($getHotelList as $dms_hotel) {
					$rowspan = array_count_values(array_column($getHotelList, 'dm_corporate_id'))[$dms_hotel['dm_corporate_id']];
					if ($first_corporate_id == $dms_hotel['dm_corporate_id']) {
						$html .= '<tr>
									<td>'.$dms_hotel['hotel_name'].'</td>
									<td>'.$dms_hotel['brand_name'].'</td>
									<td>
										<ul class="list-inline hstack gap-2 mb-0">
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
												<a class="text-primary d-inline-block" href="'.base_url().'view_dm_hotel/'.$dms_hotel['id'].'"><i class="ri-eye-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
												<a href="'.base_url().'edit_dm_hotel/'.$dms_hotel['id'].'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
												<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel('.$dms_hotel['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
											</li>
										</ul>
									</td>
								</tr>';
					}
					else {
						$html .= '<tr>
										<td rowspan="'.$rowspan.'" style="text-align: center; vertical-align: middle">'.$dms_hotel['corporation_name'].'</td>
										<td>'.$dms_hotel['hotel_name'].'</td>
										<td>'.$dms_hotel['brand_name'].'</td>
										<td>
											<ul class="list-inline hstack gap-2 mb-0">
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
													<a class="text-primary d-inline-block" href="'.base_url().'view_dm_hotel/'.$dms_hotel['id'].'"><i class="ri-eye-fill fs-16"></i></a>
												</li>
												<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
													<a href="'.base_url().'edit_dm_hotel/'.$dms_hotel['id'].'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
												</li>
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
													<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel('.$dms_hotel['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
												</li>
											</ul>
										</td>
										<td rowspan="'.$rowspan.'">
											<ul class="list-inline hstack gap-2 mb-0">
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
													<a class="text-danger d-inline-block remove-item-btn" onclick="delete_corporate('.$dms_hotel['dm_corporate_id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
												</li>
											</ul>
										</td>
									</tr>';
					}
					$first_corporate_id = $dms_hotel['dm_corporate_id'];
				}
			}
			else {
				$html .= '<tr>
							<td colspan="4" style="text-align: center">No records found</td>
						</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function getDmHotelList(){
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

		$this->RateAndReviewDb->select('dmc.corporation_name, dmh.hotel_name, dmh.brand_name, dmh.dm_corporate_id, dmh.id, dmh.dm_corporate_id');
		$this->RateAndReviewDb->from('dms_corporate dmc');
		$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.dm_corporate_id = dmc.id', 'left');
		$this->RateAndReviewDb->where('dmc.is_delete', 0);
		$this->RateAndReviewDb->where('dmh.is_delete', 0);
		$dms_hotels = $this->RateAndReviewDb->get();
		$dms_hotels = $dms_hotels->result_array();

		return $dms_hotels;
	}

	public function delete_dm_corporate(){
		if ($this->session->userdata('auth_key')) {
			$corporate_id = $this->uri->segment(2);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->where('id', $corporate_id);
			$res = $this->RateAndReviewDb->update('dms_corporate', array('is_delete' => 1));

			$this->RateAndReviewDb->where('dm_corporate_id', $corporate_id);
			$res = $this->RateAndReviewDb->update('dms_hotels', array('is_delete' => 1));

			$this->RateAndReviewDb->where('dm_corporate_id', $corporate_id);
			$res = $this->RateAndReviewDb->update('dms_manage_credentials', array('is_delete' => 1));

			$getHotelList = $this->getDmHotelList();

			$html = "";
			if (isset($getHotelList) && !empty($getHotelList)){
				$keys = array_column($getHotelList, 'dm_corporate_id');
				array_multisort($keys, SORT_ASC, $getHotelList);
				$first_corporate_id = 0;
				foreach ($getHotelList as $dms_hotel) {
					$rowspan = array_count_values(array_column($getHotelList, 'dm_corporate_id'))[$dms_hotel['dm_corporate_id']];
					if ($first_corporate_id == $dms_hotel['dm_corporate_id']) {
						$html .= '<tr>
									<td>'.$dms_hotel['hotel_name'].'</td>
									<td>'.$dms_hotel['brand_name'].'</td>
									<td>
										<ul class="list-inline hstack gap-2 mb-0">
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
												<a class="text-primary d-inline-block" href="'.base_url().'view_dm_hotel/'.$dms_hotel['id'].'"><i class="ri-eye-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
												<a href="'.base_url().'edit_dm_hotel/'.$dms_hotel['id'].'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
											</li>
											<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
												<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel('.$dms_hotel['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
											</li>
										</ul>
									</td>
								</tr>';
					}
					else {
						$html .= '<tr>
										<td rowspan="'.$rowspan.'" style="text-align: center; vertical-align: middle">'.$dms_hotel['corporation_name'].'</td>
										<td>'.$dms_hotel['hotel_name'].'</td>
										<td>'.$dms_hotel['brand_name'].'</td>
										<td>
											<ul class="list-inline hstack gap-2 mb-0">
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
													<a class="text-primary d-inline-block" href="'.base_url().'view_dm_hotel/'.$dms_hotel['id'].'"><i class="ri-eye-fill fs-16"></i></a>
												</li>
												<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
													<a href="'.base_url().'edit_dm_hotel/'.$dms_hotel['id'].'" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
												</li>
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
													<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel('.$dms_hotel['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
												</li>
											</ul>
										</td>
										<td rowspan="'.$rowspan.'">
											<ul class="list-inline hstack gap-2 mb-0">
												<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
													<a class="text-danger d-inline-block remove-item-btn" onclick="delete_corporate('.$dms_hotel['dm_corporate_id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
												</li>
											</ul>
										</td>
									</tr>';
					}
					$first_corporate_id = $dms_hotel['dm_corporate_id'];
				}
			}
			else {
				$html .= '<tr>
							<td colspan="4" style="text-align: center">No records found</td>
						</tr>';
			}

			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function view_dm_hotel(){
		$hotel_id = $this->uri->segment(2);
		if ($this->session->userdata('auth_key')) {
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('dmh.id, dmh.dm_corporate_id, dmc.corporation_name, dmh.brand_name, dmh.hotel_name, dmh.hotel_address, dmh.phone, dmh.email, dmh.hotel_domain, dmh.franchise_hotel_website_link, dmh.images');
			$this->RateAndReviewDb->from('dms_hotels dmh');
			$this->RateAndReviewDb->join('dms_corporate as dmc', 'dmc.id = dmh.dm_corporate_id', 'left');
			$this->RateAndReviewDb->where('dmh.id', $hotel_id);
			$this->RateAndReviewDb->where('dmc.is_delete', 0);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_hotel = $this->RateAndReviewDb->get();
			$dms_hotel = $dms_hotel->row_array();

			$this->RateAndReviewDb->select('dmcr.website_id, dmcr.username, dmcr.password, ciw.link');
			$this->RateAndReviewDb->from('dms_manage_credentials dmcr');
			$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.id = dmcr.dm_hotel_id', 'left');
			$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = dmcr.website_id', 'left');
			$this->RateAndReviewDb->where('dmcr.dm_hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('ciw.Is_socialmedia', 0);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_reputation = $this->RateAndReviewDb->get();
			$dms_reputation = $dms_reputation->result_array();

			$this->RateAndReviewDb->select('dmcr.website_id, dmcr.username, dmcr.password, ciw.link');
			$this->RateAndReviewDb->from('dms_manage_credentials dmcr');
			$this->RateAndReviewDb->join('dms_hotels as dmh', 'dmh.id = dmcr.dm_hotel_id', 'left');
			$this->RateAndReviewDb->join('ci_websites as ciw', 'ciw.id = dmcr.website_id', 'left');
			$this->RateAndReviewDb->where('dmcr.dm_hotel_id', $hotel_id);
			$this->RateAndReviewDb->where('ciw.Is_socialmedia', 1);
			$this->RateAndReviewDb->where('dmh.is_delete', 0);
			$dms_social_media = $this->RateAndReviewDb->get();
			$dms_social_media = $dms_social_media->result_array();

			$this->load->view('v_view_dm_hotel', compact('dms_hotel', 'dms_reputation', 'dms_social_media'));
		}
		else {
			redirect('login');
		}
	}

	public function demo_image_uploader(){
		$this->load->view('v_demo');
	}

	public function save_demo_image_uploader(){
		if(isset($_FILES['file']['name'])){
			/* Getting file name */
			$filename = $_FILES['file']['name'];

			/* Location */
			$location = "upload/".$filename;
			$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			$response = 0;
			/* Upload file */
			if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				$response = $location;
			}
			echo $response;
			exit;
		}
		echo 0;
	}

}
