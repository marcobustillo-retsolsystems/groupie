<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class newsfeedcontroller extends CI_Controller{

	function __construct(){  
        parent::__construct();
        $this->load->model('newsfeedmodel');
        $this->load->model('grouppagemodel');
        $this->load->model('loginmodel');
        $this->load->helper('url');
        $this->load->library('session');
    }

 	function showPost(){
 		$userid = $this->session->tempdata('accountID');
 		$data['init'] = $this->newsfeedmodel->getPost($userid);
 		echo $this->load->view('header', NULL, TRUE);
 		echo $this->load->view('newsfeed',$data,TRUE);
 	}

 	function changepassword(){
 		$id = $this->input->post('id');
 		$oldpassword = $this->input->post('oldpass');
 		$newpassword = $this->input->post('newpass');
 		$confirmnewpassword = $this->input->post('confirmnewpass');
 		$passwordValidation = $this->loginmodel->validateAccount($id,$oldpassword);
 		if($passwordValidation == NULL){
 			$this->output->set_status_header('400'); //Triggers the jQuery error callback
        	$this->data['message'] = 'Old Password Wrong';
 		}else{
 			if($newpassword == $confirmnewpassword){
 				$this->newsfeedmodel->updatePassword($id,$newpassword);
 				$this->data['message'] = 'Success';
 			}else{
 			$this->output->set_status_header('400'); //Triggers the jQuery error callback
        	$this->data['message'] = 'Error';
 			}
			
 		}
 		echo json_encode($this->data);

 	}

}

?>
