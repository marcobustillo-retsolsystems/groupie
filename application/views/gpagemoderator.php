<!DOCTYPE html>
<html>
<head>   
    <link rel="stylesheet" href= "<?php echo base_url('assets/css/newsfeed.css');?>"> 
    <link rel="stylesheet" href="<?php echo base_url('assets/css/member_style.css');?>">
     <script src="<?php echo base_url('assets/js/picker.time.js')?>"></script>
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
        $('#eventtime').pickatime({
          container:'body',
          min:[7,00],
          max:[19,00],
          formatSubmit: 'HH:i',
          hiddenName: true
        });

        $('.datepicker').pickadate({
            container: 'body',
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year
            min: true,
            format: 'yyyy-mm-dd'
        });

        $('#previewImage').on('click',function(){
            var imageFile = $('input[name=upload_image_input_event]');
            var imageToUpload = imageFile[0].files[0];
            var imageName = $('#upload_image_name_event').val();
            $('#upload_image_name_event').val(imageName);

             if(imageToUpload) {
                      
                        //Provide the form data that would be sent to server through ajax
                        var formData = new FormData();
                        var uploadURI = '<?php echo base_url('uploadImageEvent'); ?>';

                       formData.append('upload_image_input_event', imageToUpload);

                        //Upload the file using ajax
                        $.ajax({
                            type: 'POST'
                            , url: uploadURI
                            , data: formData
                            , processData: false
                            , contentType: false
                            , success: function() {
                                var image = '<?php echo base_url("assets/files/'+ imageName +'"); ?>';
                                $('#event_pic').attr('src', image);
                                imageuploadsuccess = 1;
                                Materialize.toast('Image successfully uploaded', 4000);
                            }
                            , error: function(errorw){
                                Materialize.toast('Something went wrong. Please try again', 4000);
                            }
                        });
            }else{
              Materialize.toast('No image uploaded', 4000);
            }
        });

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
            var approve = 1;          
                  $.ajax({
                    type: 'POST',
                    url:'<?php echo base_url('insertPost');?>',
                    data : { id:id, text:text,datetime:datetime,image:image,file:file,approve:approve},
                    dataType : 'json',
                    success: function(data){
                      $(data).each(function(){
                        var href = '<?php base_url(); ?>'+ 'assets/images/' + this.accounts_picture;
                        var imageref = '<?php base_url(); ?>'+ 'assets/files/' + image;
                        var fileName = '<?php base_url(); ?>'+ 'assets/files/' + file;
                        var dis = '<?php base_url();?>'+'discuss/'+this.post_ID;
                        if(image == ''){
                          $('#grouppost').prepend($('<div id="profile-page-wall-post" class="card">'
                                +  '<div class="card-profile-title">'
                                +      '<div class="row">'
                                +          '<div class="col l1 s4">'
                                +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                +          '</div>'
                                +          '<div class="col l10 s8">'
                                +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+datetime+'</span>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +              '<p>'+text+'</p>'
                                +          '</div>'
                                +      '</div>'
                                +      '<div class="row">'
                                +          '<div class="col s12">'
                                +            '<a href="'+fileName+'" download>'+file+'</a>'
                                +          '</div>'
                                +      '</div>'
                                +        '<div class="row">'
                                +          '<div class="col s12">'
                                +            '<a href="'+dis+'" class="discussion-refresh btn red col s6" id="'+this.postIncreament+'">View Discussion</a>'
                                +          '</div>'
                                +        '</div>'
                                +  '</div>'            
                            +  '</div>'
                          ));
                        }else{
                           if(image.indexOf("mp4")>=0){
                            $('#grouppost').prepend($('<div id="profile-page-wall-post" class="card">'
                                      +  '<div class="card-profile-title">'
                                      +      '<div class="row">'
                                      +          '<div class="col l1 s4">'
                                      +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                      +          '</div>'
                                      +          '<div class="col l10 s8">'
                                      +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                      +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+datetime+'</span>'
                                      +          '</div>'
                                      +      '</div>'
                                      +        '<div class="row center-align">'
                                      +          '<div class="col s12">'
                                      +            '<video class="image_attached" controls>'
                                      +               '<source src="'+imageref+'" type="video/mp4" height="800px" width="800px">'
                                      +               'Your browser does not support the video tag.'
                                      +            '</video>'
                                      +          '</div>'  
                                      +      '</div>'
                                      +      '<div class="row">'
                                      +          '<div class="col s12">'
                                      +              '<p>'+text+'</p>'
                                      +          '</div>'
                                      +      '</div>'
                                      +      '<div class="row">'
                                      +          '<div class="col s12">'
                                      +            '<a href="'+fileName+'" download>'+file+'</a>'
                                      +          '</div>'
                                      +      '</div>'
                                      +        '<div class="row">'
                                      +                '<div class="col s12">'
                                      +            '<a href="'+dis+'" class="discussion-refresh btn red col s6" id="'+this.postIncreament+'">View Discussion</a>'
                                      +                '</div>'
                                      +         '</div>'
                                      +  '</div>'            
                                  +  '</div>'
                            ));
                           }else{
                            $('#grouppost').prepend($('<div id="profile-page-wall-post" class="card">'
                                      +  '<div class="card-profile-title">'
                                      +      '<div class="row">'
                                      +          '<div class="col l1 s4">'
                                      +             '<img src="'+href+'" alt="" class="circle responsive-img valign profile-post-uer-image">'                       
                                      +          '</div>'
                                      +          '<div class="col l10 s8">'
                                      +              '<p class="grey-text text-darken-4 margin">'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                                      +              '<span class="grey-text text-darken-1 ultra-small">Shared publicly  '+datetime+'</span>'
                                      +          '</div>'
                                      +      '</div>'
                                      +        '<div class="row center-align">'
                                      +          '<div class="col s12">'
                                      +            '<img class="Boxing" height="auto" width="100% "src="'+imageref+'">'
                                      +          '</div>'  
                                      +      '</div>'
                                      +      '<div class="row">'
                                      +          '<div class="col s12">'
                                      +              '<p>'+text+'</p>'
                                      +          '</div>'
                                      +      '</div>'
                                      +      '<div class="row">'
                                      +          '<div class="col s12">'
                                      +            '<a href="'+fileName+'" download>'+file+'</a>'
                                      +          '</div>'
                                      +      '</div>'
                                      +        '<div class="row">'
                                      +                '<div class="col s12">'
                                      +            '<a href="'+dis+'" class="discussion-refresh btn red col s6" id="'+this.postIncreament+'">View Discussion</a>'
                                      +                '</div>'
                                      +         '</div>'
                                      +  '</div>'            
                                  +  '</div>'
                            ));
                           }
                        }
                        $('#GroupPost').val('');
                        $('#Upload_Image').val('file name');
                        $('#upload_image_name').val('');
                        $('#attach_file_name').val('');
                        $('#attach_file').val('');
                        Materialize.updateTextFields();
                        Materialize.toast('Post Success!', 4000);
                      });
                    },error: function(errorw){
                          if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                                var json = $.parseJSON( errorw.responseText );
                              }
                              Materialize.toast(json, 4000);      
                    }
                 });
        });

          $('#createEvent').on('click',function(){
            var id = $('.grouppage-form').attr('id');
            var eventName = $('#event_name').val();
            var eventDescr = $('#suggestion').val();
            var eventDate = $('.datepicker').val() +" "+$('#eventtime').val();
            var accountid = $('#groupID').val();
            var eventpicture = $('#upload_image_name_event').val();

            if(imageuploadsuccess == 0){
              eventpicture = '';
            }

            if((eventDescr.trim()!=null)||(eventName.trim()!=null)||(eventDate.trim()!=null)){
              $.ajax({
                  type:"POST",
                  url:"<?php echo base_url('CreateEvent');?>",
                  data:{id:id, eventName:eventName,eventDescr:eventDescr,eventDate:eventDate,accountid:accountid,eventpicture:eventpicture},
                  dataType :"json",
                  success : function(data){
                    $(data).each(function(){
                      var imageref = '<?php base_url(); ?>'+ 'assets/files/' + eventpicture;
                      if(eventpicture == '' || eventpicture == null){
                        $('#eventsTab').prepend($('<div class="row">'
                        +  '<div class="col s12 z-depth-2">'
                        +      '<div class="card darken-1 z-depth-0">'
                        +          '<div class="card-content black-text center-align">'
                        +              '<h3>'+eventName+'</h3>'                                   
                        +          '</div>'
                        +          '<div class="card-action row">'
                        +              '<div class="col s12 center-align">'
                        +                  '<p>'+eventDescr+'</p>'
                        +              '  </div>'
                        +              '<div class="col s12">'
                        +                  '<p>Date of Event:'+eventDate+'</p>'
                        +              '</div>'
                        +              '<div class="col s12">'
                        +                  '<p>Posted By:'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
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
                          +              '<h3>'+eventName+'</h3>'                                   
                          +          '</div>'
                          +          '<div class="card-action row">'
                          +              '<div class="col s12 center-align">'
                          +                  '<p>'+eventDescr+'</p>'
                          +              '</div>'
                          +              '<div class="col s12 center-align">'
                          +                  '<img class="Boxing" height="auto" width="100%"  src="'+imageref+'">'
                          +             '</div>'
                          +              '<div class="col s12">'
                          +                  '<p>Date of Event:'+eventDate+'</p>'
                          +              '</div>'
                          +              '<div class="col s12">'
                          +                  '<p>Posted By:'+this.accounts_fname+'\t'+this.accounts_lname+'</p>'
                          +              '</div>' 
                          +          '</div>'
                          +      '</div>'
                          +   '</div>'
                          +  '</div>'
                        ));
                      }
                    });
                    $('#event_name').val('');
                    $('#suggestion').val('');
                    $('.datepicker').val('');
                    Materialize.updateTextFields();
                    Materialize.toast('Event Posted!', 4000);
                  },error:function(){
                    Materialize.toast('Something went wrong. Please try again', 4000);
                  }
              });
            }else{
              Materialize.toast('Fields Empty', 4000);
            }           
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
                                +            '<video height="auto" width="100% controls>'
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
                                +            '<img class="Boxing" height="auto" width="100% src="'+imageref+'">'
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
                          +                  '<img class="Boxing" height="auto" width="100% src="'+imageref+'">'
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

        $('.approvePost').on('click',function(){
          var postid = event.target.id;
          $.ajax({
            type:'POST',
            url:'<?php echo base_url('approvePost')?>',
            data:{postid:postid},
            success:function(){
              $('#'+postid).remove();
              Materialize.toast('Post Approve',4000);
            }
          });
        });

         $('#addMemberButton').on('click',function(){
          var search = $('#searchstudent').val();
          var groupID = $('#searchID').val();

          if(search.trim()!=''){
            $.ajax({
              type : "POST",
              url : "<?php echo base_url('addMember')?>",
              data : {search:search,groupID:groupID},
              dataType:'json',
              success : function(data){
                $(data).each(function(){
                  
                });
                $('#searchstudent').val('');
                Materialize.updateTextFields();
                Materialize.toast('Student Added!', 4000);
              },error : function(errorw){
                if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                  var json = $.parseJSON( errorw.responseText );
                }
                Materialize.toast(json, 4000);
              }
            });
          }else{
            Materialize.toast('Input Student ID',4000);
          }
        });

        $('#searchButton').on('click',function(){
          var search = $('#searchstudent').val();
          var groupID = $('#searchID').val();
          $('#previewForm').empty();
        
          if(search.trim()!=''){
            $.ajax({
              type : "POST",
              url : "<?php echo base_url('search')?>",
              data : {search:search,groupID:groupID},
              dataType:'json',
              success : function(data){
                console.log(data);
                $(data).each(function(){
                  var href = '<?php base_url(); ?>'+ 'assets/images/' + this.accounts_picture;
                  $('#previewForm').append($( '<div class="card-panel grey lighten-5 z-depth-1">'
                      +  '<div class="row valign-wrapper">'
                      +    '<div class="col s2">'
                      +      '<img src="'+href+'" alt="" class="circle responsive-img">'
                      +    '</div>'
                      +    '<div class="col s10">'
                      +      '<div class="col s12">'
                      +        '<span>'+this.accounts_fname+"\t"+this.accounts_lname+'</span>'
                      +      '</div>'
                      +      '<div class="col s12">'
                      +        '<span>'+this.course_abbv+'</span>'
                      +      '</div>'
                      +      '<div class="col s12">'
                      +        '<span>'+this.accounts_email+'</span>'
                      +      '</div>'
                      +    '</div>'
                      +  '</div>'
                      +'</div>'
                    ));          
                });
                Materialize.updateTextFields();
                Materialize.toast('Student Searched!', 4000);
              },error : function(errorw){
                if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                  var json = $.parseJSON( errorw.responseText );
                }
                $('#previewForm').empty();
                Materialize.toast(json, 4000);
              }
            });
          }else{
            Materialize.toast('Input Student ID',4000);
          }
        });
    });     
    </script>
</head>
<body> 
    <div class="container">
    <div class="fixed-action-btn">
            <a href="#student_tbl" id ="professorTool" class="btn-floating btn-large red tooltipped" data-position="left" data-delay="50" data-tooltip="Search/Add Member"><i class="large material-icons">library_add</i></a>
        </div>

        <div class="row"> 
            <ul class="tabs">
                <li class="tab col s3 "><a href="#post" id ="poster" class="black-text">Posts</a></li>
                <li class="tab col s3 "><a href="#eventsTab" id = "eventS" class="black-text">Events</a>
                </li>
                <li class="tab col s3 "><a href="#members" id ="membersTab" class="black-text">Members</a></li>
                <li class="tab col s3"><a href="#approve_tbl" id="approve" class="black-text">Approve Post Requests</a>
                </li>
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
                                <a href="#create_event" class="modal-trigger btn-floating btn-medium red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Create an event" ><i class="material-icons">assignment</i></a>
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
                                            <img class="Boxing image_attached" height="auto" width="100%" src="'.base_url('assets/files/'.$data->post_picture.'').'">
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
                                          <div class="col s1">
                                             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                       
                                          </div>
                                          <div class="col s10">
                                              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
                                              <span class="grey-text text-darken-1 ultra-small">Shared publicly  '.$data->post_date.'</span>
                                          </div>
                                      </div>
                                      <div class="row center-align">  
                                          <div class="col s6">
                                            <video width="100%" height="auto" controls>
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

          <div id="approve_tbl" class="row">
            <table class="responsive-table striped">
            <thead>
              <th>Posted by</th>
              <th>Post Attached Picture</th>
              <th>Post Attached File</th>
              <th>Post Content</th>
              <th>Approve Request</th>
            </thead>
            <tbody>
            <?php if(is_array($approve) || is_object($approve)){
              foreach ($approve as $approval) {
                if($approval->post_picture == '' || $approval->post_picture ==null){
                  echo '
                  <tr id="'.$approval->post_ID.'">
                  <td><p>'.$approval->accounts_fname."\t".$approval->accounts_lname.'</p></td>
                  <td><img class="Boxing" src="'.base_url('assets/files/noimages.png').'" height="50" width="60"></td>
                  <td><a href="#" download>No File Attached</a></td>
                  <td><p>'.$approval->post_content.'</p></td>
                  <td><a href="#" id="'.$approval->post_ID.'" class="approvePost"><i class="ultra-small material-icons">supervisor_account</i> Approve Request</a></td>
                  </tr>'
                  ;

                }else{
                  echo '
                  <tr id="'.$approval->post_ID.'">
                  <td><p>'.$approval->accounts_fname."\t".$approval->accounts_lname.'</p></td>
                  <td><img class="Boxing" src="'.base_url('assets/files/'.$approval->post_picture).'" height="50" width="60"></td>
                  <td><a href="'.base_url('assets/files/'.$approval->post_file.'').'" download>'.$approval->post_filename.'</a></td>
                  <td><p>'.$approval->post_content.'</p></td>
                  <td><a href="#" id="'.$approval->post_ID.'" class="approvePost"><i class="ultra-small material-icons">supervisor_account</i> Approve Request</a></td>
                  </tr>'
                  ;
                }
              }
            }
            ?>
            </tbody>
            </table>
          </div>
          <div id="create_event" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Create Event</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="hidden" id="groupID" value="<?php echo $userid?>">
                        <input id="event_name" type="text" class="">
                        <label for="event_name">Type Event Name</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="suggestion" class="materialize-textarea"></textarea>
                        <label for="suggestion">Event Description</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="date" class="datepicker">
                        <label for="date">Set Date</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="time" class="timepicker" id="eventtime">
                        <label for=""></label>
                    </div>
                    <div class="row file-field input-field col l6 s12">
                        <div class="file-path-wrapper">
                            <input class="file-path" id="upload_image_name_event" type="text">
                            <div class="btn red col s6">
                                <span>Attach Picture</span>
                                <input id="upload_image_input_event" name="upload_image_input_event" type="file">
                            </div>
                            <div class="col s6">
                                <a class="waves-effect waves-light btn red" id ="previewImage">Preview Image</a>
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <span>Image Preview</span><br>
                        <img src="" id = "event_pic" height="150" width="180">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
                <a href="#!" id = "createEvent" class=" modal-action modal-close waves-effect btn-flat">Create</a>
            </div>
        </div>

          <div id="attach_file" class="modal">
                <div class="modal-content">
                    <h4>Attach File</h4>
                    <div class="row">
                        <div class="file-field input field col s12">
                            <div class="btn red">
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
                        <div class="file-field input field col s12">
                            <div class="btn red">
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

           <div id="student_tbl" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4 class="flow-text">Students</h4> 
                <div class="row">
                    <div class="input-field col l6 s12">
                      <?php echo '<input type = "hidden" id ="searchID" value="'.$groupId.'">';?>
                      <input id="searchstudent" type="text" class="validate">
                      <label for="searchstudent">Type Student ID</label>
                     
                    </div>
                    <div class="col l12 s12">
                        <a id="searchButton" class="waves-effect btn-flat">Search</a>
                    </div>

                    <div id="previewForm" class="col s12">
                      
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect btn-flat">Close</a>
                <a id="addMemberButton" class="modal-action modal-close waves-effect btn-flat">Add Member</a>
            </div>
        </div>
    </div>
</body>
</html>