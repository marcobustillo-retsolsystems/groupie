<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['newsfeed'] = 'Login/Login';

$route['newsfeedRefresh'] = 'newsfeedcontroller/showPost';
$route['insertPost'] = 'grouppagecontroller/insertPost';
$route['createGroup'] = 'grouppagecontroller/createGroup';
$route['changePassword'] = 'newsfeedcontroller/changepassword';
$route['addMember'] = 'grouppagecontroller/addMember';
$route['search'] = 'grouppagecontroller/search';
$route['CreateEvent'] = 'grouppagecontroller/createevent';
$route['GeneratePDF'] = 'administrator/generatePDF';
$route['sendEmail'] = 'administrator/sendEmail';
$route['removeMember'] = 'grouppagecontroller/removeMember';
$route['setModerator'] = 'grouppagecontroller/setModerator';
$route['getGraduates'] = 'administrator/initializeGraduates';
$route['uploadImage'] = 'grouppagecontroller/uploadImage';
$route['uploadFile'] = 'grouppagecontroller/uploadFile';
$route['uploadImageEvent'] = 'grouppagecontroller/uploadImageEvent';
$route['insertComment'] = 'discussioncontroller/insertComment';
$route['approvePost'] = 'grouppagecontroller/approvePost';
$route['refreshGroup'] = 'grouppagecontroller/refreshGroupPost';
$route['refreshEvents'] = 'grouppagecontroller/refreshEvents';
$route['refreshMembers'] = 'grouppagecontroller/refreshMembers';
$route['addAnswer'] = 'surveycontroller/addAnswer';
$route['thankyou'] = 'surveycontroller/loadThankyou';
$route['thankyou1'] = 'surveycontroller/loadThankyou1';
$route['groups/(:any)'] = 'grouppagecontroller/loadGroup/$1';
$route['groupprof/(:any)'] = 'grouppagecontroller/loadGroupProfessor/$1';
$route['groupsAlumni/(:any)'] = 'grouppagecontroller/groupsAlumni/$1';
$route['discuss/(:any)'] = 'discussioncontroller/loadDiscussion/$1';