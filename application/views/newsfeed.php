<!DOCTYPE html>
<html>
<head>	 
	<link rel="stylesheet" href= "<?php echo base_url('assets/css/newsfeed.css');?>"> 
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
  <script type="text/javascript">
    $(document).ready(function(){
        $('a.groupname').on('click', function(event){
          event.preventDefault();
          var href = $(this).attr('href');
          $('#userpage').empty();
          $('#userpage').load(href);
         $("#sidenav-overlay").trigger("click");
        });

        $('.materialboxed').materialbox();

          $('a.discussion').on('click', function(event){
          event.preventDefault();
          var href = $('#' + event.target.id).attr('href');
          $('#userpage').empty();
          $('#userpage').load(href);
          });
    });
  </script>
</head>
<body>

    <div class="container">
    <?php
    if(is_array($init) || is_object($init)){
    foreach($init as $data){
        if($data->post_picture ==''){
          echo'
          <div id="profile-page-wall-post" class="card z-depth-4">
            <div class="card-profile-title">
              <div class="row">
                <div class="col s1">  
                  <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                        
                </div>
                <div class="col s10">
                  <a href="#!" class=" btn-floating white"><i class="grey medium material-icons prefix">supervisor_account</i>
                  <a href="'.base_url('groups/'.$data->groups_ID.'').'" class="groupname black-text"> &nbsp'.$data->groups_Name.'</a>
                  <p class="grey-text text-darken-4 margin">'.$data->accounts_fname. "\t" . $data->accounts_lname .'</p> 
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
                    <a href="'.base_url('discuss/'.$data->post_ID.'').'" class="discussion btn red col s6" id="'.$data->post_ID.'" >View Discussion</a>
                  </div>
                </div>
            </div>
          </div>
          ';
        }else{
          if(strpos($data->post_picture, 'mp4') ===false){
          echo'
            <div id="profile-page-wall-post" class="card z-depth-4">
              <div class="card-profile-title">
                <div class="row">
                  <div class="col s1">  
                    <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                        
                  </div>
                  <div class="col s10">
                    <a href="#!" class=" btn-floating white"><i class="grey medium material-icons prefix">supervisor_account</i>
                    <a href="'.base_url('groups/'.$data->groups_ID.'').'"class="groupname black-text"> &nbsp'.$data->groups_Name.'</a>
                    <p class="grey-text text-darken-4 margin">'.$data->accounts_fname. "\t" . $data->accounts_lname .'</p> 
                    <span class="grey-text text-darken-1 ultra-small">Shared publicly  '.$data->post_date.'</span>
                  </div>
                </div> 
                <div class="row center-align">
                  <div class="col s6">
                    <img class="materialboxed image_attached" data-caption="'.$data->post_content.'" src="'.base_url('assets/files/'.$data->post_picture.'').'">
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
          echo'
            <div id="profile-page-wall-post" class="card z-depth-4">
              <div class="card-profile-title">
                <div class="row">
                  <div class="col s1">  
                    <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img valign profile-post-uer-image">                        
                  </div>
                  <div class="col s10">
                    <a href="#!" class=" btn-floating white"><i class="grey medium material-icons prefix">supervisor_account</i>
                    <a href="'.base_url('groups/'.$data->groups_ID.'').'"class="groupname black-text"> &nbsp'.$data->groups_Name.'</a>
                    <p class="grey-text text-darken-4 margin">'.$data->accounts_fname. "\t" . $data->accounts_lname .'</p> 
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
<div id='userpage'>
</div>
</body>
</html>