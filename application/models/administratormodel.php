<?php
class administratormodel extends CI_Model{
	function __construct(){  
        parent::__construct();
       //$this->output->enable_profiler(TRUE);
    }

    function getGraduates($id){
              $query = $this->db->query('SELECT accounts_fname
                                  , accounts_lname
                                  , accounts_mname
                                  , account_college
                                  , accounts_email
                                  , college_fullName
                                  , course_abbv
                                  , account_graduated
                                    FROM tbl_accounts a, tbl_college b, tbl_course c
                                    WHERE (a.account_college = "'.$id.'"
                                        OR  c.course_abbv = "'.$id.'")
                                    AND a.accounts_type = "ALUMNI"
                                    AND a.accounts_status = 0
                                    AND a.account_college = b.college_ID
                                    AND a.account_course = c.course_ID');
                if($query->num_rows() > 0){
                  return $query->result();
                }
                else{
                  return NULL;
                }
    }

    function getGraphs($college,$course,$gender,$okupasyon,$year,$salary,$year1,$year2,$employinfo,$sector){
      if($course == '' && $okupasyon == '' && $employinfo == '' && $sector == '' && $salary == ''){
        if($year =='' || $year2 == 'undefined' || $year2 == null){
          $query = $this->db->select('COUNT(1) as fnametotal,
                          SUM(CASE 
                                  WHEN course = "BSCS" 
                                  THEN 1 
                                  ELSE 0 
                                END) BSCS,
                            SUM(CASE 
                                    WHEN course = "BSIT" 
                                    THEN 1 
                                    ELSE 0 
                                END) BSIT,
                                SUM(CASE 
                                    WHEN course = "BSIS" 
                                    THEN 1 
                                    ELSE 0 
                                END) BSIS')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.yearcompleted',$year)
                          ->get();
            return $query->result();
        }else{
            $query = $this->db->select('COUNT(1) as fnametotal,
                                          SUM(CASE 
                                                  WHEN course = "BSCS" 
                                                  THEN 1 
                                                  ELSE 0 
                                                END) BSCS,
                                            SUM(CASE 
                                                    WHEN course = "BSIT" 
                                                    THEN 1 
                                                    ELSE 0 
                                                END) BSIT,
                                                SUM(CASE 
                                                  WHEN course = "BSIS" 
                                                  THEN 1 
                                                  ELSE 0 
                                              END) BSIS')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.yearcompleted >=',$year1)
                          ->where('tbl_temporary.yearcompleted <=',$year2)
                          ->get();
            return $query->result();
        }
      }else if($okupasyon == '' && $employinfo == '' && $sector == '' && $salary ==''){
        if($year =='' || $year2 == 'undefined' || $year2 == null){
          $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                    WHEN course = "'.$course.'" 
                                    THEN 1 
                                    ELSE 0 
                                END) coursetotal')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.yearcompleted',$year)
                          ->get();
            return $query->result();
        }else{
            $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                      WHEN course = "'.$course.'" 
                                      THEN 1 
                                      ELSE 0 
                                  END) coursetotal')
                            ->from('tbl_temporary')
                            ->where('tbl_temporary.college_ID',$college)
                            ->where('tbl_temporary.yearcompleted >=',$year1)
                            ->where('tbl_temporary.yearcompleted <=',$year2)
                            ->get();
              return $query->result();
        }
      }else{
        if($course == ''){
          if($sector == ''){
            if($employinfo !=''){
              if($okupasyon !=''){
                if($salary !=0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "BSCS" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) BSCS,
                                  SUM(CASE 
                                          WHEN course = "BSIT" 
                                          AND employinfo ="'.$employinfo.'"
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIT,
                                      SUM(CASE 
                                          WHEN course = "BSIS"
                                          AND employinfo ="'.$employinfo.'" 
                                           THEN 1 
                                          ELSE 0 
                                      END) BSIS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)                
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation ="'.$okupasyon.'" THEN 1 ELSE 0 END)as BSCS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    
                                    ->get();
                                    return $query->result();
                  }
                  }
              }else{
                if($salary != 0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "BSCS" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) BSCS,
                                  SUM(CASE 
                                          WHEN course = "BSIT" 
                                          AND employinfo ="'.$employinfo.'"
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIT,
                                      SUM(CASE 
                                          WHEN course = "BSIS"
                                          AND employinfo ="'.$employinfo.'" 
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)
                                                       
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('COUNT(1) fnametotal,SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)as BSCS,SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)as BSIT,SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)as BSIS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    
                                    ->get();
                                    return $query->result();
                  }
                }
              }
            }          
          }/*sector na may sectory*/else{
            if($employinfo !=''){
              if($okupasyon !=''){
                if($salary !=0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'"  THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "BSCS" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) BSCS,
                                  SUM(CASE 
                                          WHEN course = "BSIT" 
                                          AND employinfo ="'.$employinfo.'"
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIT,
                                      SUM(CASE 
                                          WHEN course = "BSIS"
                                          AND employinfo ="'.$employinfo.'" 
                                           THEN 1 
                                          ELSE 0 
                                      END) BSIS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)               
                                     ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" AND Occupation ="'.$okupasyon.'" THEN 1 ELSE 0 END)as BSCS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                     ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }
                  }
              }else{
                if($salary != 0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                 
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSCS,
                                    (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIT" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIT,
                                        (SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="BSIS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as BSIS')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "BSCS" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) BSCS,
                                  SUM(CASE 
                                          WHEN course = "BSIT" 
                                          AND employinfo ="'.$employinfo.'"
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIT,
                                      SUM(CASE 
                                          WHEN course = "BSIS"
                                          AND employinfo ="'.$employinfo.'" 
                                          THEN 1 
                                          ELSE 0 
                                      END) BSIS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)
                                     ->where('tbl_temporary.Sector',$sector)                 
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('COUNT(1) fnametotal,SUM(CASE WHEN course="BSCS" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)as BSCS')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }
                }
              }
            }
          }
        }else{
           if($sector == ''){
            if($employinfo !=''){
              if($okupasyon !=''){
                if($salary !=0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) as coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)                
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) as coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    
                                    ->get();
                                    return $query->result();
                  }
                  }
              }else{
                if($salary != 0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.
                        $course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('')                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.
                        $course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)
                                                       
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    
                                    ->get();
                                    return $query->result();
                  }
                }
              }
            }          
          }/*sector na may sectory*/else{
            if($employinfo !=''){
              if($okupasyon !=''){
                if($salary !=0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" AND Occupation = "'.$okupasyon.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal,
                                    ')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)               
                                     ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('SUM(CASE WHEN employinfo !="Unemployed" THEN 1 ELSE 0 END) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        AND Occupation ="'.$okupasyon.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal,')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                     ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }
                  }
              }else{
                if($salary != 0){
                  if($salary =="15000"){
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                 
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }else{
                    if($year =='' || $year2 == 'undefined' || $year2 == null){
                      $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted',$year)
                                       ->where('tbl_temporary.Sector',$sector)                  
                                      ->get();
                                      return $query->result();
                    }else{
                         $query = $this->db->select('(tbl_survey.survey_salary/tbl_survey.survey_total) as fnametotal,(SUM(CASE WHEN employinfo="'.$employinfo.'" THEN salary ELSE 0 END)/SUM(CASE WHEN course="'.$course.'" AND employinfo ="'.$employinfo.'" THEN 1 ELSE 0 END)) as coursetotal')
                                      ->from('tbl_temporary,tbl_survey')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_survey.college_ID = tbl_temporary.college_ID')
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                       ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                    }
                  }
                }else{
                  if($year =='' || $year2 == 'undefined' || $year2 == null){
                    $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted',$year)
                                     ->where('tbl_temporary.Sector',$sector)                 
                                    ->get();
                                    return $query->result();
                  }else{
                       $query = $this->db->select('COUNT(1) as fnametotal,SUM(CASE 
                                        WHEN course = "'.$course.'" 
                                        AND employinfo ="'.$employinfo.'"
                                        THEN 1 
                                        ELSE 0 
                                      END) coursetotal')
                                    ->from('tbl_temporary')
                                    ->where('tbl_temporary.college_ID',$college)
                                    ->where('tbl_temporary.yearcompleted >=',$year1)
                                    ->where('tbl_temporary.yearcompleted <=',$year2)
                                    ->where('tbl_temporary.Sector',$sector)
                                    ->get();
                                    return $query->result();
                  }
                }
              }
            }
          }

        }
      }
    
    }

    function getTable($college,$course,$gender,$okupasyon,$year,$salary,$year1,$year2,$employinfo,$sector){
      if($okupasyon == '' && $salary == '' && $employinfo == '' && $sector == '' && $course == ''){
        if($year2 =='' || $year2 == null || $year2 =='undefined'){
          $query = $this->db->select('firstname,middlename,lastname,course,yearcompleted')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.yearcompleted',$year)
                          ->get();
                          return $query->result();
        }else{
          $query = $this->db->select('firstname,middlename,lastname,course,yearcompleted')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.yearcompleted >=',$year1)
                          ->where('tbl_temporary.yearcompleted <=',$year2)
                          ->get();
                          return $query->result();
        }
      }else if($okupasyon == '' && $salary == '' && $employinfo == '' && $sector == ''){
        if($year2 =='' || $year2 == null || $year2 =='undefined'){
          $query = $this->db->select('firstname,middlename,lastname,course,yearcompleted')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.course',$course)
                          ->where('tbl_temporary.yearcompleted',$year)
                          ->get();
                          return $query->result();
        }else{
          $query = $this->db->select('firstname,middlename,lastname,course,yearcompleted')
                          ->from('tbl_temporary')
                          ->where('tbl_temporary.college_ID',$college)
                          ->where('tbl_temporary.course',$course)
                          ->where('tbl_temporary.yearcompleted >=',$year1)
                          ->where('tbl_temporary.yearcompleted <=',$year2)
                          ->get();
                          return $query->result();
        }
      }else{
        if($employinfo == 'Unemployed'){      
          if($course == ''){
            if($year2 == '' || $year2 == null || $year2 == 'undefined'){
              $query = $this->db->select('firstname,middlename,lastname,reasonsforunmp,course,yearcompleted,employinfo')
                            ->from('tbl_temporary')
                            ->where('tbl_temporary.college_ID',$college)
                            ->where('tbl_temporary.yearcompleted',$year)
                            ->where('tbl_temporary.employinfo',$employinfo)
                            ->get();
                            return $query->result();
            }else{
              $query = $this->db->select('firstname,middlename,lastname,reasonsforunmp,course,yearcompleted,employinfo')
                            ->from('tbl_temporary')
                            ->where('tbl_temporary.college_ID',$college)
                            ->where('tbl_temporary.yearcompleted >=',$year1)
                            ->where('tbl_temporary.yearcompleted <=',$year2)
                            ->where('tbl_temporary.employinfo',$employinfo)
                            ->get();
                            return $query->result();
            }
          }else{
            if($year2 == '' || $year2 == null || $year2 == 'undefined'){
              $query = $this->db->select('firstname,middlename,lastname,reasonsforunmp,course,yearcompleted,employinfo')
                            ->from('tbl_temporary')
                            ->where('tbl_temporary.college_ID',$college)
                            ->where('tbl_temporary.yearcompleted',$year)
                            ->where('tbl_temporary.employinfo',$employinfo)
                            ->where('tbl_temporary.course',$course)
                            ->get();
                            return $query->result();
            }else{
              $query = $this->db->select('firstname,middlename,lastname,reasonsforunmp,course,yearcompleted,employinfo')
                            ->from('tbl_temporary')
                            ->where('tbl_temporary.college_ID',$college)
                            ->where('tbl_temporary.employinfo',$employinfo)
                            ->where('tbl_temporary.yearcompleted >=',$year1)
                            ->where('tbl_temporary.yearcompleted <=',$year2)
                            ->where('tbl_temporary.course',$course)
                            ->get();
                            return $query->result();
            }
          }
        }else{
          if($sector == ''){
            if($employinfo =='Employed Locally'){
              if($course ==''){
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }else{
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.course',$course)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.course',$course)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }
            }else if($employinfo == 'Employed Abroad'){
              if($course ==''){
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }else{
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.course',$course)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.course',$course)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }
            }else{
              if($course == ''){
                if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.yearcompleted',$year)
                              ->get();
                              return $query->result();
                }else{
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.yearcompleted >=',$year1)
                              ->where('tbl_temporary.yearcompleted <=',$year2)
                              ->get();
                              return $query->result();
                }
              }else{
                if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.course',$course)
                              ->where('tbl_temporary.yearcompleted',$year)
                              ->get();
                              return $query->result();
                }else{
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.course',$course)
                              ->where('tbl_temporary.yearcompleted >=',$year1)
                              ->where('tbl_temporary.yearcompleted <=',$year2)
                              ->get();
                              return $query->result();
                }
              }
            }
          }else{
            if($employinfo =='Employed Locally'){
              if($course ==''){
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }else{
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.course',$course)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.course',$course)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }
            }else if($employinfo == 'Employed Abroad'){
              if($course ==''){
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }else{
                if($okupasyon ==''){
                  if($salary == ''){
                    if($year2 == '' || $year == null || $year == 'undefined'){
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted',$year)
                                        ->where('tbl_temporary.course',$course)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }else{
                      $query = $this->db->select('firstname,middlename,lastname,course,employinfo,yearcompleted,Sector')
                                        ->from('tbl_temporary')
                                        ->where('tbl_temporary.college_ID',$college)
                                        ->where('tbl_temporary.employinfo',$employinfo)
                                        ->where('tbl_temporary.yearcompleted >=',$year1)
                                        ->where('tbl_temporary.yearcompleted <=',$year2)
                                        ->where('tbl_temporary.course',$course)
                                        ->where('tbl_temporary.Sector',$sector)
                                        ->get();
                                        return $query->result();
                    }
                  }else{
                    if($salary >= '15000'){
                      if($year2 == '' || $year2 == 'undefined' || $year2 == null){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary >',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted',$year)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,salary,yearcompleted,employinfo,Sector')
                                ->from('tbl_temporary')
                                ->where('tbl_temporary.college_ID',$college)
                                ->where('tbl_temporary.salary <',$salary)
                                ->where('tbl_temporary.employinfo',$employinfo)
                                ->where('tbl_temporary.yearcompleted >=',$year1)
                                ->where('tbl_temporary.yearcompleted <=',$year2)
                                ->where('tbl_temporary.course',$course)
                                ->where('tbl_temporary.Sector',$sector)
                                ->get();
                                return $query->result();
                      }
                    }
                  }
                }else{
                  if($salary ==''){
                      if($year2 =="undefined" || $year2 == "" || $year2 ==null){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                  }else{
                    if($salary == "15000"){
                      if($year2 == "" || $year2 == null || $year2 =='undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary >',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }else{
                      if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted',$year)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }else{
                        $query = $this->db->select('firstname,middlename,lastname,course,employinfo,Occupation,yearcompleted,salary,Sector')
                                      ->from('tbl_temporary')
                                      ->where('tbl_temporary.college_ID',$college)
                                      ->where('tbl_temporary.salary <',$salary)
                                      ->where('tbl_temporary.employinfo',$employinfo)
                                      ->where('tbl_temporary.yearcompleted >=',$year1)
                                      ->where('tbl_temporary.yearcompleted <=',$year2)
                                      ->where('tbl_temporary.Occupation',$okupasyon)
                                      ->where('tbl_temporary.course',$course)
                                      ->where('tbl_temporary.Sector',$sector)
                                      ->get();
                                      return $query->result();
                      }
                    }
                  }
                }
              }
            }else{
              if($course == ''){
                if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted,Sector')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.yearcompleted',$year)
                              ->where('tbl_temporary.Sector',$sector)
                              ->get();
                              return $query->result();
                }else{
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted,Sector')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.yearcompleted >=',$year1)
                              ->where('tbl_temporary.yearcompleted <=',$year2)
                              ->where('tbl_temporary.Sector',$sector)
                              ->get();
                              return $query->result();
                }
              }else{
                if($year2 == '' || $year2 == null || $year2 == 'undefined'){
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted,Sector')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.course',$course)
                              ->where('tbl_temporary.yearcompleted',$year)
                              ->where('tbl_temporary.Sector',$sector)
                              ->get();
                              return $query->result();
                }else{
                  $query = $this->db->select('firstname,middlename,lastname,employinfo,compname,compadd,course,yearcompleted,Sector')
                              ->from('tbl_temporary')
                              ->where('tbl_temporary.college_ID',$college)
                              ->where('tbl_temporary.employinfo',$employinfo)
                              ->where('tbl_temporary.course',$course)
                              ->where('tbl_temporary.yearcompleted >=',$year1)
                              ->where('tbl_temporary.yearcompleted <=',$year2)
                              ->where('tbl_temporary.Sector',$sector)
                              ->get();
                              return $query->result();
                }
              }
            }
          }
        }
      } 
    }

    function getOccupation($college){
      $query = $this->db->select('occupations')
                        ->from('tbl_occupations')
                        ->where('college_ID',$college)
                        ->get();
      return $query->result();
    }

    function getCourses($college){
      $query = $this->db->select('course_abbv')
                        ->from('tbl_course,tbl_college')
                        ->where('tbl_course.college_ID',$college)
                        ->where('tbl_course.college_ID = tbl_college.college_ID')
                        ->get();
      return $query->result();
    }

    function getGraduatesbyYear($id2){
      $query = $this->db->select('accounts_fname
                    , accounts_lname,
                    , accounts_mname
                    , account_college
                    , accounts_email 
                    , college_fullName
                    , course_abbv
                    , account_graduated')
                ->from('tbl_accounts,tbl_college,tbl_course')
                ->where('account_graduated',$id2)
                ->where('accounts_type','ALUMNI')
                ->where('accounts_status','0')
                ->where('tbl_accounts.account_college = tbl_college.college_ID')
                ->where('tbl_accounts.account_course = tbl_course.course_ID')
                ->get();
      return $query->result();
    }

    function getAllGraduates($id){
      $query = $this->db->select('accounts_fname
                    , accounts_lname
                    , accounts_mname
                    , account_college
                    , accounts_email
                    , college_fullName
                    , course_abbv
                    , account_graduated')
                ->from('tbl_accounts,tbl_college,tbl_course')
                ->where('accounts_type',$id)
                ->where('accounts_status','0')
                ->where('tbl_accounts.account_college = tbl_college.college_ID')
                ->where('tbl_accounts.account_course = tbl_course.course_ID')
                ->get();
      return $query->result();
    }

    function getGraduteswithcourse($id,$id2){
        $query = $this->db->query('SELECT accounts_fname
                                  , accounts_lname
                                  , accounts_mname
                                  , account_college
                                  , accounts_email
                                  , college_fullName
                                  , course_abbv
                                  , account_graduated
                                    FROM tbl_accounts a, tbl_college b, tbl_course c
                                    WHERE (a.account_college = "'.$id.'"
                                    AND  c.course_abbv = "'.$id2.'")
                                    AND a.accounts_type = "ALUMNI"
                                    AND a.accounts_status = 0
                                    AND a.account_college = b.college_ID
                                    AND a.account_course = c.course_ID');
                if($query->num_rows() > 0){
                  return $query->result();
                }
                else{
                  return NULL;
                }
    }

    function getGraduteswithyear($id,$id2){
        $query = $this->db->query('SELECT accounts_fname
                                  , accounts_lname
                                  , accounts_mname
                                  , account_college
                                  , accounts_email
                                  , college_fullName
                                  , course_abbv
                                  , account_graduated
                                    FROM tbl_accounts a, tbl_college b, tbl_course c
                                    WHERE (a.account_college = "'.$id.'" OR c.course_abbv ="'.$id.'")
                                    AND  a.account_graduated = "'.$id2.'"
                                    AND a.accounts_type = "ALUMNI"
                                    AND a.accounts_status = 0
                                    AND a.account_college = b.college_ID
                                    AND a.account_course = c.course_ID');
                if($query->num_rows() > 0){
                  return $query->result();
                }
                else{
                  return NULL;
                }
    }

    function initializeGraphvalues($college){
        $query = $this->db->select('survey_total,(survey_salary/survey_total) as salarytotal,survey_employed,survey_unemployed,survey_goverment,survey_private,(survey_related/survey_total*100) as survey_acad')
                          ->from('tbl_survey')
                          ->where('college_ID',$college)
                          ->get();
        return $query->result();
    }
}
?>