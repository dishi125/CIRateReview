<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = "login";
$route['logout'] = 'logout';

$route['forgot_password'] = 'forgot_password';
$route['reset_password/(:any)'] = 'forgot_password/reset_password';

$route['GetOwnHotelsByCustomer'] = 'login/GetOwnHotelsByCustomer';

$route['dashboard'] = "dashboard";
$route['fetch_city'] = "dashboard/fetch_city";
$route['filters'] = 'dashboard/filters';
$route['get_single_hotel_data/(:any)/(:any)'] = 'dashboard/get_single_hotel_data/$1/$2';
$route['clear_all'] = 'dashboard/clear_all';
$route['get_data_filter'] = 'dashboard/get_data_filter';

$route['settings/role'] = "role";
$route['add_role'] = "role/add_role";
$route['save_role'] = "role/save_role";
$route['edit_role/(:num)'] = "role/edit_role/$1";
$route['delete_role/(:num)'] = "role/delete_role/$1";

$route['settings/comp-set'] = "comp_set";
$route['GetAllCityByState'] = "comp_set/GetAllCityByState";
$route['GetHotelName'] = "comp_set/GetHotelName";
$route['Gethotelwithinradius'] = "comp_set/Gethotelwithinradius";
$route['GetAllHotelsRoomTypeByParam'] = "comp_set/GetAllHotelsRoomTypeByParam";
$route['GetUsers'] = "comp_set/GetUsers";
$route['save_mapped_hotel'] = "comp_set/save_mapped_hotel";
$route['CheckHotelValidation'] = "comp_set/CheckHotelValidation";

$route['settings/hotel'] = "hotel";
$route['settings/competitorHotel'] = "hotel";
$route['add_hotel/(:any)'] = "hotel/add_hotel";
$route['getAddress_RoomTypes'] = "hotel/getAddress_RoomTypes";
$route['save_hotel'] = "hotel/save_hotel";
$route['edit_hotel/(:num)/(:any)'] = "hotel/edit_hotel/$1/$2";
$route['delete_hotel/(:any)'] = "hotel/delete_hotel";
$route['filter_hotel/(:any)'] = "hotel/filter_hotel";
$route['update_hotel'] = "hotel/update_hotel";
$route['getProperty/(:any)'] = "hotel/getProperty";

$route['settings/customer'] = "customer";
$route['add_customer'] = "customer/add_customer";
$route['save_customer'] = "customer/save_customer";
$route['edit_customer/(:num)'] = "customer/edit_customer/$1";
$route['delete_customer/(:num)'] = "customer/delete_customer/$1";

$route['settings/manage_property'] = "property_code";
$route['add_property'] = "property_code/add_property";
$route['save_property'] = "property_code/save_property";
$route['edit_property/(:num)'] = "property_code/edit_property/$1";
$route['delete_property/(:num)/(:any)'] = "property_code/delete_property/$1/$2";
$route['filter_property/(:num)'] = "property_code/filter_property/$1";

$route['rate_analysis'] = "rate_analysis";
$route['rate_analysis/tab/(:any)'] = "rate_analysis/index";
$route['rate_analysis/ajax_call'] = "rate_analysis/ajax_call";
$route['rate_analysis/ajax_website_historical_rate'] = "rate_analysis/ajax_website_historical_rate";
$route['rate_analysis/filter_data/(:num)'] = "rate_analysis/filter_data/$1";
$route['website_historical_rate/filter_data/(:num)'] = "rate_analysis/filter_website_historical_rate_data/$1";
$route['website_historical_rate/filter_calender_data'] = "rate_analysis/filter_calender_data";
$route['website_historical_rate/getDateWiseBookingDetails'] = "rate_analysis/getDateWiseBookingDetails";
$route['rate_analysis/filter_chart'] = "rate_analysis/filter_chart";
$route['rate_analysis/filter_website_analysis_chart'] = "rate_analysis/filter_website_analysis_chart";
$route['website_analysis/filter_data_hotelwise/(:num)'] = "rate_analysis/filter_data_hotelwise";
$route['rate_analysis/Hoteldropdownfilter'] = "rate_analysis/Hoteldropdownfilter";
$route['rate_analysis/filter_hotels_historical_rate_data'] = "rate_analysis/filter_hotels_historical_rate_data";

$route['system_analysis_dashboard'] = "system_analysis_dashboard";
$route['view_states/(:any)'] = "system_analysis_dashboard/view_states";
$route['get_state_list/(:any)'] = "system_analysis_dashboard/get_state_list";
$route['get_city_list/(:any)/(:num)'] = "system_analysis_dashboard/get_city_list";
$route['get_hotel_list/(:any)/(:num)'] = "system_analysis_dashboard/get_hotel_list";
$route['view_cities/(:any)'] = "system_analysis_dashboard/view_cities";
$route['view_hotels/(:any)'] = "system_analysis_dashboard/view_hotels";

## REVIEW MANAGEMENT
$route['review_management/manage_website'] = "manage_website";
$route['review_management/manage_hotels'] = "manage_hotels";
$route['review_management/respond_review'] = "respond_review";
$route['review_management/rr_dashboard'] = "rr_dashboard";
$route['add_hotels'] = "manage_hotels/add_hotels";
$route['edit_hotels/(:num)'] = "manage_hotels/edit_hotels";
$route['save_clients_hotel'] = "manage_hotels/save_clients_hotel";
$route['delete_client_hotel'] = "manage_hotels/delete_client_hotel";
$route['get_client_hotellist/(:num)'] = "manage_hotels/get_client_hotellist/$1";


$route['manage_website'] = "manage_website";
$route['rr_dashboard'] = "rr_dashboard";

$route['review_management'] = "manage_credentials";
$route['review_management/manage_credentials'] = "manage_credentials";
$route['add_cred'] = "manage_credentials/add_cred";
$route['save_credentials'] = "manage_credentials/save_credentials";
$route['delete_credentials'] = "manage_credentials/delete_credentials";
$route['edit_credentials/(:num)'] = "manage_credentials/edit_credentials/$1";
$route['save_credentials/(:num)'] = "manage_credentials/save_credentials/$1";
$route['get_client_credlist/(:num)'] = "manage_credentials/get_client_credlist/$1";

$route['add_respond'] = "respond_review/add_respond";
$route['save_respond'] = "respond_review/save_respond";
$route['update_respond'] = "respond_review/update_respond";
$route['edit_respond/(:num)'] = "respond_review/edit_respond/$1";
$route['get_client_respondlist'] = "respond_review/get_client_respondlist";
$route['delete_respond'] = "respond_review/delete_respond";
$route['conclusion'] = "respond_review/conclusion";
$route['add_conclusion'] = "respond_review/add_conclusion";
$route['edit_conclusion/(:num)'] = "respond_review/edit_conclusion";
$route['save_conclusion'] = "respond_review/save_conclusion";
$route['delete_conclusion'] = "respond_review/delete_conclusion";
$route['filter_conclusions'] = "respond_review/filter_conclusions";

$route['save_website'] = "manage_website/save_website";
$route['delete_website/(:num)'] = "manage_website/delete_website/$1";
$route['edit_website/(:num)'] = "manage_website/edit_website/$1";
$route['add_website/(:any)'] = "manage_website/add_website";
$route['GetHotelNameByWebsite'] = "manage_credentials/GetHotelNameByWebsite";

$route['review_management/review_summary'] = "review_summary";
$route['filter_review_Summary'] = "review_summary/filter_review_Summary";
$route['send_mail_review_summary'] = "review_summary/send_mail_review_summary";

$route['review_report'] = "review_report";
$route['filter_review_report'] = "review_report/filter_review_report";
$route['send_mail_review_report'] = "review_report/send_mail_review_report";
$route['save_pdf'] = "review_report/save_pdf";
$route['view_review_report_pdf'] = "review_report/view_review_report_pdf";

$route['review_management/view_report'] = "view_report";
$route['filter_view_report'] = "view_report/filter_view_report";
$route['view_report_pdf'] = "view_report/view_report_pdf";
$route['send_mail_view_report'] = "view_report/send_mail_view_report";
$route['demo_view_report_pdf'] = "view_report/demo_view_report_pdf"; //demo page

//Employee report module
$route['employee_report'] = "employee_report";
$route['add_employee_report'] = "employee_report/add_employee_report";
$route['save_employee_report'] = "employee_report/save_employee_report";
$route['edit_employee_report/(:num)'] = "employee_report/edit_employee_report/$1";
$route['delete_employee_report'] = "employee_report/delete_employee_report";
$route['get_employee_reportlist'] = "employee_report/get_employee_reportlist";

$route['dm_customer_signup_list'] = "dm_customer_signup/customer_signup_list";
$route['dm_customer_signup'] = "dm_customer_signup";
$route['save_customer_signup'] = "dm_customer_signup/save_customer_signup";
$route['edit_dm_hotel/(:num)'] = "dm_customer_signup/edit_dm_hotel";
$route['update_customer_signup'] = "dm_customer_signup/update_customer_signup";
$route['delete_dm_hotel/(:num)'] = "dm_customer_signup/delete_dm_hotel";
$route['delete_dm_corporate/(:num)'] = "dm_customer_signup/delete_dm_corporate";
$route['view_dm_hotel/(:num)'] = "dm_customer_signup/view_dm_hotel";
$route['demo_image_uploader'] = "dm_customer_signup/demo_image_uploader";  //demo page
$route['save_demo_image_uploader'] = "dm_customer_signup/save_demo_image_uploader";  //demo page

$route['chat'] = "chat";

$route['support'] = "support";
$route['save_support'] = "support/save_support";
$route['support_list'] = "support/list_support";
$route['support_details'] = "support/support_details";
$route['update_support'] = "support/update_support";
$route['delete_support/(:num)'] = "support/delete_support";

$route['review_management/mail_status'] = "mail_status";
