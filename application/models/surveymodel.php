<?php
class surveymodel extends CI_Model{
	 function __construct(){  
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    function addGraphValue($college,$maleval,$femaleval,$unemployedval,$employedval,$salary,$govertmentval,$privateval,$relatedval,$unrelatedval){


    	$this->db->set('survey_total','survey_total+1',FALSE);
    	$this->db->set('survey_salary','survey_salary+'.$salary.'',FALSE);

    	if($maleval == 0){
    		$this->db->set('survey_female','survey_female+'.$femaleval.'',false);
    	}else{
    		$this->db->set('survey_male','survey_male+'.$maleval.'',false);
    	}

    	if($unemployedval == 0){
    		$this->db->set('survey_employed','survey_employed+'.$employedval.'',false);
    	}else{
    		$this->db->set('survey_unemployed','survey_unemployed+'.$unemployedval.'',false);
    	}

    	if($govertmentval == 0){
    		$this->db->set('survey_private','survey_private+'.$privateval.'',false);
    	}else{
    		$this->db->set('survey_goverment','survey_goverment+'.$govertmentval.'',false);
    	}

    	if($relatedval == 0){
    		$this->db->set('survey_unrelated','survey_unrelated+'.$unrelatedval.'',false);
    	}else{
    		$this->db->set('survey_related','survey_related+'.$relatedval.'',false);
    	}

    	$this->db->where('college_ID',$college);
    	$this->db->update('tbl_survey');
    }

    function storeAnswers($userid,
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
                        $trainingdate){
        $data = array(
            'account_ID'=>$userid,
            'college_ID'=>$collegeid,
            'firstname'=>$firstname,
            'middlename'=>$middlename,
            'lastname'=>$lastname,
            'address'=>$address,
            'sex'=>$sex,
            'birthday'=>$birthday,
            'civilstat'=>$civilstatus,
            'course'=>$course,
            'yearcompleted'=>$yearcompl,
            'homeland'=>$homeland,
            'officeland'=>$officeland,
            'homecell'=>$homecell,
            'officecell'=>$officecell,
            'homeemail'=>$homeemail,
            'officeemail'=>$officeemail,
            'masterscourse'=>$mastercourse,
            'mastersduration'=>$masterduration,
            'mastersscholar'=>$masterscholar,
            'doctorscourse'=>$doctorcourse,
            'doctorduration'=>$doctorduration,
            'doctorscholar'=>$doctorscholar,
            'postdocccourse'=>$postdoctcourse,
            'postdocduration'=>$postdocduration,
            'postdoctorscholar'=>$postdocscholar,
            'employinfo'=>$employinfo,
            'Occupation'=>$occupation,
            'employsince'=>$employsince,
            'Sector'=>$sector,
            'specificsector'=>$specificsector,
            'jobrelated'=>$jobrelated,
            'pos'=>$position,
            'salary'=>$salary,
            'compname'=>$compname,
            'compadd'=>$compaddress,
            'trainings'=>$trainings,
            'sponsor'=>$sponsor,
            'suggestion'=>$suggestion,
            'position'=>$historyposition
,            'historyemploy'=>$historyemploy,
            'historyrelation'=>$historyrelation,
            'companyadd'=>$companyhistoryadd,
            'reasonsforunmp'=>$reasonsforunmp,
            'historysector'=>$historysector,
            'historysalary'=>$historysalary,
            'trainingdate'=>$trainingdate,
            );
        $this->db->insert('tbl_temporary',$data);
    }

    function updateAlumni($userid){
        $this->db->set('accounts_status',1);
        $this->db->where('account_ID',$userid);
        $this->db->update('tbl_accounts');
    }
}