<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_report extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->session->userdata('user_id');
			if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
				$user_id = $this->session->userdata('new_user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('id, start_time, end_time, total_time, break_hours, description, date');
			$this->RateAndReviewDb->where('user_id', $user_id);
			$this->RateAndReviewDb->from('employee_report');
			$employee_reports = $this->RateAndReviewDb->get();
			$employee_reports = $employee_reports->result_array();

			$check_permission = check_permission("Employee Report");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];
			$this->load->view('v_employee_report', compact('add', 'edit', 'delete', 'employee_reports'));
		}else {
			redirect('login');
		}
	}

	public function add_employee_report(){
		if ($this->session->userdata('auth_key')) {
			$this->load->view('v_add_employee_report');
		}else {
			redirect('login');
		}
	}

	public function save_employee_report(){
		if ($this->session->userdata('auth_key')) {
			$request = $this->input->post();
//			pre($_FILES['files']);
//			pre($request);
			$report_id = '';
			if (isset($request['id'])) {
				$report_id = $request['id'];
			}
			$user_id = $this->session->userdata('user_id');
			$client_id = (isset($request['customer']) && $request['customer']!="undefined") ? $request['customer'] : $user_id;

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->where('user_id', $client_id);
			$this->RateAndReviewDb->where('date', date("Y-m-d",strtotime($request['date'])));
			if ($report_id != '') {
				$this->RateAndReviewDb->where('id', $report_id);
			}
			$this->RateAndReviewDb->from('employee_report');
			$employee_report = $this->RateAndReviewDb->get();
			$exist = false;
			if ((!empty($employee_report->row_array()) && count($employee_report->row_array()) > 0)) {
				$exist = true;
			}

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('user_status', 1);
			$this->RateAndReviewDb->where('id', $client_id);
			$User = $this->RateAndReviewDb->get();
			$User = $User->row_array();

			$attachments = array();
			if (isset($_FILES['files'])) {
				$countfiles = count($_FILES['files']['name']);
				for ($i = 0; $i < $countfiles; $i++) {
					if (!empty($_FILES['files']['name'][$i])) {
						$dir_path = FCPATH . 'assets/employee_reports/' . str_replace(" ", "_", $User['user_name']);
						if (!is_dir($dir_path)) {
							mkdir($dir_path, 0777, TRUE);
						}
						$file_ext = pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
						$file_name = mt_rand(100000, 999999) . time() .".".$file_ext;
						move_uploaded_file($_FILES['files']['tmp_name'][$i], $dir_path . '/' . $file_name);
						array_push($attachments, $file_name);
					}
				}
			}

			$status = 'error';
			if ($report_id == '' && $exist) {
				echo json_encode(['status' => 0, 'error' => 'Employee report record already added on this date.']);
				die();
			} elseif (($report_id == '' && !$exist) || ($report_id != '' && !$exist)) {
				$break_hours = $request['break_hours_hh'].":".$request['break_hours_mm'];
				$params['user_id'] = $client_id;
				$params['start_time'] = $request['start_time'];
				$params['end_time'] = $request['end_time'];
				$params['total_time'] = $request['total_time'];
				$params['break_hours'] = $break_hours;
				$params['description'] = $request['desc'];
				$params['date'] = $request['date'];
				$params['attachments'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";
				$AddUpdate = $this->RateAndReviewDb->insert('employee_report', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} elseif ($report_id != '' && $exist) {
				$db_attachments = (isset($request['attachments']) && $request['attachments']!="") ? explode(",",$request['attachments']) : "";
				$dir_path = FCPATH . 'assets/employee_reports/' . str_replace(" ", "_", $User['user_name']);
				if (isset($request['old_images']) && !empty($request['old_images'])){
					$old_images = $request['old_images'];
					$attachments = array_merge($attachments, $old_images);

					if ($db_attachments!="") {
						foreach ($db_attachments as $img) {
							if (!in_array($img, $old_images) && file_exists($dir_path . '/' . $img)) {
								unlink($dir_path . '/' . $img);
							}
						}
					}
				}
				else {
					if ($db_attachments!="") {
						foreach ($db_attachments as $img) {
							if (file_exists($dir_path . '/' . $img)) {
								unlink($dir_path . '/' . $img);
							}
						}
					}
				}

				$break_hours = $request['break_hours_hh'].":".$request['break_hours_mm'];
				$params['start_time'] = $request['start_time'];
				$params['end_time'] = $request['end_time'];
				$params['total_time'] = $request['total_time'];
				$params['break_hours'] = $break_hours;
				$params['description'] = $request['desc'];
				$params['attachments'] = (isset($attachments) && !empty($attachments)) ? implode(",", $attachments) : "";
				$this->RateAndReviewDb->where('id', $report_id);
				$AddUpdate = $this->RateAndReviewDb->update('employee_report', $params);
				if ($AddUpdate) {
					$status = 1;
				}
				echo json_encode(['status' => $status]);
				die();
			} else {
				echo json_encode(['status' => 'error', 'error' => 'Something went wrong']);
				die();
			}
		} else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function edit_employee_report(){
		if ($this->session->userdata('auth_key')) {
			$report_id = $this->uri->segment(2);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('er.id,rrcd.user_name,er.start_time,er.end_time,er.total_time,er.break_hours,er.attachments,er.description,er.date,er.user_id');
			$this->RateAndReviewDb->from('employee_report er');
			$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = er.user_id', 'left');
			$this->RateAndReviewDb->where('er.id', $report_id);
			$employee_report = $this->RateAndReviewDb->get();
			$employee_report = $employee_report->row_array();

			$this->load->view('v_edit_employee_report', compact('employee_report'));
		}else {
			redirect('login');
		}
	}

	public function delete_employee_report(){
		if ($this->session->userdata('auth_key')) {
			$report_id = $this->input->post('report_id');
			$user_id = $this->input->post('user_id');
			if ($user_id == "" || $user_id == "undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);

			$this->RateAndReviewDb->select('er.attachments, rrcd.user_name');
			$this->RateAndReviewDb->from('employee_report er');
			$this->RateAndReviewDb->join('RR_customerDetail as rrcd', 'rrcd.id = er.user_id', 'left');
			$this->RateAndReviewDb->where('er.id', $report_id);
			$employee_report = $this->RateAndReviewDb->get();
			$employee_report = $employee_report->row_array();

			$this->RateAndReviewDb->delete('employee_report', array('id' => $report_id));

			$dir_path = FCPATH . 'assets/employee_reports/' . str_replace(" ", "_", $employee_report['user_name']);
			$attachments = explode(",",$employee_report['attachments']);
			foreach ($attachments as $file) {
				if (file_exists($dir_path . '/' . $file)) {
					unlink($dir_path . '/' . $file);
				}
			}

			$html = $this->get_employee_report_list_html($user_id);
			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function get_employee_report_list_html($user_id = ''){
		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
		$this->RateAndReviewDb->select('id, start_time, end_time, total_time, break_hours, description, date');
		if ($user_id != '') {
			$this->RateAndReviewDb->where('user_id', $user_id);
		}
		$this->RateAndReviewDb->from('employee_report');
		$employee_reports = $this->RateAndReviewDb->get();
		$employee_reports = $employee_reports->result_array();

		$check_permission = check_permission("Employee Report");
		$add = $check_permission['add'];
		$edit = $check_permission['edit'];
		$delete = $check_permission['delete'];

		$html = "";
		$i = 1;
		foreach ($employee_reports as $employee_report) {
			$action = "";
			if (isset($edit) && $edit == 1){
				$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="'.base_url() . 'edit_employee_report/' . $employee_report['id'].'"
								   class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>';
			}

			if (isset($delete) && $delete == 1){
				$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn"
								   onclick="delete_employee_report('.$employee_report['id'].')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
			}

			$html .= '<tr>';
			$html .= '<td>' . $i . '</td>';
			$html .= '<td>' . $employee_report['start_time'] . '</td>';
			$html .= '<td>' . $employee_report['end_time'] . '</td>';
			$html .= '<td>' . $employee_report['total_time'] . '</td>';
			$html .= '<td>' . $employee_report['break_hours'] . '</td>';
			$html .= '<td>' . $employee_report['description'] . '</td>';
			$html .= '<td>' . $employee_report['date'] . '</td>';
			$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">'.$action.'</ul>
					  </td>';
			$html .= '</tr>';

			$i++;
		}

		return $html;
	}

	public function get_employee_reportlist(){
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->input->post('userId');
			if ($user_id=="" || $user_id=="undefined"){
				$user_id = $this->session->userdata('user_id');
			}

			$html = $this->get_employee_report_list_html($user_id);
			echo json_encode(['status' => 1, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

}
