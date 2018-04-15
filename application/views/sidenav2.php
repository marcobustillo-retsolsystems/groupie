<!DOCTYPE html>
<html>
<head> 
  <style>
    .maroon {
    background-color: #BD2031;
    }
  </style>
  <script src="<?php echo base_url('assets/js/picker.js')?>"></script>
  <script src="<?php echo base_url('assets/js/picker.time.js')?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
   	    $("#userpage").load("<?php echo base_url('newsfeedcontroller/showPost');?>");
        
        $("#side-nav-collapse").sideNav();
       
        $(".dropdown-button").dropdown({
            hover: false
        });
			  
        $('.modal').modal({
	        	dismissible: true, // Modal can be dismissed by clicking outside of the modal
	      		opacity: .5, // Opacity of modal background
	      		in_duration: 300, // Transition in duration
			    out_duration: 200, // Transition out duration
			    starting_top: '4%', // Starting top style attribute
			    ending_top: '10%', // Ending top style attribute
			     // Callback for Modal close
    		}
  			);

  			$('#brandLogo').on('click', function() {
  				$('#userpage').empty();
  				$('#userpage').load('newsfeedRefresh');
  			});

        
  			$('a.collection-item').on('click', function(event){
  				event.preventDefault();
  				var href = $('#' + event.target.id).attr('href');
  				$('#userpage').empty();
  				$('#userpage').load(href);
  				$("#sidenav-overlay").trigger("click");
  			});

        $(document).on('click', ".collection-item-group", function (e) {
          event.preventDefault();
          var href = $('#' + event.target.id).attr('href');
          $('#userpage').empty();
          $('#userpage').load(href);
          $("#sidenav-overlay").trigger("click");
        });


         $('#confirm').on('click',function(){
            var id = $('.userID').val();
            var oldpass = $('#old_pass').val();
            var newpass = $('#new_pass').val();
            var confirmnewpass = $('#confirm_pass').val();
            if(id||oldpass||newpass||confirmnewpass){
              $.ajax({
              type : "POST",
              url : "<?php echo base_url('changePassword');?>",
              data : { id:id, oldpass:oldpass,newpass:newpass,confirmnewpass:confirmnewpass},
              dataType : 'json',
              success:function(){
                 $('#old_pass').val('');
                 $('#new_pass').val('');
                 $('#confirm_pass').val('');
                Materialize.updateTextFields();  
                Materialize.toast('Password Changed', 4000);     
              },error:function(errorw){
                if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                   // var json = $.parseJSON( errorw.responseText );
                    Materialize.toast('Something Went Wrong. Try Again.', 4000);
                    $('#old_pass').val('');
                    $('#new_pass').val('');
                    $('#confirm_pass').val('');
                    Materialize.updateTextFields();  
                }
              }
            });
            }
            else{
                Materialize.toast('Field Empty', 4000);
            }
            
        });

        $('#profile_pic_button').on('click', function() {
                    var inputFile = $('input[name=profile_pic_input]');

                    var fileToUpload = inputFile[0].files[0];

                    var fileName = $('#profile_pic_filename').val();

                    //Check if there are filesH to upload
                    if(fileToUpload != 'undefined') {
                    
                        //Provide the form data that would be sent to server through ajax
                        var formData = new FormData();
                        var uploadURI = '<?php echo base_url('Login/Upload'); ?>';

                        formData.append('profile_pic_input', fileToUpload);

                        //Upload the file using ajax
                        $.ajax({
                            type: 'POST'
                            , url: uploadURI
                            , data: formData
                            , processData: false
                            , contentType: false
                            , success: function() {
                              var image = '<?php echo base_url("assets/images/'+ fileName +'"); ?>';
                                $('#profile_pic').attr('src', image);
                            }
                            , error: function(errorw) {
                                Materialize.toast('Something went wrong. Please try again', 4000);
                            }
                        });
                    } 
                    else{
                      Materialize.toast('Field Empty', 4000);
                    }         
        });

  			$('#creategroupModalButton').on('click',function(event){
  				var groupName = $('#GroupNameModal').val();
          var baseURL = "<?php echo base_url();?>"

          if(groupName){
            $.ajax({
            type: 'POST',
            url: '<?php echo base_url('createGroup');?>',
            data:{ groupName:groupName },
            dataType:'json',


            success:function(data){
              var href = '<?php base_url(); ?>'+ 'groups/' + data;
                 $('#groupprep').append($('<a href="'+href+'" class="collection-item-group" style="color:red" id="'+data+'">'+groupName+'</a>'
                          
              ));
                              
               $('#userpage').empty();
               $('#userpage').load(href);
               $('#GroupNameModal').val('');
               Materialize.updateTextFields();
               Materialize.toast('Group Created!', 4000);
            },
            error:function(xhr, ajaxOptions, thrownError){
                  Materialize.toast('Something went wrong. Please try again.', 4000);
            }
            });
          }
          else{
               Materialize.toast('Field Empty!', 4000);
          }
  			});

	    });

	</script>


</head>
<body bgcolor="#ffebee">
	<ul id="slide-out" class="side-nav" style="transform: translateX(0px)">	
	    <li id = "node1">
	    	<div class="userView">
	    		<div class="background">
	    			<img src="<?php echo base_url();?>assets/images/maroon.png">
	    		</div>
	    		 <a href="#changepic_modal">
              <?php
                $picture = null;

                if(is_null($details->accounts_picture) || $details->accounts_picture == "") {
                  $picture = 'assets/images/def.jpg';
                }
                else {
                  $picture = 'assets/images/' . $details->accounts_picture;
                }
              ?>
              <img id="profile_pic" class="circle tooltipped" data-position="right" data-delay="50" data-tooltip="Change Profile Picture" 
                src="<?php echo base_url($picture) ?>" height='100' width='100'>
            </a>
	    		<div class="row">
	    			<div class="col l12">
	    				<span class="white-text name">
    						<?php echo $details->accounts_fname . "\t" . $details->accounts_lname;?>
    					</span> 
    				</div>
	    			<div class="col l12">
	    				<span class="white-text">
    						<p><?php echo $details->accounts_type;?></p>
    					</span> 
    				</div>
    				 
	    			<div class="col l12">
	    				<span id="email" class="white-text email">
    						<?php echo $details->accounts_email;?>	
    					</span> 
    				</div>
	    			<div class="col l12 s12 offset-l1 offset-s4">
	    				<a href="#change_password" class="white-text"><u>Change Password</u></a>
    				</div>  
            <div class="col l12 offset-l1 offset-s7 hide-on-med-and-up">
              <a href="<?php echo base_url('Login/logout');?>" class="white-text"><u>Log Out</u></a>
            </div>   				 				    		 			
	    		</div>
		    </li>
    <div class="collection" id ="groupprep">
        <?php
        if(is_array($init) || is_object($init)){
          foreach($init as $data){
            echo '
            <a href="'.base_url('groups/'.$data->groups_ID.'').'" class="collection-item" style="color:red" id="'.$data->groups_ID.'">'. $data->groups_Name.'</a>';
          }
        }
        ?>
        </div>
	</ul>

  	<nav>
	    <div class="nav-wrapper">
	    	<div class="row">
              <div class="left">           
                  <a href="" data-activates="slide-out" id="side-nav-collapse" class="btn-floating btn-large red tooltipped" data-position="right" data-delay="50" data-tooltip="Open Sidenav" ><i class="material-icons">menu</i></a> 
                  <a href="#creategroupModal" class="hide-on-small-only">Create New Group</a>
              </div> 
          		<div>
                  <a id="brandLogo" href="#" class="brand-logo center"><img src="<?php echo base_url();?>assets/images/logo1.jpg" height="100%" width="auto"></a> 
              </div>
              <div class="right hide-on-med-and-up">
                <a href="#creategroupModal" class="">Create New Group &nbsp</a>
              </div>		 
          		<div class="right hide-on-small-only">
          			<ul>	
  		       			<li><span><?php echo $details->accounts_fname . "\t" . $details->accounts_lname;?></span></li>
  		        		<li><a href="<?php echo base_url('Login/logout');?>">Log Out</a></li>             
		    		    </ul>
              </div>
		    </div>     		 
	    </div>
	  </nav>

    <?php echo'
	  <div id="change_password" class="modal">
    	<form method="POST" action="">
    		<div class="modal-content">
    			<h4>Change Password</h4>
    				<div class="row">
      					<div class="col l12 s12 input-field">
                  <input type="hidden" class="userID" value="'.$groupId.'">
      						<label for="old_pass">Type Old Password</label>
      						<input id="old_pass" type="password" class="validate" required>	
      					</div>
      					<div class="col l6 s12 input-field">
      						<label for="new_pass">Type New Password</label>
      						<input id="new_pass" type="password" class="validate" required>		
      					</div>
      					<div class="col l6 s12 input-field">
      						<label for="confirm_pass">Confirm Password</label>
      						<input id="confirm_pass" type="password" class="validate" required>			
      					</div>
      				</div>
    		</div>
    		<div class="modal-footer">
    			<a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
    			<a href="#!" id = "confirm" class=" modal-action modal-close waves-effect btn-flat">Confirm</a> 		 	
    		</div>
    	</form>
  	</div>';
    ?>

    <div id="changepic_modal" class="modal">
        <div class="modal-content">
            <h4>Change Profile Picture</h4>
            <div class="row">
                <div class="file-field input field">
                    <div class="btn red">
                        <span>Change Profile Picture</span>
                        <input id="profile_pic_input" name="profile_pic_input" type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" id="profile_pic_filename" type="text">
                    </div>
                   
                </div>  
            </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
           <a id="profile_pic_button" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Upload</a>     
        </div>  
    </div>

  	<div id="creategroupModal" class="modal">
      		<div class="modal-content">
      			<form>
  	    			<h4>Create Group</h4>
      				<div class="row">
        					<div class="col s12 input-field">
        						<label for="GroupNameModal">Type Group Name</label>
        						<input id="GroupNameModal" type="text" class="validate" required>	
        					</div>	
        				</div>
        			</form>
      		</div>
      		<div class="modal-footer">
      			<a href="#!" class="modal-action modal-close waves-effect btn-flat">Close</a>
      			<a href="#!" id="creategroupModalButton" class="modal-action modal-close waves-effect btn-flat">Confirm</a>
      		</div>
    </div>

  	<div id = "userpage">
  	</div>
</body>
</html>