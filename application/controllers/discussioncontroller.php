<?php
class discussioncontroller extends CI_Controller{

	function __construct(){  
        parent::__construct();
        $this->load->model('loginmodel');
        $this->load->model('newsfeedmodel');
        $this->load->model('grouppagemodel');
        $this->load->model('discussionmodel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function loadDiscussion($postid) {
        $userid = $this->session->tempdata('accountID');
        $data['userid'] = $userid;
        $data['postid'] = $postid;
        $type = $this->discussionmodel->getType($userid);
       	$data['post'] = $this->discussionmodel->getPosts($postid);
        $data['comments'] = $this->discussionmodel->getComments($postid);
        if($type == "STUDENT"){
            $data['details'] = $this->loginmodel->getDetails($userid);
        }else{
            $data['details'] = $this->loginmodel->getDetailsProf($userid);
        }
        echo $this->load->view('header', NULL, TRUE);
       	echo $this->load->view('discussion', $data , TRUE);
    }

    public function insertComment(){
        $userid = $this->session->tempdata('accountID');
        $postid = $this->input->post('postid');
        $comment = $this->input->post('comment');
        $date = $this->input->post('datetime');

        if($comment == null){
            $this->output->set_status_header('400');
            $data = $this->data['message'] = 'Comment Empty';
        }else{
            $checkusertype = $this->grouppagemodel->checkAccountType($userid);
            if($checkusertype == "STUDENT"){
                $data = $this->loginmodel->getDetails($userid);
                $this->discussionmodel->addComment($postid,$userid,$comment,$date);
            }else{
                $data = $this->loginmodel->getDetailsProf($userid);
                $this->discussionmodel->addComment($postid,$userid,$comment,$date);
            }
        }
        echo json_encode($data);
    }

}
?>