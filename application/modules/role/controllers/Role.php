<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MX_Controller  {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetRolesWithPrivileges = call_api_get($auth_key, 'ManageRoles/GetRolesWithPrivileges?SearchText=null&SortColumn=name&SortOrder=asc&Offset=1&Limit=1000');
			$GetRolesWithPrivileges = json_decode($GetRolesWithPrivileges, true);

			$check_permission = check_permission("Role");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];
			$this->load->view('v_role', compact('GetRolesWithPrivileges', 'add', 'edit', 'delete'));
		}else {
			redirect('login');
		}
	}

	public function add_role(){
		if ($this->session->userdata('auth_key')) {
			$auth_key = $this->session->userdata('auth_key');
			$GetAllPrivileges = call_api_get($auth_key, 'ManageRoles/GetAllPrivileges');

			$GetAllPrivileges = json_decode($GetAllPrivileges, true);
			$this->load->view('v_add_role', compact('GetAllPrivileges'));
		}else {
			redirect('login');
		}
	}

	public function save_role(){
		if ($this->session->userdata('auth_key') && $this->input->is_ajax_request()) {
			$auth_key = $this->session->userdata('auth_key');
			$user_id = $this->session->userdata('user_id');
			$request = $this->input->post();

			$params = array();
			$params['role_name'] = $request['role_name'];
			$params['description'] = $request['description'];
			$params['created_by'] = $user_id;
			$params['role_id'] = isset($request['role_id']) ? $request['role_id'] : 0;
			$params['permission'] = array();
			for ($i=1;$i<=$request['total_permissionForm'];$i++) {
				$myValue = array();
				$str ="permissionForm".$i;
				parse_str($request[$str],$myValue);
				$temp['display_name'] = $myValue['display_name'];
				$temp['privilege_id'] = $myValue['privilege_id'];
				$temp['is_add'] = (isset($myValue['is_add']) && $myValue['is_add']==true) ? true : false;
				$temp['is_edit'] = (isset($myValue['is_edit']) && $myValue['is_edit']==true) ? true : false;
				$temp['is_delete'] = (isset($myValue['is_delete']) && $myValue['is_delete']==true) ? true : false;
				$temp['is_view'] = (isset($myValue['is_view']) && $myValue['is_view']==true) ? true : false;
				array_push($params['permission'], $temp);
			}

			$res = call_api_post($auth_key, "ManageRoles/AddUpdateRolePrivilegePermission", $params);

			echo json_encode(['status' => $res]);
			die();
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}

	public function edit_role(){
		$role_id =  $this->uri->segment(2);
		$auth_key = $this->session->userdata('auth_key');
		$GetRoleWithPrivilegePermissionByRoleId = call_api_get($auth_key, 'ManageRoles/GetRoleWithPrivilegePermissionByRoleId/'.$role_id);

		$GetRoleWithPrivilegePermissionByRoleId = json_decode($GetRoleWithPrivilegePermissionByRoleId, true);
		$this->load->view('v_edit_role', compact('GetRoleWithPrivilegePermissionByRoleId'));
	}

	public function delete_role(){
		if ($this->session->userdata('auth_key')) {
			$role_id = $this->uri->segment(2);
			$auth_key = $this->session->userdata('auth_key');
			$res = call_api_delete($auth_key, 'ManageRoles/DeleteRole/' . $role_id);

			$GetRolesWithPrivileges = call_api_get($auth_key, 'ManageRoles/GetRolesWithPrivileges?SearchText=null&SortColumn=name&SortOrder=asc&Offset=1&Limit=1000');
			$GetRolesWithPrivileges = json_decode($GetRolesWithPrivileges, true);

			$check_permission = check_permission("Role");
			$add = $check_permission['add'];
			$edit = $check_permission['edit'];
			$delete = $check_permission['delete'];

			$html = "";
			foreach ($GetRolesWithPrivileges as $role) {
				$action = "";
				if ($edit == 1) {
					$action .= '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
								<a href="' . base_url() . 'edit_role/' . $role['RoleId'] . '" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
							</li>';
				}
				if ($delete == 1) {
					$action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
								<a class="text-danger d-inline-block remove-item-btn" onclick="delete_role(' . $role['RoleId'] . ')"><i class="ri-delete-bin-5-fill fs-16"></i></a>
							</li>';
				}

				$html .= '<tr>';
				$html .= '<td>' . $role['Name'] . '</td>';
				$html .= '<td>' . $role['Privilege'] . '</td>';
				$html .= '<td>
						<ul class="list-inline hstack gap-2 mb-0">' . $action . '</ul>
					</td>';
				$html .= '</tr>';
			}

			echo json_encode(['status' => $res, 'html' => $html]);
			die();
		}
		else {
			echo json_encode(['status' => 404]);
			exit;
		}
	}
}
