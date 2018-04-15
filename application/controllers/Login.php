<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){  
        parent::__construct();
        $this->load->model('loginmodel');
        $this->load->model('newsfeedmodel');
        $this->load->model('administratormodel');
        $this->load->model('grouppagemodel');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
    }
    
	public function index()
	{
		$data['incorrect'] = FALSE;
		$this->load->view('header');
		$this->load->view('loginview',$data);
	}

	public function Login(){
		$userid = $this->input->post('studentID');
		$userpw = $this->input->post('password');

		$this->session->set_tempdata('accountID',$userid,18000);

		$validate = $this->loginmodel->validateAccount($userid,$userpw);
		if($validate == NULL){
			$data = array(
				'error_message' => 'Invalid Username or Password !'
				);
			$this->load->view('header');
			$this->load->view('loginview',$data);
		}
		else{
			$data['details'] = $this->loginmodel->getUserType($userid);
			if(is_array($data) || is_object($data)){
				foreach ($data as $key => $value) {
					$type = $value->accounts_type;
				}
			}
			$this->session->set_tempdata('accountID',$userid,18000);
			$userid = $this->session->tempdata('accountID');
			$data['init'] = $this->loginmodel->getGroups($userid);
			$data['groupId'] = $userid;
			if($type == "STUDENT"){
				$data['details'] = $this->loginmodel->getDetails($userid);
				$this->load->view('header');
				$this->load->view('sidenav1', $data);
			}
			elseif($type == "PROFESSOR"){
				$data['details'] = $this->loginmodel->getDetailsProf($userid);
				$this->load->view('header');
				$this->load->view('sidenav2', $data);
			}
			elseif($type == "ADMIN"){
				$collegecos= 'COS';
		    	$collegecla = 'CLA';
		    	$collegecafa = 'CAFA';
		    	$collegecoe = 'COE';
		    	$collegecie = 'CIE';
		    	$collegecit= 'CIT';

		    	$data['cos'] = $this->administratormodel->initializeGraphValues($collegecos);
		    	$data['cla'] = $this->administratormodel->initializeGraphValues($collegecla);
		    	$data['cafa'] = $this->administratormodel->initializeGraphValues($collegecafa);
		    	$data['coe'] = $this->administratormodel->initializeGraphValues($collegecoe);
		    	$data['cie'] = $this->administratormodel->initializeGraphValues($collegecie);
		    	$data['cit'] = $this->administratormodel->initializeGraphValues($collegecit);
				$this->load->view('header');
				$this->load->view('sidenav4',$data);
			}
			else{
				$data['details'] = $this->loginmodel->getDetails($userid);
				$data['userid'] = $this->session->tempdata('accountID');
				$this->load->view('header');
				$this->load->view('sidenavalumni',$data);
			}	
		}	
	}
	
	public function Upload(){
		$config['upload_path'] = 'assets/images';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']		=0;
		$config['max_width']	=0;
		$config['max_height']	=0;

		$this->upload->initialize($config);

		if ($this->upload->do_upload('profile_pic_input')) {
	        	//File upload
	        	$uploadData = $this->upload->data(); 
  				$filename = $uploadData['file_name'];
  				$account_id =  $this->session->tempdata('accountID');
  				$this->loginmodel->upload_model($filename,$account_id);
	        }	
 
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect();
	}
}
