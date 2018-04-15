<!DOCTYPE html>
<html>
<head>   
    <link rel="stylesheet" href= "<?php echo base_url('assets/css/newsfeed.css');?>"> 
    <link rel="stylesheet" href="<?php echo base_url('assets/css/member_style.css');?>">
    <style>
    .image_attached {
      max-height: 800px;
      max-width: 800px;
    }
    .comment_img {
       max-height: 50px;
      max-width: 50px;
    }  
    .write_comment_img {
       max-height: 120px;
      max-width: 120px;
    }  
    </style>
    <script>
    $(document).ready(function(){
        $('.Boxing').materialbox();  
        $('#submitButton').on('click',function(){
        var id = $('.grouppage-form').attr('id');
        var text = $('.materialize-textarea').val();
        var image = $('#upload_image_name').val();
        var file = $('#attach_file_name').val();
        var currentdate = new Date(); 
        var datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getDate() + " "  
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();
        var approve = 0;
            $.ajax({
                    type : 'POST',
                    url  : '<?php echo base_url('insertPost');?>',
                    data : { id:id, text:text, datetime:datetime,image:image,file:file,approve:approve},
                    dataType : 'json',
                    success: function(data){
                      $('textarea.materialize-textarea').val('');
                      $('#Upload_Image').val('file name');
                      $('#upload_image_name').val('');
                      $('#attach_file_name').val('');
                      $('#attach_file').val('');
                      Materialize.updateTextFields();
                      Materialize.toast('Post Pending for Approval', 4000);
                    },
                    error: function(errorw){
                       if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                          var json = $.parseJSON( errorw.responseText );
                        }
                        Materialize.toast(json, 4000);
                    }      
              });       
        });

        $('.modal').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
              opacity: .5, // Opacity of modal background
              in_duration: 300, // Transition in duration
              out_duration: 200, // Transition out duration
              starting_top: '4%', // Starting top style attribute
              ending_top: '10%', 
        });

        $('#upload_image_button').on('click', function(){
              var imageFile = $('input[name=upload_image_input]');
              var imageToUpload = imageFile[0].files[0];
              var imageName = $('#upload_image_name').val();
              $('#Upload_Image').val(imageName);


               if(imageToUpload) {
                        
                          //Provide the form data that would be sent to server through ajax
                          var formData = new FormData();
                          var uploadURI = '<?php echo base_url('uploadImage'); ?>';

                         formData.append('upload_image_input', imageToUpload);

                          //Upload the file using ajax
                          $.ajax({
                              type: 'POST'
                              , url: uploadURI
                              , data: formData
                              , processData: false
                              , contentType: false
                              , success: function() {
                                var image = '<?php echo base_url("assets/images/'+ imageName +'"); ?>';
                                  //$('#profile_pic').attr('src', image);
                                  Materialize.toast('Image Attached', 4000);
                              }
                              , error: function(errorw){
                                  Materialize.toast('Something went wrong. Please try again', 4000);
                              }
                          });
                      }
                      else{
                          Materialize.toast('Field Empty', 4000);
                      }
                        
          });

          $('#attach_file_button').on('click',function(){
              var inputFile = $('input[name=attach_file_input]');
              var fileToUpload = inputFile[0].files[0];
              var fileName = $('#attach_file_name').val();
              $('#attach_file').val(fileName);

                if(fileToUpload) {
                        
                          //Provide the form data that would be sent to server through ajax
                          var formData = new FormData();
                          var uploadURI = '<?php echo base_url('uploadFile'); ?>';

                          formData.append('attach_file_input', fileToUpload);

                          //Upload the file using ajax
                          $.ajax({
                              type: 'POST'
                              , url: uploadURI
                              , data: formData
                              , processData: false
                              , contentType: false
                              , success: function() {
                                //var image = '<?php echo base_url("assets/images/'+ fileName +'"); ?>';
                                  //$('#profile_pic').attr('src', image);
                                  Materialize.toast('File Attached', 4000);
                              }
                              , error: function(errorw){
                                  Materialize.toast('Something went wrong. Please try again', 4000);
                              }
                          });
                      }
                      else{
                          Materialize.toast('Field Empty', 4000);
                      }
          });

          $('a.discussion').on('click', function(event){
          event.preventDefault();
          var href = $('#' + event.target.id).attr('href');
          $('#userpage').empty();
          $('#userpage').load(href);
          });

         $('#poster').on('click', function(){
            var id = $('.grouppage-form').attr('id');
            $('#grouppost').empty();
            $.ajax({
              type:'POST',
              url:'<?php echo base_url('refreshGroup')?>',
              data:{id:id},
              dataType:'json',
              success:function(data){
                $(data).each(function(){
                  var href = '<?php base_url(); ?>'+ 'assets/images/' + this.accounts_picture;
                  var imageref = '<?php base_url(); ?>'+ 'assets/files/' + this.post_picture;
                  var fileName = '<?php base_url(); ?>'+ 'assets/files/' + this.post_file;  
                  var dis = '<?php base_url();?>'+'discuss/'+this.post_ID;
                  if(this.post_picture == ''){
                    $('#grouppost').append($('<div id="profile-page-wall-post" class="card">'
                                +  '<div class="card-profile-title">'
                                +      '<div class="row">'
                                +          '<div class="col l1 s4">'
                                +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                +          '</div>'
                                +          '<div class="col l10 s8">'
                                +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+this.post_date+'</span>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +              '<p>'+this.post_content+'</p>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +            '<a href="'+fileName+'" download>'+this.post_filename+'</a>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row">'
                                +                '<div class="col s12">'
                                +                  '<a href="'+dis+'" class="discussion btn red col s6" id="'+this.post_ID+'">View Discussion</a>'
                                +                '</div>'
                                +         '</div>'
                                +  '</div>'            
                            +  '</div>'
                  ));
                  }else{
                    if(this.post_picture.indexOf('mp4') >=0){
                      $('#grouppost').append($('<div id="profile-page-wall-post" class="card">'
                                +  '<div class="card-profile-title">'
                                +      '<div class="row">'
                                +          '<div class="col l1 s4">'
                                +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                +          '</div>'
                                +          '<div class="col l10 s8">'
                                +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+this.post_date+'</span>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row center-align">'
                                +          '<div class="col s6">'
                                +            '<video width="100%" height="auto" controls>'
                                +               '<source src="'+imageref+'" type="video/mp4">'
                                +               'Your browser does not support the video tag.'
                                +            '</video>'
                                +          '</div>'  
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +              '<p>'+this.post_content+'</p>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +            '<a href="'+fileName+'" download>'+this.post_filename+'</a>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row">'
                                +                '<div class="col s12">'
                                +                  '<a href="'+dis+'" class="discussion btn red col s6" id="'+this.post_ID+'">View Discussion</a>'
                                +                '</div>'
                                +         '</div>'
                                +  '</div>'            
                            +  '</div>'
                    ));
                    }else{
                      $('#grouppost').append($('<div id="profile-page-wall-post" class="card">'
                                +  '<div class="card-profile-title">'
                                +      '<div class="row">'
                                +          '<div class="col l1 s4">'
                                +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                +          '</div>'
                                +          '<div class="col l10 s8">'
                                +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+this.post_date+'</span>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row center-align">'
                                +          '<div class="col s12">'
                                +            '<img class="Boxing" height="auto" width="100%" src="'+imageref+'">'
                                +          '</div>'  
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +              '<p>'+this.post_content+'</p>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +            '<a href="'+fileName+'" download>'+this.post_filename+'</a>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row">'
                                +                '<div class="col s12">'
                                +                  '<a href="'+dis+'" class="discussion btn red col s6" id="'+this.post_ID+'">View Discussion</a>'
                                +                '</div>'
                                +         '</div>'
                                +  '</div>'            
                            +  '</div>'
                    ));
                    }
                  }     
                });
              }
            });
          });

        $('#eventS').on('click',function(){
            var id = $('.grouppage-form').attr('id');
            $('#eventsTab').empty();
            $.ajax({
              type:'POST',
              url:'<?php echo base_url('refreshEvents')?>',
              data:{id:id},
              dataType:'json',
              success:function(data){
               $(data).each(function(){
                      var imageref = '<?php base_url(); ?>'+ 'assets/files/' + this.event_picture;
                      if(this.event_picture == '' || this.event_picture == null){
                        $('#eventsTab').prepend($('<div class="row">'
                        +  '<div class="col s12 z-depth-2">'
                        +      '<div class="card darken-1 z-depth-0">'
                        +          '<div class="card-content black-text center-align">'
                        +              '<h3>'+this.events_name+'</h3>'                                   
                        +          '</div>'
                        +          '<div class="card-action row">'
                        +              '<div class="col s12 center-align">'
                        +                  '<p>'+this.events_description+'</p>'
                        +              '</div>'
                        +              '<div class="col s12">'
                        +                  '<p>'+this.events_date+'</p>'
                        +              '</div>'
                        +              '<div class="col s12">'
                        +                  '<p>'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                        +              '</div>' 
                        +          '</div>'
                        +      '</div>'
                        +   '</div>'
                        +  '</div>'
                      ));
                      }else{
                        $('#eventsTab').prepend($('<div class="row">'
                          +  '<div class="col s12 z-depth-2">'
                          +      '<div class="card darken-1 z-depth-0">'
                          +          '<div class="card-content black-text center-align">'
                          +              '<h3>'+this.events_name+'</h3>'                                   
                          +          '</div>'
                          +          '<div class="card-action row">'
                          +              '<div class="col s12 center-align">'
                          +                  '<p>'+this.events_description+'</p>'
                          +              '</div>'
                          +              '<div class="col s12 center-align">'
                          +                  '<img class="Boxing" height="auto" width="100%" src="'+imageref+'">'
                          +             '</div>'
                          +              '<div class="col s12">'
                          +                  '<p>'+this.events_date+'</p>'
                          +              '</div>'
                          +              '<div class="col s12">'
                          +                  '<p>'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                          +              '</div>' 
                          +          '</div>'
                          +      '</div>'
                          +   '</div>'
                          +  '</div>'
                        ));
                      }
                    });
              }
            });
        });

        $('#membersTab').on('click',function(){
          var id = $('.grouppage-form').attr('id');
          $('#members').empty();
          $.ajax({
            type:'POST',
            url:'<?php echo base_url('refreshMembers')?>',
            data:{id:id},
            dataType:'json',
            success:function(data){
              $(data).each(function(){
                var href = '<?php base_url(); ?>'+ 'assets/images/' + this.accounts_picture;
                $('#members').append($('<div class="col l6 s12 z-depth-1">'
                          +  '<div class="col l4 s4">'
                          +      '<img class="member_div" src="'+href+'" height="auto" width="100%">'
                          +  '</div>'
                          +  '<div id="member_details" class="col l8 s8 member_div">'
                          +      '<span id="member_name">'+this.accounts_fname+ '\t' +this.accounts_lname+'</span><br>'
                          +      '<span id="member_course">'+this.course_abbv+'</span><br>'
                          +      '<span id="member_email">'+this.accounts_email+'</span><br>'
                          +   '</div>'
                          +  '</div>'
                  ));
              });
            }
          });
        });
    });     
    </script>
</head>
<body> 
    <div class="container">
        <div class="row"> 
            <ul class="tabs">
                <li class="tab col s3 "><a href="#post" id ="poster" class="black-text">Posts</a></li>
                <li class="tab col s3 "><a href="#eventsTab" id = "eventS" class="black-text">Events</a></li>
                <li class="tab col s3 "><a href="#members" id ="membersTab" class="black-text">Members</a></li>
            </ul>
          <div id="eventsTab">
          </div>
          <div id="members">
              <div class="row">
              </div>
          </div>
            <div id="post">
                <div id="UpdateStatus" class="tab-content grey lighten-4">
                  <div class="card-panel grey lighten-5 z-depth-1">
                    <div class="row valign-wrapper">
                      <div class="col l2 m2 hide-on-small-only">
                          <img src="<?php echo base_url('assets/images/'.$details->accounts_picture.'');?>" alt="" class="circle responsive-img valign profile-image-post">
                      </div>
                      <div class="col l10 m10 s12">
                          <div> 
                              <?php
                              echo '
                              <form class="grouppage-form" id ="'.$groupId.'">
                                  <div class="input-field col l12 m12 s12">
                                      <textarea name = "textarea"  id="GroupPost" row="2" class="materialize-textarea" style="height: 22px;"></textarea>
                                      <label for="textarea" class="">Whats on your mind?</label>    
                                  </div>
                              </form>';   
                              ?>  
                              <div class="input-field col l12 m12 s12">
                                <input placeholder=""  disabled value="file name" id="Upload_Image" type="text" class="validate">
                                <label for="Upload_Image">Image file</label>
                              </div>
                              <div class="input-field col l12 m12 s12">
                                <input placeholder="" disabled value="file name" id="attach_file" type="text" class="validate">
                                <label for="attach_file">Attached file</label>
                              </div>
                              <div class="col l12 m12 s12 left"> 
                                  <button id="submitButton" class="waves-effect waves-light btn red"><i class="mdi-maps-rate-review left"></i>Post</button>
                                  <a href="#upload_image" class="modal-trigger btn-floating btn-medium red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Choose an image to upload "><i class="material-icons">assignment_ind</i></a>
                                  <a href="#attach_file" class="modal-trigger btn-floating btn-medium red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Choose a file to upload "><i class="material-icons">launch</i></a>
                              </div> 
                          </div>  
                      </div>
                    </div>
                  </div>
                </div>

              <div id="grouppost">
                  <?php
                    if(is_array($init) || is_object($init)){

                      foreach ($init as $data) {
                        if($data->post_picture == ''){
                           echo '
                              <div id="profile-page-wall-post" class="card">
                                  <div class="card-profile-title">
                                      <div class="row">
                                          <div class="col l1 s4">
                                             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                       
                                          </div>
                                          <div class="col l10 s8">
                                              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
                                              <span class="grey-text text-darken-1 ultra-small">Shared publicly  '.$data->post_date.'</span>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                              <p>'.$data->post_content.'</p>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                            <a href="'.base_url('assets/files/'.$data->post_file.'').'" download>'.$data->post_filename.'</a>
                                          </div>
                                      </div>
                                      <div class="row">
                                        <div class="col s12">
                                          <a href="'.base_url('discuss/'.$data->post_ID.'').'" class="discussion btn red col s6" id="'.$data->post_ID.'">View Discussion</a>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                                ';
                        }else{
                           if(strpos($data->post_picture, 'mp4') === false){
                           echo '
                              <div id="profile-page-wall-post" class="card">
                                  <div class="card-profile-title">
                                      <div class="row">
                                          <div class="col l1 s4">
                                             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                       
                                          </div>
                                          <div class="col l10 s8">
                                              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
                                              <span class="grey-text text-darken-1 ultra-small">Shared publicly  '.$data->post_date.'</span>
                                          </div>
                                      </div>
                                      <div class="row center-align">  
                                          <div class="col s12">
                                            <img class="Boxing image_attached" src="'.base_url('assets/files/'.$data->post_picture.'').'">
                                          </div>  
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                              <p>'.$data->post_content.'</p>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                            <a href="'.base_url('assets/files/'.$data->post_file.'').'" download>'.$data->post_filename.'</a>
                                          </div>
                                      </div>
                                      <div class="row">
                                        <div class="col s12">
                                          <a href="'.base_url('discuss/'.$data->post_ID.'').'" class="discussion btn red col s6" id="'.$data->post_ID.'">View Discussion</a>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                                ';
                          }else{
                            echo '
                              <div id="profile-page-wall-post" class="card">
                                  <div class="card-profile-title">
                                      <div class="row">
                                          <div class="col l1 s4">
                                             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                       
                                          </div>
                                          <div class="col l10 s8">
                                              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
                                              <span class="grey-text text-darken-1 ultra-small">Shared publicly  '.$data->post_date.'</span>
                                          </div>
                                      </div>
                                      <div class="row center-align">  
                                          <div class="col s6">
                                            <video width="400" height="200" controls>
                                               <source src="'.base_url('assets/files/'.$data->post_picture.'').'" type="video/mp4">
                                               Your browser does not support the video tag.
                                            </video>
                                          </div>  
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                              <p>'.$data->post_content.'</p>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col s12">
                                            <a href="'.base_url('assets/files/'.$data->post_file.'').'" download>'.$data->post_filename.'</a>
                                          </div>
                                      </div>
                                      <div class="row">
                                        <div class="col s12">
                                          <a href="'.base_url('discuss/'.$data->post_ID.'').'" class="discussion btn red col s6" id="'.$data->post_ID.'">View Discussion</a>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                                ';
                          }
                        }
                      }
                    } 
                  ?>
                </div>   
            </div>
            <div id="attach_file" class="modal">
                <div class="modal-content">
                    <h4>Attach File</h4>
                    <div class="row">
                        <div class="file-field input field col l12">
                            <div class="btn red col s4">
                                <span>Upload File</span>
                                <input id="attach_file_input" name="attach_file_input" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path" id="attach_file_name" type="text">
                            </div>
                           
                        </div>  
                    </div>
                </div>
                <div class="modal-footer">
                  <a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
                   <a id="attach_file_button" href="#!" class="modal-action modal-close waves-effect btn-flat ">Attach</a>     
                </div>  
            </div>

            <div id="upload_image" class="modal">
                <div class="modal-content">
                    <h4>Attach Image</h4>
                    <div class="row">
                        <div class="file-field input field col l12">
                            <div class="btn red col s4">
                                <span>Upload Image</span>
                                <input id="upload_image_input" name="upload_image_input" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path" id="upload_image_name" type="text">
                            </div>
                           
                        </div>  
                    </div>
                </div>
                <div class="modal-footer">
                  <a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
                   <a id="upload_image_button" href="#!" class="modal-action modal-close waves-effect btn-flat ">Attach</a>     
                </div>  
            </div>
    </div>
</body>
</html>