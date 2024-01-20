<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_report extends MX_Controller
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
			$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name, rv.positive_description, rv.negative_description');
			$this->RateAndReviewDb->from('Responded_Reviews rv');
			$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
			$this->RateAndReviewDb->where('rv.client_id', $user_id);
			$this->RateAndReviewDb->where('respond_date', $curr_date);
			$this->RateAndReviewDb->where('rv.is_deleted', 0);
			$Responded_Reviews = $this->RateAndReviewDb->get();
			$Responded_Reviews = $Responded_Reviews->result_array();
			$hotel_names = array_column($Responded_Reviews, 'hotel_name');
			$hotel_names = array_unique($hotel_names);

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('ht.hotel_name, rc.conclusion');
			$this->RateAndReviewDb->from('Review_Conclusion rc');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rc.hotel_id', 'left');
			$this->RateAndReviewDb->where('ht.client_id', $user_id);
			$this->RateAndReviewDb->where('rc.date', $curr_date);
			$conclusions = $this->RateAndReviewDb->get();
			$conclusions = $conclusions->result_array();

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $user_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$username = $this->RateAndReviewDb->get();
			$username = $username->row_array();

			$page = "review_report";
			$this->load->view('v_review_report', compact('username', 'curr_date', 'Responded_Reviews', 'hotel_names', 'conclusions', 'page'));
		} else {
			redirect('login');
		}
	}

	public function filter_review_report()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = $this->input->post('user_id');
			$user_name = $this->input->post('user_name');
			$hotel_id = $this->input->post('hotel_id');
			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			if ($user_id == "") {
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
			$respond_date = date("m-d-Y", strtotime($date));

			$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name, rv.positive_description, rv.negative_description');
			$this->RateAndReviewDb->from('Responded_Reviews rv');
			$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
			$this->RateAndReviewDb->where('rv.client_id', $user_id);
			if ($hotel_id!="" && $hotel_id!="all"){
				$this->RateAndReviewDb->where('ht.id', $hotel_id);
			}
			$this->RateAndReviewDb->where('respond_date', $date);
			$this->RateAndReviewDb->where('rv.is_deleted', 0);
			$Responded_Reviews = $this->RateAndReviewDb->get();
			$Responded_Reviews = $Responded_Reviews->result_array();
			$hotel_names = array_column($Responded_Reviews, 'hotel_name');
			$hotel_names = array_unique($hotel_names);

			$this->RateAndReviewDb->select('ht.hotel_name, rc.conclusion');
			$this->RateAndReviewDb->from('Review_Conclusion rc');
			$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rc.hotel_id', 'left');
			$this->RateAndReviewDb->where('ht.client_id', $user_id);
			if ($hotel_id!="" && $hotel_id!="all"){
				$this->RateAndReviewDb->where('ht.id', $hotel_id);
			}
			$this->RateAndReviewDb->where('rc.date', $date);
			$conclusions = $this->RateAndReviewDb->get();
			$conclusions = $conclusions->result_array();

			$review_report_data = $this->review_report_html($hotel_names, $Responded_Reviews, $conclusions);

			echo json_encode(['status' => 1, 'html' => $review_report_data['html'], 'user_name' => $user_name, 'respond_date' => $respond_date, 'hotel_wise_data' => $review_report_data['hotel_wise_data']]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function review_report_html($hotel_names, $Responded_Reviews, $conclusions)
	{
		$html = "";
		$hotel_wise_data = array();
		if (isset($hotel_names) && !empty($hotel_names)) {
			foreach ($hotel_names as $key => $hotel_name) {
				$hotel_wise_data[$hotel_name] = array();
				$html .= '<div class="card-body py-2 p-4 border-top border-top-dashed">
						  <h3 class=" mt-2 mb-3">' . $hotel_name . '</h3>
						  <div class="row">
							<div class="col-6">
								<canvas class="review_report_chart" hotel="' . $hotel_name . '" width="" height="" id="review_report_chart_' . $key . '"></canvas>
							</div>
							<div class="col-6">
								<img class="review_report_chart_url" hotel="' . $hotel_name . '" id="review_report_chart_url_' . $key . '" style="display: none"/>
							</div>
						</div>						
						<div class=" mb-1 row g-2 mt-2">
							<div class="col-lg-12 col-12">
								<div class="table-responsive">
									<table class="table-bordered" cellpadding="10">
										<thead>
										<tr class="">
											<th class="">Website</th>
											<th class="">Positive Review</th>
											<th class="">Negative Review</th>
											<th class="">Total Review</th>
											<th class="">Notes</th>
										</tr>
										</thead>
										<tbody id="products-list">';
				if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
					foreach ($Responded_Reviews as $Responded_Review) {
						if ($Responded_Review['hotel_name'] == $hotel_name) {
							array_push($hotel_wise_data[$hotel_name], $Responded_Review);
							$html .= '<tr>
										<td>' . ucfirst($Responded_Review['Name']) . '</td>
										<td>' . $Responded_Review['positive_review'] . '</td>
										<td>' . $Responded_Review['negative_review'] . '</td>
										<td>' . $Responded_Review['total_reviews'] . '</td>
										<td>' . ucfirst($Responded_Review['notes']) . '</td>
									</tr>';
						}
					}
				} else {
					$html .= '<tr>
								<td colspan="6" style="text-align: center">No records found</td>
							</tr>';
				}
				$html .= '</tbody>
							</table>
							</div>
							</div>
						</div>
					</div>';

				$html .= '<div class="card-body p-4 ">
							<div class="row g-3">
								<div class="col-sm-12">
								<h4 class=" mt-2 mb-3">Positive Review Feedback:</h4>';
				if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
					foreach ($Responded_Reviews as $Responded_Review) {
						if ($Responded_Review['hotel_name'] == $hotel_name) {
							$positive_description = ($Responded_Review['positive_description']!="")?ucfirst($Responded_Review['positive_description']):"";
							$html .= '<p class="fw-medium fs-18 mb-1" >' . ucfirst($Responded_Review['Name']) . ':</p>';
							$html .= '<p class="fs-16 mb-2" >' . $positive_description . '</p>';
						}
					}
				}
				$html .= '</div>';

				$html .= '<div class="mb-1 col-sm-12 mt-2">
				<h4 class=" mt-2 mb-3">Negative Review Feedback:</h4>';
				if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
					foreach ($Responded_Reviews as $Responded_Review) {
						if ($Responded_Review['hotel_name'] == $hotel_name) {
							$negative_description = ($Responded_Review['negative_description']!="")?ucfirst($Responded_Review['negative_description']):"";
							$html .= '<p class="fw-medium fs-18 mb-1" >' . ucfirst($Responded_Review['Name']) . ':</p>
									<p class="fs-16 mb-2" >' . $negative_description . '</p>';
						}
					}
				}
				$html .= '</div>';

				$html .= '<div class="col-sm-12">';
				if (isset($conclusions) && !empty($conclusions)) {
					foreach ($conclusions as $conclusion) {
						if ($conclusion['hotel_name'] == $hotel_name && $conclusion['conclusion'] != "") {
							$html .= '<h4 class=" mt-2 mb-3">Conclusion</h4>
									<p class="fs-16 mb-2" >' . ucfirst($conclusion['conclusion']) . '</p>';
						}
					}
				}
				$html .= '</div>
						</div>
						</div>';
			}
		}
		else {
			$html .= '<div class="card-body p-4 ">
							<div class="row g-3">
								<div class="col-sm-12">
									<h4>There is no reviews to respond OR Pending to check</h4>
								</div>
							</div>
						</div>';
		}

		return ['hotel_wise_data' => $hotel_wise_data, 'html' => $html];
	}

	public function send_mail_review_report()
	{
		if ($this->session->userdata('auth_key')) {
			$user_id = trim($this->input->post('user_id'));
			$user_name = trim($this->input->post('user_name'));
			$hotel_id = trim($this->input->post('hotel_id'));
			$hotel_name = trim($this->input->post('hotel_name'));
			$date = trim($this->input->post('date'));
			$chart_urls = $this->input->post('chart_urls');

			$pdf_data = $this->review_report_pdf($user_id, $user_name, $hotel_id, $hotel_name, $date, $chart_urls);

			if ($user_id == "" || $user_id == "undefined") {
				$user_id = $this->session->userdata('user_id');
			}

			$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
			$this->RateAndReviewDb->select('user_email');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $user_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$user_email = $this->RateAndReviewDb->get();
			$user_email = $user_email->row_array();

			$this->RateAndReviewDb->select('email,copy_recipients');
			$this->RateAndReviewDb->from('client_hotels');
			$this->RateAndReviewDb->where('client_id', $user_id);
			if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="undefined" && $hotel_id!="null"){
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

			$body = '<p style="margin: 0px">Hi, ' . $user_name . '</p>
					 <p style="margin: 0px">Please, see the attached report for Responded Reviews.</p>
					 <p style="margin: 0px">Thanks.</p>
					 <div></div><br>
					 <p style="margin: 0px">Best Regards,</p>
					 <p style="margin: 0px">Psmtech Team</p>';

			$this->load->config('email');
			$this->load->library('email');
			$from = $this->config->item('smtp_user');
			$this->email->from($from);
			$this->email->to($to_mail);
			$cc_array = array();
//			array_push($cc_array, 'inn501.inngenius@gmail.com');
			$this->email->cc(array_merge($cc_mail,$cc_array));
			$this->email->subject("Responded Review Details");
			$this->email->message($body);
			$this->email->attach(base_url($pdf_data['file_path']));
			if ($hotel_id=="" || $hotel_id=="all" || $hotel_id=="undefined" || $hotel_id=="null"){
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
				$this->email->attach(base_url($pdf_data['file_path']));
				$this->email->send();

				echo json_encode(['status' => 'failed']);
				exit;
			}
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function save_pdf()
	{
		if ($this->session->userdata('auth_key')) {
			$user_name = trim($this->input->post('user_name'));
			$date = trim($this->input->post('date'));
			$hotel_name = trim($this->input->post('hotel_name'));

			$dir_path = FCPATH . 'application/pdf/' . str_replace(" ", "_", $user_name);
			if (!is_dir($dir_path)) {
				mkdir($dir_path, 0777, TRUE);
			}

			$date = date('m_d_Y');
			if ($hotel_name == "All Hotels"){
				$user_name = str_replace(" ","_", $user_name);
				$file_name = $user_name."_".$date . '.pdf';
			}
			else {
				$hotel_name = implode('', array_map(function($v) { return $v[0]; }, explode(' ', $hotel_name)));
				$file_name = strtoupper($hotel_name)."_".$date . '.pdf';
			}

			if (file_exists($dir_path . '/' . $file_name)) {
				unlink($dir_path . '/' . $file_name);
			}

			move_uploaded_file($_FILES['pdf']['tmp_name'], $dir_path . '/' . $file_name);
			echo json_encode(['status' => 1]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function view_review_report_pdf(){
//		pre($this->input->post());
		if ($this->session->userdata('auth_key')) {
			$user_id = trim($this->input->post('user_id'));
			$user_name = trim($this->input->post('user_name'));
			$hotel_id = trim($this->input->post('hotel_id'));
			$hotel_name = trim($this->input->post('hotel_name'));
			$date = trim($this->input->post('date'));
			$chart_urls = $this->input->post('chart_urls');

			$pdf_data = $this->review_report_pdf($user_id, $user_name, $hotel_id, $hotel_name, $date, $chart_urls);

			echo json_encode(['status' => 1, 'url' => base_url($pdf_data['file_path'])]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function review_report_pdf($user_id, $user_name, $hotel_id, $hotel_name, $date, $chart_urls){
		require FCPATH . 'vendor/autoload.php';

		$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
		if ($user_id == "" || $user_id == "undefined") {
			$user_id = $this->session->userdata('user_id');

			$this->RateAndReviewDb->select('user_name');
			$this->RateAndReviewDb->from('RR_CustomerDetail');
			$this->RateAndReviewDb->where('id', $user_id);
			$this->RateAndReviewDb->where('user_status', 1);
			$username = $this->RateAndReviewDb->get();
			$username = $username->row_array();
			$user_name = $username['user_name'];
		}
		if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="null"){
			$this->RateAndReviewDb->select('hotel_code');
			$this->RateAndReviewDb->from('client_hotels');
			$this->RateAndReviewDb->where('id', $hotel_id);
			$this->RateAndReviewDb->where('is_deleted', 0);
			$hotel_code = $this->RateAndReviewDb->get();
			$hotel_code = $hotel_code->row_array();
			$hotel_code = $hotel_code['hotel_code'];
		}
		$respond_date = date("m-d-Y", strtotime($date));

		$this->RateAndReviewDb->select('rv.website_id, rv.hotel_id, rv.positive_review, rv.negative_review, rv.total_reviews, rv.notes, ww.Name, ht.hotel_name, rv.positive_description, rv.negative_description');
		$this->RateAndReviewDb->from('Responded_Reviews rv');
		$this->RateAndReviewDb->join('ci_websites as ww', 'ww.id = rv.website_id', 'left');
		$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rv.hotel_id', 'left');
		$this->RateAndReviewDb->where('rv.client_id', $user_id);
		if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="null"){
			$this->RateAndReviewDb->where('ht.id', $hotel_id);
		}
		$this->RateAndReviewDb->where('respond_date', $date);
		$this->RateAndReviewDb->where('rv.is_deleted', 0);
		$Responded_Reviews = $this->RateAndReviewDb->get();
		$Responded_Reviews = $Responded_Reviews->result_array();
		$hotel_names = array_column($Responded_Reviews, 'hotel_name');
		$hotel_names = array_unique($hotel_names);

		$this->RateAndReviewDb->select('ht.hotel_name, rc.conclusion');
		$this->RateAndReviewDb->from('Review_Conclusion rc');
		$this->RateAndReviewDb->join('client_hotels as ht', 'ht.id = rc.hotel_id', 'left');
		$this->RateAndReviewDb->where('ht.client_id', $user_id);
		if ($hotel_id!="" && $hotel_id!="all" && $hotel_id!="null"){
			$this->RateAndReviewDb->where('ht.id', $hotel_id);
		}
		$this->RateAndReviewDb->where('rc.date', $date);
		$conclusions = $this->RateAndReviewDb->get();
		$conclusions = $conclusions->result_array();

		if ($chart_urls != ""){
			$data['chart_urls'] = $chart_urls;
		}
		$data['user_name'] = $user_name;
		$data['respond_date'] = $respond_date;
		$data['hotel_names'] = $hotel_names;
		$data['Responded_Reviews'] = $Responded_Reviews;
		$data['conclusions'] = $conclusions;
		$html = $this->load->view('v_review_report_pdf', $data, true);
//			echo $html; die();

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'P',
			'margin_header' => '3',
			'margin_top' => '5',
			'margin_bottom' => '5',
			'margin_footer' => '2',
			'debug' => true,
			'allow_output_buffering' => true,
			'img_dpi' => 300
		]);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->curlAllowUnsafeSslRequests = true;
		$mpdf->showImageErrors = true;
		$mpdf->WriteHTML($html);

		$dir_path = FCPATH . 'assets/review_reports/' . str_replace(" ", "_", $user_name);
		if (!is_dir($dir_path)) {
			mkdir($dir_path, 0777, TRUE);
		}
		$date = date('m_d_Y', strtotime($date));
		if ($hotel_name == "All Hotels" || $hotel_name=="" || $hotel_name=="undefined"){
			$user_name = str_replace(" ","_", $user_name);
			$file_name = $user_name."_".$date . '.pdf';
		}
		else {
			if (isset($hotel_code) && $hotel_code!=""){
				$file_name = $hotel_code."_".$date . '.pdf';
			}
			else {
				$hotel_name = implode('', array_map(function ($v) {
					return $v[0];
				}, explode(' ', $hotel_name)));
				$file_name = strtoupper($hotel_name) . "_" . $date . '.pdf';
			}
		}
		if (file_exists($dir_path . '/' . $file_name)) {
			unlink($dir_path . '/' . $file_name);
		}
		$file_path = 'assets/review_reports/'.str_replace(" ", "_", $user_name)."/".$file_name;
		$mpdf->Output($file_path, 'F');

		return ['file_path' => $file_path];
	}
}
