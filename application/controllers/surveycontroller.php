<?php
class surveycontroller extends CI_Controller{
	function __construct(){  
        parent::__construct();
        $this->load->model('loginmodel');
        $this->load->model('newsfeedmodel');
        $this->load->model('grouppagemodel');
        $this->load->model('discussionmodel');
        $this->load->model('surveymodel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function loadTracer(){
        $userid = $this->session->tempdata('accountID');
        $data['details'] = $this->loginmodel->getDetails($userid);
        echo $this->load->view('header', NULL, TRUE);
        echo $this->load->view('Surveypage',$data,TRUE);
    } 

    public function addAnswer(){
        $userid = $this->session->tempdata('accountID');
        $collegeid = $this->input->post('college');
        $lastname = $this->input->post('lastname');
        $firstname = $this->input->post('firstname');
        $middlename = $this->input->post('middlename');
        $address = $this->input->post('address');
        $sex = $this->input->post('sex');
        $birthday = $this->input->post('birthday');
        $civilstatus = $this->input->post('civilstat');
        $course = $this->input->post('courseSelect');
        $yearcompl = $this->input->post('yearcomp');
        $homeland = $this->input->post('homeland');
        $officeland = $this->input->post('officeland');
        $homecell = $this->input->post('homecell');
        $officecell = $this->input->post('officecell');
        $homeemail = $this->input->post('homeemail');
        $officeemail = $this->input->post('officeemail');
        $mastercourse = $this->input->post('mastercourse');
        $masterduration = $this->input->post('masterduration');
        $masterscholar = $this->input->post('masterscholar');
        $doctorcourse = $this->input->post('doctorcourse');
        $doctorduration = $this->input->post('doctorduration');
        $doctorscholar = $this->input->post('doctorscholar');
        $postdoctcourse = $this->input->post('postdoctcourse');
        $postdocduration = $this->input->post('postdocduration');
        $postdocscholar = $this->input->post('postdocscholar');
        $employinfo = $this->input->post('employinfo');
        $occupation = $this->input->post('Occupation');
        $employsince =$this->input->post('employsince');
        $sector = $this->input->post('sector');
        $specificsector = $this->input->post('specificsector');
        $jobrelated = $this->input->post('jobrelated');
        $position = $this->input->post('pos');
        $salary = $this->input->post('salary');
        $compname = $this->input->post('compname');
        $compaddress =$this->input->post('compadd');
        $reasonsforunmp = $this->input->post('reasonsforunmp');
        $trainings = $this->input->post('trainings');
        $sponsor = $this->input->post('sponsor');
        $suggestion = $this->input->post('suggestion');
        $historyposition = $this->input->post('position');
        $historyemploy= $this->input->post('historyemploy');
        $historyrelation = $this->input->post('historyrelation');
        $companyhistoryadd= $this->input->post('companyadd');
        $historysector = $this->input->post('historysector');
        $historysalary = $this->input->post('historysalary');
        $trainingdate = $this->input->post('trainingdate');
        $maleval = 0;
        $femaleval = 0;
        $unemployedval = 0;
        $employedval = 0;
        $govermentval = 0;
        $privateval = 0;
        $relatedval = 0;
        $unrelatedval = 0;

        if($salary == ""){
            $salary = 0;
        }

        if($employinfo == "Unemployed"){
            $unemployedval = 1;
        }else{
            $employedval = 1;
        }

        if($sex == "Male"){
            $maleval = 1;
        }else{
            $femaleval = 1;
        }

        if($sector == "Goverment"){
            $govermentval = 1;
        }else{
            $privateval = 1;
        }

        if($jobrelated == "Yes"){
            $relatedval = 1;
        }else{
            $unrelatedval = 1;
        }

        //insertdatabase
        $this->surveymodel->addGraphValue($collegeid,$maleval,$femaleval,$unemployedval,$employedval
            ,$salary,$govermentval,$privateval,$relatedval,$unrelatedval);

        //$this->surveymodel->updateAlumni($userid);

        $this->surveymodel->storeAnswers($userid,
                                $collegeid,
                                $firstname,
                                $middlename,
                                $lastname,
                                $address,
                                $sex,
                                $birthday,
                                $civilstatus,
                                $course,
                                $yearcompl,
                                $homeland,
                                $officeland,
                                $homecell,
                                $officecell,
                                $homeemail,
                                $officeemail,
                                $mastercourse,
                                $masterduration,
                                $masterscholar,
                                $doctorcourse,
                                $doctorduration,
                                $doctorscholar,
                                $postdoctcourse,
                                $postdocduration,
                                $postdocscholar,
                                $employinfo,
                                $occupation,
                                $employsince,
                                $sector,
                                $specificsector,
                                $jobrelated,
                                $position,
                                $salary,
                                $compname,
                                $compaddress,
                                $reasonsforunmp,
                                $trainings,
                                $sponsor,
                                $suggestion,
                                $historyposition,
                                $historyemploy,
                                $historyrelation,
                                $companyhistoryadd,
                                $historysector,
                                $historysalary,
                                $trainingdate);
    }

    public function loadThankyou(){
        echo $this->load->view('header', NULL, TRUE);
        echo $this->load->view('thankyoupage',NULL,TRUE);
    }
    public function loadThankyou1(){
        echo $this->load->view('header', NULL, TRUE);
        echo $this->load->view('thankyoupage1',NULL,TRUE);
    }
	
}
?>