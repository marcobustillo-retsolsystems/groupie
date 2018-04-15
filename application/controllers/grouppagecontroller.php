<?php
class grouppagecontroller extends CI_Controller{

	function __construct(){  
        parent::__construct();
        $this->load->model('loginmodel');
        $this->load->model('newsfeedmodel');
        $this->load->model('grouppagemodel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function insertPost(){
        $userid = $this->session->tempdata('accountID');
        $groupId = $this->input->post('id');
        $text = $this->input->post('text');
        $date = $this->input->post('datetime');
        $image = $this->input->post('image');
        $file = $this->input->post('file');
        $filename = $this->input->post('file');
        $approve = $this->input->post('approve');
        $whatIWant = substr($file, strpos($file, ".") + 1);
        if(($text == null) && ($image == null) && ($filename == null) || ($text == '') && ($image == '') && ($filename == '')){
            $this->output->set_status_header('400');
            $data = $this->data['message'] = 'Post Empty';

        }else{
             $checkusertype = $this->grouppagemodel->checkAccountType($userid);

            if($checkusertype == "STUDENT"){
                $checkifEmpty = $this->grouppagemodel->checkifEmpty($groupId);
                if($checkifEmpty == NULL){
                    $lastgroupid = 0;
                    $groupIdStringLength = strlen($groupId) + 1;
                    $postIncrement = substr($lastgroupid, $groupIdStringLength) + 1;
                    $this->grouppagemodel->addPost($userid,$groupId,$text,$image,$file,$filename,$date,$postIncrement,$approve);
                    $data = $this->grouppagemodel->getlastwithDetails($groupId,$userid);
                    
                }else{
                    $lastgroupid = $this->grouppagemodel->getLastPost($groupId);
                    $groupIdStringLength = strlen($groupId) + 1;
                    $postIncrement = substr($lastgroupid, $groupIdStringLength) + 1;
                    $this->grouppagemodel->addPost($userid,$groupId,$text,$image,$file,$filename,$date,$postIncrement,$approve);
                    $data = $this->grouppagemodel->getlastwithDetails($groupId,$userid);    
                }
            }else{
                $checkifEmpty = $this->grouppagemodel->checkifEmpty($groupId);
                if($checkifEmpty == NULL){
                    $lastgroupid = 0;
                    $groupIdStringLength = strlen($groupId) + 1;
                    $postIncrement = substr($lastgroupid, $groupIdStringLength) + 1;
                    $this->grouppagemodel->addPost($userid,$groupId,$text,$image,$file,$filename,$date,$postIncrement,$approve);
                    $data = $this->grouppagemodel->getlastwithDetails($groupId,$userid);
                    
                }else{
                    $lastgroupid = $this->grouppagemodel->getLastPost($groupId);
                    $groupIdStringLength = strlen($groupId) + 1;
                    $postIncrement = substr($lastgroupid, $groupIdStringLength) + 1;
                    $this->grouppagemodel->addPost($userid,$groupId,$text,$image,$file,$filename,$date,$postIncrement,$approve);
                    $data = $this->grouppagemodel->getlastwithDetails($groupId,$userid);   
                }
            }
        }
        echo json_encode($data);
    }



    public function createGroup(){
        $userid = $this->session->tempdata('accountID');
        $groupName = $this->input->post('groupName');
        $lastgroupid = $this->grouppagemodel->getLastGroup();
        $groupincreament = substr($lastgroupid, 6) + 1;
        $groupId = $this->grouppagemodel->newGroup($userid,$groupincreament,$groupName);
        
        echo json_encode($groupId);
    }

    public function loadGroup($groupId) {
        $userid = $this->session->tempdata('accountID');
        $data['userid'] = $userid;
        $data['init'] = $this->grouppagemodel->getGrouppost($groupId);
        $data['events'] = $this->grouppagemodel->getEvents($groupId);
        $data['GroupMembers'] = $this->grouppagemodel->getMembers($groupId);
        $data['groupId'] = $groupId;
        $data['approve'] = $this->grouppagemodel->getApprovePost($groupId);
        $usertype = $this->grouppagemodel->checkAccountType($userid);
        echo $this->load->view('header', NULL, TRUE);
        if($usertype == "STUDENT"){
            $data['details'] = $this->loginmodel->getDetails($userid);
            $checkmod = $this->grouppagemodel->checkModerator($groupId,$userid);
            if($checkmod == 1){
                echo $this->load->view('gpagemoderator', $data, TRUE);
            }else{
                echo $this->load->view('gpagestud', $data, TRUE);
            }
        }elseif($usertype == "PROFESSOR"){
            $data['details'] = $this->loginmodel->getDetailsProf($userid);
            echo $this->load->view('gpageprof',$data,TRUE);
        }else{
             $data['details'] = $this->loginmodel->getDetails($userid);
            $checkmod = $this->grouppagemodel->checkModerator($groupId,$userid);
            if($checkmod == 1){
                echo $this->load->view('gpagealumnimod', $data, TRUE);
            }else{
                echo $this->load->view('gpagealumni', $data, TRUE);
            }
        }
    }

    public function loadGroupAlumni($groupId){

    }

    public function refreshGrouppost(){
        $groupId = $this->input->post('id');
        $userid = $this->session->tempdata('accountID');
        //$data = $this->loginmodel->getDetails($userid);
        $data = $this->grouppagemodel->getGrouppost($groupId);
        echo json_encode($data);
    }

    public function refreshEvents(){
        $groupId = $this->input->post('id');
        $data = $this->grouppagemodel->getEvents($groupId);
        echo json_encode($data);
    }

    public function refreshMembers(){
        $groupId = $this->input->post('id');
        $data = $this->grouppagemodel->getMembers($groupId);
        echo json_encode($data);
    }

    public function addMember(){
        $search = $this->input->post('search');
        $groupID = $this->input->post('groupID');
        $checkifExist = $this->grouppagemodel->checkifExist($search);
        if($checkifExist == NULL){
             $this->output->set_status_header('400');
            $details = $this->data['message'] = 'Student Doesn`t Exists';
        }else{
                $data = $this->grouppagemodel->searchMember($search,$groupID);
                if($data == NULL){
                    $details = $this->grouppagemodel->insertMember($search,$groupID);
                }else{
                    $this->output->set_status_header('400');
                    $details = $this->data['message'] = 'Student Already Exists';
                }
        }
        
        echo json_encode($details);
    }

    public function search(){
        $search = $this->input->post('search');
        $groupID = $this->input->post('groupID');
        $checkifExist = $this->grouppagemodel->checkifExist($search);
         if($checkifExist == NULL){
             $this->output->set_status_header('400');
            $details = $this->data['message'] = 'Student Doesn`t Exists';
        }else{
                $data = $this->grouppagemodel->searchMember($search,$groupID);
                if($data == NULL){
                    $details = $this->grouppagemodel->getUserDetails($search);
                    
                }else{
                    $this->output->set_status_header('400');
                    $details = $this->data['message'] = 'Student Already Exists';
                }
        }
        
        echo json_encode($details);
    }

    public function removeMember(){
      $id = $this->input->post('id');
      $groupid = $this->input->post('groupid');
      $this->grouppagemodel->removeMembers($id,$groupid);
    }

    public function setModerator(){
      $id = $this->input->post('id');
      $groupid = $this->input->post('groupid');
      $this->grouppagemodel->setModerator($id,$groupid);
    }

      public function approvePost(){
        $postid = $this->input->post('postid');
        $this->grouppagemodel->approvePost($postid);
    }


    public function createevent(){
        $accountid = $this->input->post('accountid');
        $id = $this->input->post('id');
        $eventName = $this->input->post('eventName');
        $eventDescr = $this->input->post('eventDescr');
        $eventDate = $this->input->post('eventDate');
        $eventimage = $this->input->post('eventpicture');
        $this->grouppagemodel->addEvent($id,$eventName,$eventDescr,$eventDate,$accountid,$eventimage);
        $data = $this->loginmodel->getDetailsProf($accountid);
        echo json_encode($data);
    }
    

    public function uploadImage(){
        $config['upload_path'] = 'assets/files';
        $config['allowed_types'] = 'mp4|3gp|jpg|png|jpeg';
        $config['max_size']     = '102400';
        $config['max_width']    =0;
        $config['max_height']   =0;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('upload_image_input')) {
                //File upload
                $uploadData = $this->upload->data(); 
                $filename = $uploadData['file_name'];
             // $this->loginmodel->upload_model($filename,$account_id);
            }   
    }

    public function uploadImageEvent(){
        set_time_limit(600);
        $config['upload_path'] = 'assets/files';
        $config['allowed_types'] = 'mp4|3gp|jpg|png|jpeg';
        $config['max_size']     =0;
        $config['max_width']    =0;
        $config['max_height']   =0;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('upload_image_input_event')) {
                //File upload
                $uploadData = $this->upload->data(); 
                $filename = $uploadData['file_name'];
             // $this->loginmodel->upload_model($filename,$account_id);
            }   

    }

    public function uploadFile(){
     
     $config['upload_path'] = 'assets/files';
            $config['allowed_types'] = 'mp4|3gp|jpg|png|jpeg|doc|docx|ppt|pptx|pdf|csv|txt|zip|rar';
            $config['max_size']     =0;
            $config['max_width']    =0;
            $config['max_height']   =0;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('attach_file_input')) {
                    //File upload
                    $uploadData = $this->upload->data(); 
                    $filename = $uploadData['file_name'];
                
            }     
    }

}

?>