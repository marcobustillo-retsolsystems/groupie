<?php
class administrator extends CI_Controller{
	function __construct() { 
		parent::__construct(); 
		$this->load->library('Pdf');
		$this->load->model('administratormodel');
	} 
		
    public function sendEmail(){

    	$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'tuptracer@gmail.com',
		    'smtp_pass' => 'tupadministrator',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1'
		);
		$email = $this->input->post('ajaxResult');
		$data = array(
			'email'=>$email,
			);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('azurecomplexity21@gmail.com', 'Your Name');
		//$this->email->to('inosantobenedict@yahoo.com');
		//$this->email->cc('another@another-example.com');
		$this->email->bcc($data['email']);

		$this->email->subject('Tracer Study for Technological University of the Philippines');
		$this->email->message('Good Morning/Afternoon TUP Alumni,<br/><br/>
					&nbsp;&nbsp;&nbsp;&nbsp;We would like to inform you that you need to login your account in the following link so that you can answer the tracer study for alumni.<br><br>

			&nbsp;&nbsp;&nbsp;&nbsp;We hope you comply as soon as possible. Thank you!<br><br>

			Sincerly Yours,<br>
			TUP Admin<br><br>

			<a href="http://localhost/Groupie">Groupie</a>');

		$this->email->send();
		echo $this->email->print_debugger();
    }

    public function initializeGraph(){
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

    	echo $this->load->view('header',NULL,TRUE);
    	echo $this->load->view('superadmin',$data,TRUE);

    }

    public function getGraph(){
        $college = $this->input->post('college');
        $course = $this->input->post('course');
        $gender = $this->input->post('gender');
        $okupasyon = $this->input->post('okupasyon');
        $year = $this->input->post('year');
        $salary = $this->input->post('salary');
        $year1 = $this->input->post('year1');
        $year2 = $this->input->post('year2');
        $employinfo = $this->input->post('employinfo');
        $sector = $this->input->post('sector');

        $data = $this->administratormodel->getGraphs($college,$course,$gender,$okupasyon,$year,$salary,$year1,$year2,$employinfo,$sector);
        echo json_encode($data);
    }

    public function getTable(){
        $college = $this->input->post('college');
        $course = $this->input->post('course');
        $gender = $this->input->post('gender');
        $okupasyon = $this->input->post('okupasyon');
        $year = $this->input->post('year');
        $salary = $this->input->post('salary');
        $year1 = $this->input->post('year1');
        $year2 = $this->input->post('year2');
        $employinfo = $this->input->post('employinfo');
        $sector = $this->input->post('sector');

        $data = $this->administratormodel->getTable($college,$course,$gender,$okupasyon,$year,$salary,$year1,$year2,$employinfo,$sector);
        echo json_encode($data);
    }

    public function getOccupation(){
        $college = $this->input->post('college');

        $data = $this->administratormodel->getOccupation($college);
        echo json_encode($data);
    }

    /*SELECT * FROM tbl_accounts INNER JOIN tbl_college ON tbl_college.college_ID = tbl_accounts.account_college INNER JOIN tbl_course ON tbl_course.course_ID = tbl_accounts.account_course WHERE (account_college LIKE "" ) OR (tbl_course.course_abbv LIKE "") AND account_graduated = "2017" AND accounts_type = "ALUMNI";*/

    public function initializeGraduates(){
    	$id = $this->input->post('firstid');
    	$id2 = $this->input->post('secondid');

    	if($id == '' || $id == null){
    		$data = $this->administratormodel->getGraduatesbyYear($id2);
    	}else if($id == 'ALL' || $id == 'all' || $id == 'aLl' || $id == 'All' || $id == 'AlL' || $id == 'alL'){
    		$id = 'ALUMNI';
    		$data = $this->administratormodel->getAllGraduates($id);
    	}else if(strlen($id) AND strlen($id2) !=0){
    		if(is_numeric($id2)){
    			$data = $this->administratormodel->getGraduteswithyear($id,$id2);
    		}else{
    			$data = $this->administratormodel->getGraduteswithcourse($id,$id2);
    		}
    	}else{
    		$data = $this->administratormodel->getGraduates($id);
    	}

    	if($data =='' || $data==null){
    		$this->output->set_status_header('400');
    		$data = $this->data['message'] = 'Something Wrong with your Search';
    	}
    	echo json_encode($data);
    }

    public function getCourses(){
        $college = $this->input->post('college');
        $data = $this->administratormodel->getCourses($college);
        echo json_encode($data);
    }
}
?>