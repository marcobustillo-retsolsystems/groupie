<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.disabledbutton {
            pointer-events: none;
            opacity: 0.4;
        }
	</style>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"> 


	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

	<script src="<?php echo base_url('assets/js/Chart.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/blockUI.js')?>"></script> 
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		//var ctx = document.getElementById("myChart").getContext("2d");
		//$('#tableofgraduates').DataTable();
		//cos
		var college;	
		var course;
		var gender;
		var okupasyon;
		var year;
		var salary;
		var sector;

		var costotal = $('#cossurveytotal').val();
		var cossalary = $('#cossalary').val();
		var cosemp = $('#cosemp').val();
		var cosunem = $('#cosunem').val();	
		var cosgoverment = $('#cosgoverment').val();
		var cosprivate = $('#cosprivate').val();
		var cosrelated = $('#cosrelated').val();
		//cla
		var clatotal = $('#clasurveytotal').val();
		var clasalary = $('#clasalary').val();
		var claemp = $('#claemp').val();
		var claunem = $('#claunem').val();
		var clagoverment = $('#clagoverment').val();
		var claprivate = $('#claprivate').val();
		var clarelated = $('#clarelated').val();
		//coe
		var coetotal = $('#coesurveytotal').val();
		var coesalary = $('#coesalary').val();
		var coeemp = $('#coeemp').val();
		var coeunem = $('#coeunem').val();
		var coegoverment=$('#coegoverment').val();
		var coeprivate = $('#coeprivate').val();
		var coerelated = $('#coerelated').val();
		//cit
		var cittotal = $('#citsurveytotal').val();
		var citsalary = $('#citsalary').val();
		var citemp = $('#citemp').val();
		var citunem = $('#citunem').val();
		var citgoverment = $('#citgoverment').val();
		var citprivate = $('#citprivate').val();
		var citrelted = $('#citrelated').val();
		//cie
		var cietotal = $('#ciesurveytotal').val();
		var ciesalary = $('#ciesalary').val();
		var cieemp = $('#cieemp').val();
		var cieunem = $('#cieunem').val();
		var ciegoverment = $('#ciegoverment').val();
		var cieprivate = $('#cieprivate').val();
		var cierelated = $('#cierelated').val();
		//cafa
		var cafatotal = $('#cafasurveytotal').val();
		var cafasalary = $('#cafasalary').val();
		var cafaemp = $('#cafaemp').val();
		var cafaunem = $('#cafaunem').val();
		var cafagoverment = $('#cafagoverment').val();
		var cafaprivate = $('#cafaprivate').val();
		var cafarelated = $('#cafarelated').val();		 

		$('.dropdown-button').dropdown({
	      inDuration: 300,
	      outDuration: 225,
	      constrainWidth: false, // Does not change width of dropdown to that of the activator
	      hover: true, // Activate on hover
	      gutter: 0, // Spacing from edge
	      belowOrigin: false, // Displays dropdown below the button
	      alignment: 'left', // Displays dropdown with edge aligned to the left of button
	      stopPropagation: false // Stops event propagation
		});

		var ajaxResult=[];
		var lname=[];

		$('#searchGraduates').keypress(function(e) {
		    if(e.which == 13) {
		        var id = $('#searchGraduates').val();
		        var splitter = id.split(" ");
		        var firstid = splitter[0];
		        var secondid = splitter[1];
		       	var length = splitter.length;
		       	/*if(length > 3){
		       		alert('More than 3 Search String');
		       	}*/

		       if($.isNumeric(firstid) == true){
		       	if(secondid == ''){
		       		secondid = firstid;
		       		firstid = "";
		       	}else{
		       		var third = firstid;
		       		firstid = secondid;
		       		secondid = third;
		       	}
		       }
				ajaxResult.length = 0;
				$('#tableofgraduates tbody').empty();
				$.ajax({
					type:"POST",
					url:'<?php echo base_url('getGraduates');?>',
					data:{firstid:firstid,secondid:secondid},
					dataType:'json',
					success:function(data){
						
						$(data).each(function(){
							ajaxResult.push(this.accounts_email);
							lname.push(this.accounts_lname);
							$('#tableofgraduates tbody').append($('<tr>">'
			                    +  '<td>'+this.accounts_fname+"\t"+this.accounts_lname+'</td>'
			                    +  '<td>'+this.course_abbv+'</td>'
			                    +  '<td>'+this.account_graduated+'</td>'                           
			                  	+'</tr>'
			                    ));
						});
					},error:function(errorw){
						var json = $.parseJSON(errorw.responseText);
						Materialize.toast(json,4000);
					}
				});
		    }
		});

		$('#sendEmail').on('click',function(){

			if(ajaxResult.length == 0){
				alert('No Email');
			}else{
				$.ajax({
					type:"POST",
					url: '<?php echo base_url('sendEmail')?>',
					cache: false,
					data:{ajaxResult:ajaxResult,lname:lname},
					beforeSend: function(){
					var imageref = '<?php base_url(); ?>'+ 'assets/images/loading1.gif';
					  $.blockUI({
					  	message: '<img src="'+imageref+'" />',
					  });
					},
					complete:function(){
						$.unblockUI();
					}
				});
			}
		});

		$('#request').on('click',function(){
			college = $('#graph_college option:selected').text();
			course = $('#graphprogram option:selected').text();
			gender = $('#graph_gender option:selected').text();
			okupasyon = $('#graph_occupation option:selected').text();
			year = $('#graph_year_graduated').val();
			salary = $('#graph_salary option:selected').val();
			employinfo =$('#employment_info option:selected').val();
			sector = $('#sectorial option:selected').text();
			yearsp = year.split("-");
			year1 = yearsp[0];
			year2 = yearsp[1];
			

			if(course =='' && gender == '' && okupasyon =='' && year =='' && salary == ''){
			$('#myChart').remove();
			$('#myChartdiv').append($('<canvas id="myChart" width="100" height="50"></canvas>'));
			}
			$('#myChart').remove();
			$('#myChartdiv').append($('<canvas id="myChart" width="100" height="50"></canvas>'));

			$.ajax({
				type:'POST',
				url:'<?php echo base_url('administrator/getTable')?>',
				data:{college:college,course:course,gender:gender,okupasyon:okupasyon,year:year,salary:salary,year1:year1,year2:year2,employinfo:employinfo,sector,sector},
				dataType:'json',
				success:function(data){

					if(okupasyon == '' && employinfo == '' && sector == '' && salary == '' && course ==''){
						$('div#tableElement').html('<table id="tabular" class="display">'
								+	'<thead>'
								+		'<tr>'
								+			'<th>Name</th>'
								+			'<th>Course</th>'
								+			'<th>Year Graduated</th>'
								+		'</tr>'
								+	'</thead>'
								+	'<tbody>'
								+	'</tbody>'
								+'</table>  ');
								$(data).each(function(){
									$('#tabular tbody').append($('<tr>'
										+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
										+ '<td>'+this.course+'</td>'
										+ '<td>'+this.yearcompleted+'</td>'
										));
								});
					}else if(okupasyon == '' && employinfo =='' && sector == '' && salary ==''){
						$('div#tableElement').html('<table id="tabular" class="display">'
								+	'<thead>'
								+		'<tr>'
								+			'<th>Name</th>'
								+			'<th>Course</th>'
								+			'<th>Year Graduated</th>'
								+		'</tr>'
								+	'</thead>'
								+	'<tbody>'
								+	'</tbody>'
								+'</table>  ');
								$(data).each(function(){
									$('#tabular tbody').append($('<tr>'
										+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
										+ '<td>'+this.course+'</td>'
										+ '<td>'+this.yearcompleted+'</td>'
										));
								});
					}else{
						if(employinfo =="Unemployed"){
							if(course == ''){
								$('div#tableElement').html('<table id="tabular" class="display">'
								+	'<thead>'
								+		'<tr>'
								+			'<th>Name</th>'
								+			'<th>Employment Information</th>'
								+			'<th>Course</th>'
								+			'<th>Year Graduated</th>'
								+			'<th>Reason of Unemployment</th>'
								+		'</tr>'
								+	'</thead>'
								+	'<tbody>'
								+	'</tbody>'
								+'</table>  ');
								$(data).each(function(){
									$('#tabular tbody').append($('<tr>'
										+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
										+ '<td>'+this.employinfo+'</td>'
										+ '<td>'+this.course+'</td>'
										+ '<td>'+this.yearcompleted+'</td>'
										+ '<td>'+this.reasonsforunmp+'</td>'
										));
								});
							}else{
								$('div#tableElement').html('<table id="tabular" class="display">'
								+	'<thead>'
								+		'<tr>'
								+			'<th>Name</th>'
								+			'<th>Employment Information</th>'
								+			'<th>Course</th>'
								+			'<th>Year Graduated</th>'
								+			'<th>Reason of Unemployment</th>'
								+		'</tr>'
								+	'</thead>'
								+	'<tbody>'
								+	'</tbody>'
								+'</table>  ');
								$(data).each(function(){
									$('#tabular tbody').append($('<tr>'
										+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
										+ '<td>'+this.employinfo+'</td>'
										+ '<td>'+this.course+'</td>'
										+ '<td>'+this.yearcompleted+'</td>'
										+ '<td>'+this.reasonsforunmp+'</td>'
										));
								});
							}
						}else if(employinfo == "Self Employed"){
								$('div#tableElement').html('<table id="tabular" class="display">'
								+	'<thead>'
								+		'<tr>'
								+			'<th>Name</th>'
								+			'<th>Employment Information</th>'
								+			'<th>Course</th>'
								+			'<th>Year Graduated</th>'
								+			'<th>Company Name</th>'
								+			'<th>Company Address</th>'
								+			'<th>Sector</th>'
								+		'</tr>'
								+	'</thead>'
								+	'<tbody>'
								+	'</tbody>'
								+'</table>  ');
								$(data).each(function(){
									$('#tabular tbody').append($('<tr>'
										+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
										+ '<td>'+this.employinfo+'</td>'
										+ '<td>'+this.course+'</td>'
										+ '<td>'+this.yearcompleted+'</td>'
										+ '<td>'+this.compname+'</td>'
										+ '<td>'+this.compadd+'</td>'
										+ '<td>'+this.Sector+'</td>'
										));
								});
						}else{
							if(sector == ''){
								if(course == ''){
									if(okupasyon == '' && salary == ''){
										$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Employment Information</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												));
										});
									}else if(okupasyon == ''){
										$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Employment Information</th>'
										+           '<th>Salary</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.salary+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												));
										});	
									}else{
										if(salary == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Occupation</th>'
										+			'<th>Employment Information</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.Occupation+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												));
										});
										}else{
											$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Occupation</th>'
										+			'<th>Employment Information</th>'
										+           '<th>Salary</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.Occupation+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.salary+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												));
										});
										}	
									}
								}else{	
									if(okupasyon == '' && salary == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Employment Information</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													));
											});
										}else if(okupasyon == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Employment Information</th>'
											+           '<th>Salary</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.salary+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													));
											});	
										}else{
											if(salary == ''){
												$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Occupation</th>'
											+			'<th>Employment Information</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.Occupation+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													));
											});
											}else{
												$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Occupation</th>'
											+			'<th>Employment Information</th>'
											+           '<th>Salary</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.Occupation+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.salary+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													));
											});
											}	
										}			
								}
							}else{
								if(course == ''){
									if(okupasyon == '' && salary == ''){
										$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Employment Information</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+			'<th>Sector</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												+ '<td>'+this.Sector+'</td>'
												));
										});
									}else if(okupasyon == ''){
										$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Employment Information</th>'
										+           '<th>Salary</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+			'<th>Sector</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.salary+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												+ '<td>'+this.Sector+'</td>'
												));
										});	
									}else{
										if(salary == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Occupation</th>'
										+			'<th>Employment Information</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+			'<th>Sector</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.Occupation+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												+ '<td>'+this.Sector+'</td>'
												));
										});
										}else{
											$('div#tableElement').html('<table id="tabular" class="display">'
										+	'<thead>'
										+		'<tr>'
										+			'<th>Name</th>'
										+			'<th>Occupation</th>'
										+			'<th>Employment Information</th>'
										+           '<th>Salary</th>'
										+			'<th>Course</th>'
										+			'<th>Year Graduated</th>'
										+			'<th>Sector</th>'
										+		'</tr>'
										+	'</thead>'
										+	'<tbody>'
										+	'</tbody>'
										+'</table>  ');
										$(data).each(function(){
											$('#tabular tbody').append($('<tr>'
												+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
												+ '<td>'+this.Occupation+'</td>'
												+ '<td>'+this.employinfo+'</td>'
												+ '<td>'+this.salary+'</td>'
												+ '<td>'+this.course+'</td>'
												+ '<td>'+this.yearcompleted+'</td>'
												+ '<td>'+this.Sector+'</td>'
												));
										});
										}	
									}
								}else{	
									if(okupasyon == '' && salary == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Employment Information</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+			'<th>Sector</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													+ '<td>'+this.Sector+'</td>'
													));
											});
										}else if(okupasyon == ''){
											$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Employment Information</th>'
											+           '<th>Salary</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+			'<th>Sector</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.salary+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													+ '<td>'+this.Sector+'</td>'
													));
											});	
										}else{
											if(salary == ''){
												$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Occupation</th>'
											+			'<th>Employment Information</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+			'<th>Sector</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.Occupation+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													+ '<td>'+this.Sector+'</td>'
													));
											});
											}else{
												$('div#tableElement').html('<table id="tabular" class="display">'
											+	'<thead>'
											+		'<tr>'
											+			'<th>Name</th>'
											+			'<th>Occupation</th>'
											+			'<th>Employment Information</th>'
											+           '<th>Salary</th>'
											+			'<th>Course</th>'
											+			'<th>Year Graduated</th>'
											+			'<th>Sector</th>'
											+		'</tr>'
											+	'</thead>'
											+	'<tbody>'
											+	'</tbody>'
											+'</table>  ');
											$(data).each(function(){
												$('#tabular tbody').append($('<tr>'
													+ '<td>'+this.firstname+"\t"+this.middlename+"\t"+this.lastname+'</td>'
													+ '<td>'+this.Occupation+'</td>'
													+ '<td>'+this.employinfo+'</td>'
													+ '<td>'+this.salary+'</td>'
													+ '<td>'+this.course+'</td>'
													+ '<td>'+this.yearcompleted+'</td>'
													+ '<td>'+this.Sector+'</td>'
													));
											});
											}	
										}			
								}
							}
						}
					}

					$('#tabular').dataTable({
						bFilter:false
					});
				},error:function(errow){
					alert('error');
				}
			});

			$.ajax({
				type:'POST',
				url:'<?php echo base_url('administrator/getGraph')?>',
				data:{college:college,course:course,gender:gender,okupasyon:okupasyon,year:year,salary:salary,year1:year1,year2:year2,employinfo:employinfo,sector,sector},
				dataType:'json',
				success:function(data){
					if(okupasyon == '' && course == '' && employinfo ==''&& sector == ''&& salary==''){
						var ctx = document.getElementById("myChart").getContext("2d");
										var data = {
										  	labels: [college,'BSIT','BSCS','BSIS'],
										  	datasets: [{
									            label: 'Total # of Students',
									            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
									            backgroundColor: [
									                'red',
									                'blue',
									                'orange',
									                'yellow',
									                'green',
									                'rgba(255, 159, 64, 0.2)'
									            ],
									            borderColor: [
									                'rgba(255,99,132,1)',
									                'rgba(54, 162, 235, 1)',
									                'rgba(255, 206, 86, 1)',
									                'rgba(75, 192, 192, 1)',
									                'rgba(153, 102, 255, 1)',
									                'rgba(255, 159, 64, 1)'
									            ],
									            borderWidth: 1
									        }]
									    };

										var myBarChart = new Chart(ctx, {
											type: 'bar',
											data: data,
											options: {
											barValueSpacing: 20,
												scales: {
												    yAxes: [{
													    ticks: {
													    min: 0,
													    userCallback: function(label, index, labels) {
										                     // when the floored value is the same as the value we have a whole number
										                     if (Math.floor(label) === label) {
										                         return label;
										                     }

               											  },
												        },
												         gridLines: {
										                    color: "rgba(0, 0, 0, 0)",
										                }
												    }],
												    xAxes:[{
												    	 gridLines: {
									                     color: "rgba(0, 0, 0, 0)",
									                }
												    }]
												}
											}
										});
					}else if(okupasyon == '' && employinfo =='' && sector == '' && salary ==''){
						var ctx = document.getElementById("myChart").getContext("2d");
										var data = {
										  	labels: [college,course,],
										  	datasets: [{
									            label: 'Total # of Students',
									            data: [data[0].fnametotal,data[0].coursetotal],
									            backgroundColor: [
									                'red',
									                'blue',
									                'orange',
									                'yellow',
									                'green',
									                'rgba(255, 159, 64, 0.2)'
									            ],
									            borderColor: [
									                'rgba(255,99,132,1)',
									                'rgba(54, 162, 235, 1)',
									                'rgba(255, 206, 86, 1)',
									                'rgba(75, 192, 192, 1)',
									                'rgba(153, 102, 255, 1)',
									                'rgba(255, 159, 64, 1)'
									            ],
									            borderWidth: 1
									        }]
									    };

										var myBarChart = new Chart(ctx, {
											type: 'bar',
											data: data,
											options: {
											barValueSpacing: 20,
												scales: {
												    yAxes: [{
													    ticks: {
													    min: 0,
													    userCallback: function(label, index, labels) {
										                     // when the floored value is the same as the value we have a whole number
										                     if (Math.floor(label) === label) {
										                         return label;
										                     }

               											  },
												        },
												         gridLines: {
										                    color: "rgba(0, 0, 0, 0)",
										                }
												    }],
												    xAxes:[{
												    	 gridLines: {
									                     color: "rgba(0, 0, 0, 0)",
									                }
												    }]
												}
											}
										});
					}else{
						if(course==''){
							if(sector.length != 0){
								if(employinfo.length !=0){
									if(okupasyon.length !=0){
										if(salary.length !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Average salary',
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Total Number of '+okupasyon,
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}else{
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Average Salary',
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Total Number of Respondents with Employment Information in '+college,
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}
								}
							}else{
								if(employinfo.length !=0){
									if(okupasyon !=0){
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Average salary',
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Total Number of '+okupasyon,
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}else{
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Average Salary',
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,'BSIT','BSCS','BSIS'],
											  	datasets: [{
										            label: 'Total Number of Respondents with Employment Information in '+college,
										            data: [data[0].fnametotal,data[0].BSIT,data[0].BSCS,data[0].BSIS],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}
								}
							}
						}else{
							if(sector.length != 0){
								if(employinfo.length !=0){
									if(okupasyon.length !=0){
										if(salary.length !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Average salary',
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Total Number of '+okupasyon,
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}else{
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Average Salary',
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Total Number in '+sector+'Sector',
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}
								}
							}else{
								if(employinfo.length !=0){
									if(okupasyon !=0){
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Average salary',
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Total Number of '+okupasyon,
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}else{
										if(salary !=0){
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Average Salary',
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}else{
											var ctx = document.getElementById("myChart").getContext("2d");
											var data = {
											  	labels: [college,course],
											  	datasets: [{
										            label: 'Total Number of Respondents with Employment Information in '+college,
										            data: [data[0].fnametotal,data[0].coursetotal],
										            backgroundColor: [
										                'red',
										                'blue',
										                'orange',
										                'yellow',
										                'green',
										                'rgba(255, 159, 64, 0.2)'
										            ],
										            borderColor: [
										                'rgba(255,99,132,1)',
										                'rgba(54, 162, 235, 1)',
										                'rgba(255, 206, 86, 1)',
										                'rgba(75, 192, 192, 1)',
										                'rgba(153, 102, 255, 1)',
										                'rgba(255, 159, 64, 1)'
										            ],
										            borderWidth: 1
										        }]
										    };

											var myBarChart = new Chart(ctx, {
												type: 'bar',
												data: data,
												options: {
												barValueSpacing: 20,
													scales: {
													    yAxes: [{
														    ticks: {
														    min: 0,
														    userCallback: function(label, index, labels) {
											                     // when the floored value is the same as the value we have a whole number
											                     if (Math.floor(label) === label) {
											                         return label;
											                     }

	               											  },
													        },
													         gridLines: {
											                    color: "rgba(0, 0, 0, 0)",
											                }
													    }],
													    xAxes:[{
													    	 gridLines: {
										                     color: "rgba(0, 0, 0, 0)",
										                }
													    }]
													}
												}
											});
										}
									}
								}
							}
						}
					}
				}	
			});
		});


		$('#graph_college').on('change',function(){
			college = $('#graph_college option:selected').text();
			$('#graphprogram').empty();
			$('#graph_occupation').empty();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url('administrator/getCourses')?>",
				data:{college:college},
				dataType:'json',
				success : function(data){
					$('#graphprogram').append($('<option value="" class="black-text"></option>'));
					$(data).each(function(){
						$('#graphprogram').append($('<option value="" class="black-text"></option>').text(this.course_abbv));
					});
					$('#graph_gender').removeClass();
					$('#employment_info').removeClass();
					$('select').material_select();
				}

			});

			$.ajax({
				type:"POST",
				url:"<?php echo base_url('administrator/getOccupation')?>",
				data:{college:college},
				dataType:'json',
				success:function(data){
					$('#graph_occupation').append($('<option value="" class="black-text"></option>'));
					$(data).each(function(){
						$('#graph_occupation').append($('<option value="" class="black-text"></option>').text(this.occupations));
					});
					$('select').material_select();
				}
			});
		});

		$('#graphprogram').on('change',function(){
			course = $('#graphprogram option:selected').text();
			if(course == ''){
				$('#graph_college').removeClass();
			}else{
			$('#graph_college').addClass('disabledbutton');

			}
			$('select').material_select();
		});

		$('#employment_info').on('change',function(){
			employinfo = $('#employment_info option:selected').val();
			if(employinfo == "Unemployed" || employinfo ==''){
				$('#graph_occupation').addClass('disabledbutton');
				$('#graph_salary').addClass('disabledbutton');
				$('#job_relateddrop').addClass('disabledbutton');
				$('#sectorial').addClass('disabledbutton');
			}else if(employinfo == "Self Employed"){
				$('#sectorial option:eq(2)').prop('selected',true);
				$('#sectorial').addClass('disabledbutton');
			}else{
				$('#graph_occupation').removeClass();
				$('#graph_salary').removeClass();
				$('#job_relateddrop').removeClass();
				$('#sectorial').removeClass();
			}
			$('select').material_select();
		});

		$('#job_relateddrop').on('change',function(){
			jobrelated = $('#job_relateddrop option:selected').text();
		});

		$('#graph_gender').on('change',function(){
			gender = $('#graph_gender option:selected').text();
			$('select').material_select();
			Materialize.updateTextFields();			
		});

		$('#graph_occupation').on('change',function(){
			okupasyon = $('#graph_occupation option:selected').text();
			$('select').material_select();
			Materialize.updateTextFields();
			
		});

		$('#graph_year_graduated').on('change',function(){
			year = $('#graph_year_graduated').val();
			$('select').material_select();
		});

		$('#graph_salary').on('change',function(){
			salary = $('#graph_salary option:selected').text();
			$('select').material_select();
		});

		$('#sectorial').on('change',function(){
			sector = $('#sectorial option:selected').text();
			$('select').material_select();
		});


		$('ul.tabs').tabs('select_tab', 'Generate_Reports');
    		
		});


		$('#generatepdf').on('click',function(){
			/*canvas3 = document.createElement('canvas');
				canvas3.id = 'canvas3';
				canvas3.width = 1000;
				canvas3.height = 2000;

				base_image = new Image();
				context3 = canvas3.getContext('2d');
				context3.drawImage(myChart, 40,50,370,200);
				 var doc = new jsPDF('p', 'pt','letter');
				      
				        var imgData = canvas3.toDataURL(
				          'image/png');
				        doc.setFontSize(20)
			   			doc.text(32, 25, 'Graduate Tracer Reports')
				        doc.addImage(imgData, 'PNG', 0,0);
				        doc.save('sample-file.pdf');*/
				        var pdf = new jsPDF('p', 'pt', 'letter');
		        // source can be HTML-formatted string, or a reference
		        // to an actual DOM element from which the text will be scraped.
		        source = $('#tableElement')[0];

		        // we support special element handlers. Register them with jQuery-style 
		        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
		        // There is no support for any other type of selectors 
		        // (class, of compound) at this time.
		        specialElementHandlers = {
		            // element with id of "bypass" - jQuery style selector
		            '#bypassme': function (element, renderer) {
		                // true = "handled elsewhere, bypass text extraction"
		                return true
		            }
		        };
		        margins = {
		            top: 80,
		            bottom: 60,
		            left: 40,
		            width: 600
		        };
		        // all coords and widths are in jsPDF instance's declared units
		        // 'inches' in this case
		        pdf.fromHTML(
		            source, // HTML string or DOM elem ref.
		            margins.left, // x coord
		            margins.top, { // y coord
		                'width': margins.width, // max width of content on PDF
		                'elementHandlers': specialElementHandlers
		            },

		            function (dispose) {
		                // dispose: object with X, Y of the last line add to the PDF 
		                //          this allow the insertion of new lines after html
		                canvas3 = document.createElement('canvas');
						canvas3.id = 'canvas3';
						canvas3.width = 1000;
						canvas3.height = 2000;

						base_image = new Image();
						context3 = canvas3.getContext('2d');
						context3.drawImage(myChart, 40,450,700,350);
						var imgData = canvas3.toDataURL(
						          'image/png');
						        pdf.setFontSize(28)
					   			pdf.text(32, 25, 'Graduate Tracer Reports')
						        pdf.addImage(imgData, 'PNG', 0,0);
		                pdf.save('GeneratedReport.pdf');
		            }, margins
		        );
		});

		$('select').material_select();
	</script>
</head>
<body>
	<div class="row">
		<div class="col s12">
			<div class="row">
			    <div class="col s12">
				    <ul class="tabs">
				        <li class="tab col s3"><a class="black-text" href="#Generate_Reports">Reports</a></li>
				        <li class="tab col s3"><a class="black-text" href="#Email_Notice">Send E-mail Notice</a></li>
				    </ul>
			    </div>
			    
			    <div id="Generate_Reports">
			    	<div class="row">
			    		<div class="col s12">
			    			<h3>Display Reports By:</h3>
			    		</div>
			    		<div class="input-field col l4 s6">
					        <input id="graph_year_graduated" type="text"  onkeypress='return event.charCode >= 45 && event.charCode <= 57' maxlength="9">
					        <label for="year_graduated_alumni">Year Graduated</label>
					  	</div>
			    		<div class="input-field col l4 s6">
    						<select id="graph_college">  
    							<option value="" class="black-text"></option>
    							<option value="COS" class="black-text">COS</option>
							    <option value="CAFA" class="black-text">CAFA</option>
							    <option value="CLA" class="black-text">CLA</option>
							    <option value="CIT" class="black-text">CIT</option>
							    <option value="CIE" class="black-text">CIE</option>
							    <option value="COE" class="black-text">COE</option>
					    	</select>
					    	<label>College</label> 
					  	</div>
					  	<div class="input-field col l4 s6">
    						<select id="graphprogram" class="Programs">  
    							<option value="" class="black-text"></option>
					    	</select> 
					    	<label>Program</label>
					  	</div>
					</div>
					<div class="row">
						<div class="input-field col l4 s6">
    						<select id="employment_info" class="disabledbutton"> 
    							<option value="" class="black-text"></option>
    							<option value="Employed Locally" class="black-text">Employed Locally</option> 
    							<option value="Unemployed" class="black-text">Unemployed</option>
    							<option value="Self Employed" class="black-text">Self-Employed</option> 
    							<option value="Employed Abroad" class="black-text">Employed Abroad</option>
					    	</select> 
					    	<label>Employment Information</label>
					  	</div>
					  	<div class="input-field col l4 s6">
    						<select id="sectorial" class="disabledbutton">  
    							<option value="" class="black-text"></option>
    							<option value="government" class="black-text">Government</option>
							    <option value="private" class="black-text">Private</option>
							    <option value="ngo" class="black-text">NGO/Foundation</option>
							    <option value="academe" class="black-text">Academe</option>
					    	</select> 
					    	<label>Sector</label>
					  	</div>		 
					  	<div class="input-field col l4 s6">
    						<select id="graph_occupation" class="disabledbutton">  
    							<option value="" class="black-text"></option>
					    	</select> 
					    	<label>Occupation</label>
					  	</div>
					  	<div class="input-field col l4 s6">
    						<select id="graph_salary" class="disabledbutton"> 
    							<option value="" class="black-text"></option> 
    							<option value="15000" class="black-text">Above Php15,000</option> 
							    <option value="14999" class="black-text">Below Php15,000</option>
					    	</select> 
					    	<label>Salary</label>
					  	</div>
					</div>
					<div class="row left">
						<div class="col l12 s12">
							<a class="waves-effect waves-light btn red" id="request"><i class="material-icons right">search</i>Search</a>
						</div>
					</div>
					<div class="row">
						<div class="col s12" id="tableElement">							 	
						</div>
					</div>
			    	<div class="row">
			    		<div class="col s12">
			    			<!-- Group Chart -->
			    			<div class="col l6 s12" id="myChartdiv">
			    				<canvas id="myChart" width="100" height="50"></canvas>
							</div>
					
				    		<div class="row">
				    			<div class="col s12">
				    				<a class="waves-effect waves-light btn red col s12" id="generatepdf">Generate PDF</a>
				    			</div> 			
				    		</div>
			    		</div>
			    	</div> 
					</div>
			    </div>
			     
			    <div id="Email_Notice">
			    	<div class="col s12">
			    		<div class="row">
			    			<h4>Send E-mail Notice</h4>
			    			<div class="col s12">
				    			<div class="input-field col l4 m4 s12">
			                    	<input type="text" id="searchGraduates" maxlength="9">
									<label for="searchGraduates">Search Gradutes:</label>
								</div>
							</div>				
			    		</div>
			    	</div>
	                
					<div id="college_content">
						<div class="col s12">
							<div class="col s12">
								<h4>Graduate Lists</h4>
							</div>	
							<table id="tableofgraduates">
				              <thead>
				                <tr>
				                    <th data-field="Members">Name</th>
				                    <th data-field="Course">Course</th>
				                    <th data-field="E-mail">Year Graduated</th>
				                </tr> 
				              </thead>

				              <tbody>

				              </tbody>
				            </table>
						</div>
					</div>   
					<div class="row right">
						<div class="col s12">
                			<a id="sendEmail" class="waves-effect waves-light btn red"><i class="material-icons right">send</i>Send</a>
						</div>
					</div>                            
			    </div>

			    <div id = "cosvalues">
					<?php
					if(is_array($cos)||is_object($cos)){
						foreach ($cos as $data) {
							echo'<input type="hidden" id="cossurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="cossalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="cosemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="cosunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="cosgoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="cosprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="cosrelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

				<div id ="clavalue">
					<?php
					if(is_array($cla)||is_object($cla)){
						foreach ($cla as $data) {
							echo'<input type="hidden" id="clasurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="clasalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="claemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="claunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="clagoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="claprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="clarelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

				<div id="cafavalue">
					<?php
					if(is_array($cafa)||is_object($cafa)){
						foreach ($cafa as $data) {
							echo'<input type="hidden" id="cafasurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="cafasalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="cafaemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="cafaunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="cafagoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="cafaprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="cafarelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

				<div id="coevalue">
					<?php
					if(is_array($coe)||is_object($coe)){
						foreach ($coe as $data) {
							echo'<input type="hidden" id="coesurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="coesalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="coeemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="coeunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="coegoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="coeprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="coerelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

				<div id="citvalue">
					<?php
					if(is_array($cit)||is_object($cit)){
						foreach ($cit as $data) {
							echo'<input type="hidden" id="citsurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="citsalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="citemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="citunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="citgoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="citprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="citrelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

				<div id="cievalue">
					<?php
					if(is_array($cie)||is_object($cie)){
						foreach ($cie as $data) {
							echo'<input type="hidden" id="ciesurveytotal" value="'.$data->survey_total.'">
								 <input type="hidden" id="ciesalary" value="'.$data->salarytotal.'">
								 <input type="hidden" id="cieemp" value="'.$data->survey_employed.'">
								 <input type="hidden" id="cieunem" value="'.$data->survey_unemployed.'">
								 <input type="hidden" id="ciegoverment" value="'.$data->survey_goverment.'">
								 <input type="hidden" id="cieprivate" value="'.$data->survey_private.'">
								 <input type="hidden" id="cierelated" value="'.$data->survey_acad.'">
								';
						}
					}
					?>
				</div>

	  		</div>
		</div>
	</div>
</body>
</html>