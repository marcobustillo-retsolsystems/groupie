<html>
<head> 
    <link rel="stylesheet" href= "<?php echo base_url('assets/css/survey.css');?>">
    <style type="text/css">
        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
        }
        .previewmodal{
            width:80%;
            height: 80%;
        }
    </style> 
    <script>
    $(document).ready(function() {
        $('.modal').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
              opacity: .5, // Opacity of modal background
              in_duration: 300, // Transition in duration
              out_duration: 200, // Transition out duration
              starting_top: '4%', // Starting top style attribute
              ending_top: '10%', 
        });

        $(".dropdown-button").dropdown();

        var employinfo;
        var employsince;
        var Occupation;
        var Sector;
        var specificsector;
        
        $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15, // Creates a dropdown of 15 years to control year
          max:new Date(1996, 12,1),
          format: 'yyyy-mm-dd'
        });

        $('.datepicker1').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15, // Creates a dropdown of 15 years to control year
          format: 'yyyy-mm-dd',
          max: true,
        })


        $('select').material_select();

        $('.graduate_study').on('click',function(){
            var selector = $('.graduate_study:checked').attr('id');
            if(selector == "Yes1"){
                $('#graduate_study_infotable').removeClass();
            }else{
                $('#graduate_study_infotable').addClass("disabledbutton");
                $('html, body').animate({
                    scrollTop: $("#survey_main_category").offset().top
                }, 2000);
            }
        });

        $('.employment_info').on('click',function(){
            employinfo = $('.employment_info:checked').val();
            if(employinfo == 'Self Employed'){
                $('#self_employed_since').removeClass();
                $('#survey_category_careercompadd').removeClass();
                $('html, body').animate({
                    scrollTop: $("#survey_category_careercompadd").offset().top
                }, 2000);
            }
            else if(employinfo == "Unemployed"){
                $('#survey_category_unemployment').removeClass();
                $('#survey_category_careercompadd').addClass('disabledbutton');
                $('#survey_category_sector').addClass('disabledbutton');
                $('#survey_category_occupation').addClass('disabledbutton');
                $('#survey_category_position').addClass('disabledbutton');
                $('#survey_category_related').addClass('disabledbutton');
                $('#survey_category_careersalary').addClass('disabledbutton');
                $('html, body').animate({
                    scrollTop: $("#survey_category_unemployment").offset().top
                }, 2000);
            }
            else{
                $('#self_employed_since').addClass("disabledbutton");
                $('#survey_category_unemployment').addClass("disabledbutton");
                $('#self_employed_since').val('');
                $('#survey_category_careercompadd').removeClass();
                $('#survey_category_sector').removeClass();
                $('#survey_category_occupation').removeClass();
                $('#survey_category_position').removeClass();
                $('#survey_category_related').removeClass();
                $('#survey_category_careersalary').removeClass();
            }
        });

        $('.sector').on('click',function(){
            Sector = $('.sector:checked').attr('id');
            if(Sector == "Others"){
                $('#specify').removeClass();
            }else{
                $('#specify').addClass('disabledbutton')
                $('#specify').val('');
            }
        });

        $('#buttonSubmit').on('click',function(){
            var college = $('.college').attr('id');
            //personal information
            var lastname = $('#last_name').val();
            var firstname = $('#first_name').val();
            var middlename = $('#middle_name').val();
            var address = $('#address').val();

            var sex = $('.with-gap:checked').val();

            var birthday = $('.datepicker').val();

            var civilstat = $('.civil_status:checked').attr('id');

            var courseSelect = $('#course_completed').val();
            var yearcomp = $('#year_completed').val();
 
            var homeland = $('#home_landline_number').val();
            var officeland = $('#office_landline_number').val();
            var homecell = $('#home_cell_number').val();
            var officecell = $('#office_cell_number').val();
            var homeemail = $('#home_email').val();
            var officeemail =  $('#office_email').val();

            //graduatestudiesinformation

            var masterscourse = $('#master_course').val();
            var mastersduration = $('#duration_started').val() +'-'+ $('#duration_graduated').val();
            var mastersscholar = $('#master_scholarship').val();

            var doctorscourse = $('#doctor_course').val();
            var doctorduration = $('#docduration_started').val() +'-'+$('#docduration_graduated').val();
            var doctorscholar = $('#doctor_scholar').val();

            var postdocccourse = $('#postdoc_course').val();
            var postdocduration = $('#postdoc_duration').val() +'-'+$('#postdoc_graduated').val();
            var postdoctorscholar = $('#postdoc_scholar').val();
            //employmentinfo

            employinfo = $('.employment_info:checked').val();

            Occupation = $('.occupation:checked').val();
            employsince = $('#self_employed_since').val();
            Sector = $('.sector:checked').attr('id');
            specificsector = $('#specify').val();

            var jobrelated = $('.job_related1:checked').val();

            var pos = $('#position').val();
            var salary = $('#salary').val();
            var compname = $('#company_name').val();
            var compadd = $('#company_address').val(); 
            

            var position = $('#history_position').val();
            var historyemploy = $('#historystarted').val() +'-'+ $('#historyfinished').val();
            var historyrelation = $('.historyrelation:checked').val();
            var companyadd = $('#company_name_address').val();
            var reasonsforunmp = $('.reasonsforunemployment:checked').val();
            var historysector = $('.historySector:checked').val();
            var historysalary =$('#history_salary').val();
            var trainings = $('#trainings').val();
            var trainingdate = $('#Training_date').val();
            var sponsor = $('#sponsor').val();
            var suggestion = $('#suggestion').text();

            $('#lastnamemodal').text(lastname);
            $('#firstnamemodal').text(firstname);
            $('#middlenamemodal').text(middlename);
            $('#addressmodal').text(address);
            $('#sexmodal').text(sex);
            $('#birthdaymodal').text(birthday);
            $('#civilstatmodal').text(civilstat);
            $('#homelandmodal').text(homeland);
            $('#officelandmodal').text(officeland);
            $('#homecellmodal').text(homecell);
            $('#officecellmodal').text(officecell);
            $('#homeemailmodal').text(homeemail);
            $('#officecellmodal').text(officecell);
            $('#coursecompletedmodal').text(courseSelect);
            $('#currentemploinfomodal').text(employinfo);
            $('#occupationmodal').text(Occupation);
            $('#sectormodal').text(Sector);
            $('#academictrainingmodal').text(jobrelated);
            $('#positionmodal').text(pos);
            $('#salarymodal').text(salary);
            $('#companynamemodal').text(compname);
            $('#addresscompanymodal').text(compadd);
            $('#unemploymentmodal').text(reasonsforunmp);
            $('#positionhistorymodal').text(position);
            $('#lastbasicsalarymodal').text(historysalary);
            $('#employmentdurationhistory').text(historyemploy);
            $('#historycompanysector').text(companyadd);
            $('#historycompanysector').text(historysector);
            $('#lastbasicsalarymodal').text(historysalary);
            $('#trainingsmodal').text(trainings);
            $('#trainingdatemodal').text(trainingdate);
            $('#sponsormodal').text(sponsor);
            $('#suggestionmodal').text(suggestion);
            
            var checker = 0;

            if(address == ""){
                $('#addressmodal').text('Required*');
                $('#addressmodal').addClass('red-text');
                checker = 1;
            }else{
                checker = 0;
            }

            if(employinfo == "undefined" || employinfo == null){
                $('#currentemploinfomodal').text('Required*');
                $('#currentemploinfomodal').addClass('red-text');
                checker = 1;
            }else{
                checker = 0;
            }

            if(checker == 1){
                alert('Required Fields Must be filled up');
            }else{
                if(checker == 1){
                $('#confirm').addClass('disabledbutton');
            }else{
                    $.ajax({
                    type:'POST',
                    url: '<?php echo base_url('addAnswer')?>',
                    data:{college:college,firstname:firstname,middlename:middlename,lastname:lastname,address:address
                         ,sex:sex
                         ,birthday:birthday
                         ,civilstat:civilstat
                         ,courseSelect:courseSelect
                         ,yearcomp:yearcomp
                         ,homeland:homeland
                         ,officeland:officeland
                         ,homecell:homecell
                         ,officecell:officecell
                         ,homeemail:homeemail
                         ,officeemail:homeemail
                         ,masterscourse:masterscourse
                         ,mastersduration:mastersduration
                         ,mastersscholar:mastersscholar
                         ,doctorscourse:doctorscourse   
                         ,doctorduration:doctorduration
                         ,doctorscholar:doctorscholar
                         ,postdocccourse:postdocccourse
                         ,postdocduration:postdocduration
                         ,postdoctorscholar:postdoctorscholar
                         ,employinfo:employinfo
                         ,Occupation:Occupation
                         ,employsince:employsince
                         ,Sector:Sector
                         ,specificsector:specificsector
                         ,jobrelated:jobrelated
                         ,pos:pos
                         ,salary:salary
                         ,compname:compname
                         ,compadd:compadd
                         ,reasonsforunmp:reasonsforunmp
                         ,trainings:trainings
                         ,sponsor:sponsor
                         ,suggestion:suggestion
                         ,position:position
                         ,historyemploy:historyemploy
                         ,historyrelation:historyrelation
                         ,companyadd:companyadd
                         ,historysector:historysector
                         ,historysalary:historysalary
                         ,trainingdate:trainingdate},
                    success:function(){
                        var URL = '<?php echo base_url('thankyou1')?>';
                        $('.container').empty();
                        $('.container').load(URL);
                    }
                    });     
            }
        }
    });
    });

    


    </script>

</head>
<body>
	<div class="container">
	  	<form action="#!" method="POST">
            <div id="survey_main_category[personal_info]">
                <p id="survey_main_category_name"class="flow-text">I. PERSONAL INFORMATION</p>
                
                <div id="survey_category[personal_info][name]">
                    <p>1.) Name</p>  
                    <div class="row">
                        <div class="col l12">       
                        <?php 
                            if(is_array($details)||is_object($details)){
                              echo'
                                <div class="row">
                                    <div class="input-field col l4 s12">
                                        <input id ="'.$details->college_ID.'" class="college" type="hidden" value="'.$details->college_ID.'">
                                        <input disabled value="'.$details->accounts_lname.'" id="last_name" type="text" class="invalid">
                                        <label for="last_name">Last Name</label>
                                    </div>
                                    <div class="input-field col l4 s12">
                                        <input disabled value="'.$details->accounts_fname.'" id="first_name" type="text" class="invalid">
                                        <label for="first_name">First Name</label>
                                    </div>
                                    <div class="input-field col l4 s12">
                                      <input disabled value="'.$details->accounts_mname.'" id="middle_name" type="text" class="invalid">
                                      <label for="middle_name">Middle or Maiden Name</label>
                                    </div>
                                </div>';              
                               } 
                            ?>             
                        </div>
                    </div>
                </div> 

                <div id="survey_category[personal_info][address]">
                    <p>2.) Mailing Address:<sup class="red-text">*Required</sup></p>
                    <div class="input-field">
                        <input id="address" type="text" class="validate">
                        <label></label>
                    </div>
                </div>

                <div id="survey_categorysex">
                    <p>3.) Sex:</p> 
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col s3">
                                <input class="with-gap" name="sex" type="radio" id="Male" value="Male"/>
                                <label for="Male">Male</label>
                            </div>
                            <div class="input-field col s3">
                                <input class="with-gap" name="sex" type="radio" id="Female" value="Female"/>
                                <label for="Female">Female</label>
                            </div>      
                        </div>  
                    </div>
                </div>

                <div id="survey_category[personal_info][date_birth]">
                    <p>4.) Date of Birth:</p>
                    <div class="input-field">
                        <input type="date" class="datepicker" id="birthDate">
                    </div>      
                </div> 

                <div id="survey_category[personal_info][civil_status]">
                    <p id="survey_category_name[1][5]">5.) Civil Status:</p> 
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l3 s6">
                                <input name="civil_status" type="radio" id="Single" class="civil_status"/>
                                <label for="Single">Single</label>
                            </div>
                            <div class="input-field col l3 s6">
                                <input name="civil_status" type="radio" id="Married" class="civil_status"/>
                                <label for="Married">Married</label>
                            </div>
                            <div class="input-field col l3 s6">
                                <input name="civil_status" type="radio" id="Separated/Divorced" class="civil_status"/>
                                <label for="Separated/Divorced">Separated/Divorced</label>
                            </div>
                            <div class="input-field col l3 s6">
                                <input name="civil_status" type="radio" id="Widowed" class="civil_status"/>
                                <label for="Widowed">Widowed</label>
                            </div>            
                        </div>
                    </div>
                </div>

                <div id="survey_category">
                <?php
                echo '
                    <p>6.) Course Completed:</p>
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                            <input type="text" class="id disabledbutton" value="'.$details->course_abbv.'" id="course_completed">
                            </div>
                         
                            <div class="input-field col s6">
                                <input id="year_completed" type="number" class="validate disabledbutton" value="'.$details->account_graduated.'">
                                <label for="year_completed">Year Completed</label> <!-- 1970 to current year -->
                            </div>
                        </div>
                    </div>';
                ?>
                </div>

                <div id="survey_category[personal_info][current_contact]">
                    <p>7.) Current Contact</p>
                    <div>
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th><p>Numbers/Info</p></th>
                                    <th><p>Home</p></th>
                                    <th><p>Office</p></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Landline Phone Number</th>
                                    <td> 
                                        <div class="input-field">
                                            <input id="home_landline_number" type="number" class="">
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="input-field">
                                            <input id="office_landline_number" type="number" class="">
                                        </div>  
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cellular Phone Number</th>
                                    <td> 
                                        <div class="input-field">
                                            <input id="home_cell_number" type="number" class="">
                                        </div>                            
                                    </td> 
                                    <td>
                                        <div class="input-field"> 
                                            <input id="office_cell_number" type="number" class="">
                                        </div>  
                                    </td>
                                </tr>
                                <tr>
                                    <th>e-Mail Address</th>
                                    <td>
                                        <div class="input-field">
                                            <input id="home_email" type="email" class="validate">
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="input-field">
                                            <input id="office_email" type="email" class="validate">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div>      
            </div>
            
            <div id="survey_main_category[graduate_info]">
                <p class="flow-text">II. Graduate Studies Information</p>
                <div id="survey_category[graduate_info][pursued_graduateStudies]">
                    <p>Did you pursue your graduate studies?</p>   
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l3">
                                <input name="graduate_study" type="radio" id="Yes1" class="graduate_study"/>
                                <label for="Yes1">Yes</label>
                            </div> 
                            <div class="input-field col l3 s7">
                                <input name="graduate_study" type="radio" id="No1" class="graduate_study" checked/>
                                <label for="No1">No, Proceed to III</label>
                            </div>     
                        </div>
                    </div>
                    <div id="graduate_study_infotable" class="disabledbutton">
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th><p>Level</p></th>
                                    <th><p>Course</p></th>
                                    <th><p>Duration</p></th>
                                    <th><p>Name of Scholarship</p></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><p>Masters</p></th>
                                    <td>
                                        <div class="row">
                                          <div class="input-field col s12">
                                            <input id="master_course" type="text" class="">
                                          </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="input-field col l5 s6"> 

                                                    <input name="duration_started" id="duration_started" type="number" class="" min="1970" max="2017">                                  
                                                </div>
                                                <div class="input-field col l5 s6"> 
                                                    <input name="duration_graduated" id="duration_graduated" type="number" class="" min="1970" max="2017">
                                                </div>
                                            </div>
                                        </div>      
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="master_scholarship" type="text" class="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th><p>Doctorate</p></th>
                                    <td>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="doctor_course" type="text" class="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="input-field col l5 s6"> 
                                                    <input name="duration_started" id ="docduration_started" type="number" class="" min="1970" max="2017">                                       
                                                </div>
                                                <div class="input-field col l5 s6"> 
                                                    <input name="duration_graduated" id="docduration_graduated" type="number" class="" min="1970" max="2017">
                                                </div>
                                            </div>
                                        </div>      
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="doctor_scholar" type="text" class="validate">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p>Post-doctorate</p>
                                    </th>
                                    <td>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="postdoc_course" type="text" class="validate">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="input-field col l5 s6"> 
                                                    <input name="duration_started" id="postdoc_duration" type="number" class="validate" min="1970" max="2017">                                   
                                                </div>
                                                <div class="input-field col l5 s6"> 
                                                    <input name="duration_graduated" id="postdoc_graduated" type="number" class="validate" min="1970" max="2017">
                                                </div>
                                            </div>
                                        </div>      
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="postdoc_scholar" type="text" class="validate">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>

            <div id="survey_main_category">
      	        <p class="flow-text">III. Career/Current Employment Information</p>

                <div id="survey_category[career_info][current_employment_info]">
                    <p>1.) Current Employment Information<sup class="red-text">*Required</sup></p>
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input name="employment_info" type="radio" id="employed_locally" class="employment_info" value="Employed Locally"/>
                                <label for="employed_locally">Employed Locally</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <input name="employment_info" type="radio" id="employed_abroad" class="employment_info" value="Employed Abroad"/>
                                <label for="employed_abroad">Employed Abroad</label>
                            </div>
                            <div class="input-field col l3 s6">
                                  <input name="employment_info" type="radio" id="self_employed" class="employment_info" value="Self Employed"/>
                                  <label for="self_employed">Self-Employed since</label>
                            </div>
                            <div class="input-field col l3 s6">
                                  <input id="self_employed_since" type="number" class="disabledbutton" min="1970" max="2017"><!-- 1970 to current year -->
                            </div>
                            <div class="input-field col l6 s12">
                                <input name="employment_info" type="radio" id="Unemployed" class="employment_info" value="Unemployed"/>
                                <label for="Unemployed">Unemployed</label>
                            </div>            
                        </div>
                    </div>
                </div>

                <div id="survey_category_occupation">
                    <p>
                        2.) For those who are currently employed (locally & abroad)<br>
                        2.1 Occupation:
                    </p>  
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[1]" class="occupation" value="Programmer"/>
                                <label for="Occupation">Programmer</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[2]" class="occupation" value="Web Developer"/>
                                <label for="Occupation[2]">Web Developer</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[3]" class="occupation" value="System Analyst"/>
                                <label for="Occupation[3]">System Analyst</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[4]" class="occupation" value="Animator"/>
                                <label for="Occupation[4]">Animator</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[5]" class="occupation" value="Mobile Programmer"/>
                                <label for="Occupation[5]">Mobile Programmer</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[6]" class="occupation" value="Game Developer"/>
                                <label for="Occupation[6]">Game Developer</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[7]" class="occupation" value="Network Admin"/>
                                <label for="Occupation[7]">Network Admin</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[8]" class="occupation" value="Database Admin"/>
                                <label for="Occupation[8]">Database Admin</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[9]" class="occupation" value="Software Engineer"/>
                                <label for="Occupation[9]">Software Engineer</label>
                            </div>
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[10]" class="occupation" value="Researcher"/>
                                <label for="Occupation[10]">Researcher</label>
                            </div>      
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[11]" class="occupation" value="Educator"/>
                                <label for="Occupation[11]">Educator</label>
                            </div>  
                            <div class="input-field col l3 m3 s6">
                                <input name="occupation" type="radio" id="Occupation[12]" class="occupation" value="IT Support"/>
                                <label for="Occupation[12]">IT Support</label>
                            </div>    
                        </div>
                    </div>
                </div>

                <div id="survey_category_sector">
                    <p>2.2 Sector (Check One):</p>
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l2 s6">
                                <input name="sector" type="radio" id="Government" class="sector"/>
                                <label for="Government">Government</label>
                            </div>
                            <div class="input-field col l2 s6">  
                                <input name="sector" type="radio" id="Private" class="sector"/>
                                <label for="Private">Private</label>
                            </div>
                            <div class="input-field col l2 s6">
                                <input name="sector" type="radio" id="NGO/Foundation" class="sector"/>
                                <label for="NGO/Foundation">NGO/Foundation</label> 
                            </div>
                            <div class="input-field col l2 s6">
                                <input name="sector" type="radio" id="Academe" class="sector"/>
                                <label for="Academe">Academe</label>
                            </div>     
                            <div class="input-field col l2 s6">
                                <input name="sector" type="radio" id="Others" class="sector"/>
                                <label for="Others">Others</label>
                            </div>
                            <div class="input-field col l2 s6">
                                <input class="disabledbutton" id="specify" type="text">
                            </div>         
                        </div>
                    </div>
                </div>

                <div id="survey_category_related">
                    <p>2.4 is current job related to graduate academic training?</p>
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s3">
                                    <input name="job_related" type="radio" id="Yes2" value="Yes" class="job_related1"/>
                                    <label for="Yes2">Yes</label>
                                </div>
                                <div class="input-field col s3">
                                    <input name="job_related" type="radio" id="No2" value="No" class="job_related1"/>
                                    <label for="No2">No</label>
                                </div>      
                            </div>
                        </div>
                </div>

                <div id="survey_category_position">
                    <p>2.5 Current Position/Designation:</p>
                        <div class="input-field inline">
                            <input id="position" type="text" class="validate">                  
                        </div>
                </div>

                <div id="survey_category_careersalary">
                    <p>2.6 Basic Salary per month(in pesos):</p>
                    <div class="input-field inline">
                        <input id="salary" type="number" class="" min="0">  
                    </div>         
                </div>

                <div id="survey_category_careercompadd">
                    <p>
                        3.) For those who are currently employed/ self-employed
                    </p>                                         
                    <div class="row">
                        <div class="input-field inline col s12">
                            <p>3.1 Name of Company:</p>
                            <input id="company_name" type="text" class="validate">           
                        </div>               
                        <div class="input-field inline col s12">
                            <p>3.2 Address of Company:</p>
                            <input id="company_address" type="text" class="validate">           
                        </div>
                    </div>
                </div>

                <div id="survey_category_unemployment">
                    <p> 
                        4.) For those who are currently unemployed<br>
                        4.1 Reason(s) for unemployment
                    </p>    
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="graduate_studies" class="reasonsforunemployment" value="Pursuing Graduate Studies"/>
                                <label for="graduate_studies">Pursuing Graduate Studies</label> 
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="resigned" class="reasonsforunemployment" value="Recently resigned and still looking for a new job"/>
                                <label for="resigned">Recently resigned and still looking for a new job</label> 
                            </div>
                            <div class="input-field col l6 m6 s122">
                                <input name="reason" type="radio" id="planning_abroad" class="reasonsforunemployment" value="Planning/Preparing to work abroad"/>
                                <label for="planning_abroad">Planning/Preparing to work abroad</label>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="endo" class="reasonsforunemployment" value="End of contract and now looking for a new job"/>
                                <label for="endo">End of contract and now looking for a new job</label> 
                            </div> 
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="family_matters" class="reasonsforunemployment" value="Family/Personal matters"/>
                                <label for="family_matters">Family/Personal matters</label> 
                            </div> 
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="Retrenchment" class="reasonsforunemployment" value="Retrenchment"/>
                                <label for="Retrenchment">Retrenchment</label> 
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <input name="reason" type="radio" id="other_reasons" class="reasonsforunemployment" value="Others"/>
                                <label for="other_reasons">Others</label>
                            </div>
                        </div>
                    </div>   
                </div>

                <div id="survey_category[career_info][employment_history]">
                    <p> 5.) Employment History (Start with the most recent aside from current employment)</p>
                    <div id="job_history">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="history_position" type="text" class="validate">  
                                <label for="history_position">Position</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6"> 
                                <input id="historystarted" name="duration_started" type="number" class="historystarted" min="1970">  
                                <label>Duration Started</label>                  
                            </div>
                            <div class="input-field col s6"> 
                                <input id="historyfinished" type="number" class="historyfinished" min="1970" max="2017">
                                <label>Duration Finished</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col s12">
                                <p>Is job related to academic training?</p> 
                                <div class="col s12">
                                    <div class="row">
                                        <div class="input-field col l3 s6">
                                            <input name="job_related" type="radio" id="YesRelated" value="Yes" class="historyrelation" />
                                            <label for="YesRelated">Yes</label>
                                        </div>
                                        <div class="input-field col l3 s6">
                                            <input name="job_related" type="radio" id="NotRelated" value="No" class="historyrelation"/>
                                            <label for="NotRelated">No</label>
                                        </div>      
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="company_name_address" type="text" class="">
                                <label for="company_name_address">Company Name/Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field col l3 s6">
                                    <input name="comp_sec" type="radio" id="gov" class="historySector" value="Government"/><label for="gov">Government Sector</label>
                                </div>
                                <div class="input-field col l3 s6">
                                    <input name="comp_sec" type="radio" id="priv" class="historySector" value="Private"/><label for="priv">Private Sector</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="history_salary" type="number" class="">
                                <label for="history_salary">Last Basic Salary/Month(in Pesos)</label>
                            </div> 
                        </div>
                    </div>
                    <div class="row center">
                        <a class="waves-effect waves-light btn red"  id="add_job"><i class="material-icons right">add</i>Add Job History</a>
                    </div>
                </div>

                <div id="survey_category[career_info][professional_advancement]">
                    <p>6.) Professional Advancement</p>   
                    <table>
                        <th>
                            <tr>
                                <th><p>Title of Trainings/Seminar</p></th>
                                <th><p>Date</p></th>
                                <th><p>Sponsor</p></th>  
                            </tr>
                        </th>
                        <tr>
                            <td>
                                <div class="input-field">
                                    <input id="trainings" type="text" class="">
                                </div>
                            </td>  
                            <td>
                                <div class="input-field">
                                    <input id="Training_date" type="date" class="datepicker1">
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input id="sponsor" type="text" class="">
                                </div>
                            </td>
                        </tr>   
                    </table>
                </div>

                <div id="survey_category[career_info][suggestion]">
                    <p>7.) Suggestions to improve the present curriculum:</p>
                        <div class="row">
                            <div class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="suggestion" class="materialize-textarea"></textarea>
                                        <label for="suggestion"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>     
        </form>
        <div class="row">
            <a class="waves-effect waves-light btn red col s12"  id="buttonSubmit"><i class="material-icons right">send</i>Done</a>
        </div>  
    </div>

    <div id="preview" class="previewmodal modal modal-fixed-footer">
        <div class="modal-content"> 
            <h4 class="center-align">Graduate's Tracer Answer Preview</h4>
            <div class="row">
                <h5>I. Personal Information</h5>
                <div class="col s12">
                    <p><strong>First Name: </strong><span id="firstnamemodal"></span></p>
                    <p><strong>Middle Name: </strong><span id="middlenamemodal"></span></p>
                    <p><strong>Middle Name: </strong><span id="lastnamemodal"></span></p>
                </div>
                <div class="col s12">
                    <p><strong>Address: </strong><span id="addressmodal"></span></p>
                </div>
                <div class="col s12">
                    <p><strong>Sex: </strong><span id="sexmodal"></span></p>
                </div>
                <div class="col s12">
                    <p><strong>Date of Birth: </strong><span id="birthdaymodal"></span></p>  
                </div>
                <div class="col s12">
                    <p><strong>Civil Status: </strong><span id="civilstatmodal"></span></p>   
                </div>
                <div class="col s12">
                    <p><strong>Course Completed: </strong><span id="coursecompletedmodal"></span></p>   
                </div>
                <div class="col s12">
                    <p><strong>Current Contact: </strong></p>    
                    <div class="col s12">
                    <p><strong>Home Landline Number: </strong><span id="homelandmodal"></span></p>    
                    </div>
                    <div class="col s12">
                        <p><strong>Office Landline Number: </strong><span id="officelandmodal"></span></p>    
                    </div>
                    <div class="col s12">
                        <p><strong>Home Cellphone: </strong><span id="homecellmodal"></span></p>    
                    </div>
                    <div class="col s12">
                        <p><strong>Office Cellphone: </strong><span id="officecellmodal"></span></p> 
                    </div>
                    <div class="col s12">
                        <p><strong>Home E-mail: </strong><span id="homeemailmodal"></span></p> 
                    </div>
                     <div class="col s12">
                        <p><strong>Office E-mail: </strong><span id="officeemailmodal"></span></p> 
                    </div>
                </div>
                
            </div>

            <div class="row">
                <h5>II. Graduate Studies Information</h5>
                <div class="col s12">
                    <p><strong>Pursued Graduate Studies: </strong><span id="pursuedmodal"></span></p>
                    <p><strong>Masters Course: </strong><span id="masterscoursemodal"></span></p>
                    <div class="col s12">
                        <p><strong>Duration of Masters Studies: </strong><span id="mastersdurationmodal"></span></p>
                        <p><strong>Scholarship: </strong><span id="masterscholarmodal"></span></p>
                    </div>
                    <p><strong>Doctorate Course: </strong><span id="doctorcoursemodal"></span></p>
                    <div class="col s12">
                        <p><strong>Duration of Doctorate Studies: </strong><span id="doctordurationmodal"></span></p>
                        <p><strong>Scholarship: </strong><span></span id="doctorscholarshipmodal"></p>
                    </div>
                    <p><strong>Post-Doctorate Course: </strong><span id="postdoccoursemodal"></span></p>
                    <div class="col s12">
                        <p><strong>Duration of Post-Doctorate Studies: </strong><span id="postdocdurationmodal"></span></p>
                        <p><strong>Scholarship: </strong><span id="postdocscholarmodal"></span></p>
                    </div>
                </div>
            </div>

            <div class="row">
            <h5>III. Career/Current Employment Information</h5>
            <div class="col s12">
                <p><strong>Current Employment Information: </strong><span id="currentemploinfomodal"></span></p>
                <p><strong>Occupation: </strong><span id="occupationmodal"> </span></p>
                <p><strong>Sector: </strong><span id="sectormodal"></span></p>
                <p><strong>Is current job related to graduate academic training: </strong><span id="academictrainingmodal"></span></p>
                <p><strong>Current Position/Designation: </strong><span id="positionmodal"></span></p>
                <p><strong>Salary: </strong><span id="salarymodal"></span></p>
                <p><strong>Name of Company: </strong><span id="companynamemodal"></span></p>
                <p><strong>Address of Company: </strong><span id="addresscompanymodal"></span></p>
                <p><strong>Reason for Unemployment: </strong><span id="unemploymentmodal"></span></p>
                <p><strong>Employment History</strong></p>
                <div class="col s12">
                    <p><strong>Position: </strong><span id="positionhistorymodal"></span></p>
                    <p><strong>Company Name: </strong><span id="companyhistorymodal"></span></p>
                    <p><strong>Employment Duration History: </strong><span id="employmentdurationhistory"></span></p>  
                    <p><strong>Company Sector: </strong><span id="historycompanysector"></span></p>
                    <p><strong>Last Basic Salary: </strong><span id="lastbasicsalarymodal"></span></p>
                </div>
                <p><strong>Professional Advancement</strong></p>
                <div class="col s12">
                    <p><strong>Title of Trainings/Seminar: </strong><span id="trainingsmodal"></span></p>
                    <p><strong>Date: </strong><span id="trainingdatemodal"></span></p>
                    <p><strong>Sponsor: </strong><span id="sponsormodal"></span></p>
                </div>
                <p><strong>Suggestion: </strong><span id="suggestionmodal"></span></p>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect btn-flat"><i class="material-icons right"></i>Go Back</a>
            <a id="confirm" class="modal-action modal-close waves-effect btn-flat"><i class="material-icons right"></i>Submit</a>
        </div>
    </div> 

    <div id="tracerpage">
    </div>
</body>
</html>