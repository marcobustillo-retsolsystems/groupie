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

  	<script>
  			
  			$('#writecomment').keypress(function(event) {
  			var keycode = event.keyCode || event.which;
		    if(keycode == '13') {
		    	var postid = $('.container').attr('id');
		    	var comment = $('#writecomment').val();
		    	var currentdate = new Date(); 
            	var datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getDate() + " "  
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();

		    	$.ajax({
		    		type:'POST',
		    		url:'<?php echo base_url('insertComment');?>',
		    		data:{postid:postid,comment:comment,datetime:datetime},
		    		dataType:'json',
		    		success:function(data){
		    			$(data).each(function(){
		    				 var href = '<?php base_url(); ?>'+ 'assets/images/' + this.accounts_picture;
		    				$('#commentsection').prepend($(
		    					'<div class="col s12">'
						        +	'<div class="card-panel">'
								+        '<div class="card-panel grey lighten-5 z-depth-1">'
								+          	'<div class="row valign-wrapper">'
								+            	'<div class="col s1">'
								+              	'<img src="'+href+'" alt="" class="circle responsive-img comment_img">'  
								+            	'</div>'
								+            	'<div class="col s11">'
								+              		'<div class="col s12">'
								+              			'<p>'+this.accounts_fname+'\t'+this.accounts_lname+' says:</p>'
								+                       '<span class="grey-text text-darken-1 ultra-small">'+datetime+'</span>'
								+              		'</div>'
								+              		'<div class="col s12">'
								+              			'<p>'+comment+'</p>'	
								+              		'</div>'
								+            	'</div>'
								+          	'</div>'
								+        '</div>'								        
						        +	'</div>'
						      	+'</div>'
		    				));
		    				$('#writecomment').val('');
		    				Materialize.updateTextFields();
		    				Materialize.toast('Comment Posted !', 4000);
		    			});
		    		},error:function(errorw){
		    			if( errorw.status == 400 ) { //Validation error or other reason for Bad Request 400
                            var json = $.parseJSON( errorw.responseText );
                          }
                          Materialize.toast(json, 4000);
		    		}
		    	});
		    }
		    	
		});
  	</script>
</head>
<body>
	<div class="container" id ="<?php echo $postid;?>">
	<?php
	if(is_array($post) || is_object($post)){
		foreach($post as $data){
			if($data->post_picture == ''){
				echo'
				<div id="profile-page-wall-post" class="card">
					<div class="card-profile-title">
					      <div class="row">
					          <div class="col l1 s4">
					             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'"  alt="" class=" circle responsive-img valign profile-post-uer-image">
					          </div>
					          <div class="col l10 s8">
					              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
					              <span class="grey-text text-darken-1 ultra-small">'.$data->post_date.'</span>
					          </div>
					      </div>
					      <div class="row">
					          <div class="col s12">
					              <p>'.$data->post_content.'</p>
					          </div>
					      </div>
					      <div class="row">
					          <div class="col s12">
					            <a href="'.$data->post_file.'">'.$data->post_filename.'</a>
					          </div>
					      </div>
				</div>';
			}
			else{
				echo'
				<div id="profile-page-wall-post" class="card">
					<div class="card-profile-title">
					      <div class="row">
					          <div class="col s1">
					             <img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class=" circle responsive-img valign profile-post-uer-image">
					          </div>
					          <div class="col s10">
					              <p class="grey-text text-darken-4 margin">'.$data->accounts_fname."\t".$data->accounts_lname.'</p>
					              <span class="grey-text text-darken-1 ultra-small">'.$data->post_date.'</span>
					          </div>
					      </div>
					      <div class="row center-align">  
					          <div class="col s12">
					            <img class="materialboxed image_attached" height="auto" width="100%" data-caption="'.$data->post_content.'" src="'.base_url('assets/files/'.$data->post_picture.'').'">
					          </div>  
					      </div>
					      <div class="row">
					          <div class="col s12">
					              <p>'.$data->post_content.'</p>
					          </div>
					      </div>
					      <div class="row">
					          <div class="col s12">
					            <a href="'.$data->post_file.'">'.$data->post_filename.'</a>
					          </div>
					      </div>
				</div>';
			}
		}
	}
	?>

	<?php
	echo '<div class="col s12">
			    <div class="card-panel">  
			      <div class="row valign-wrapper">
			        <div class="col s1">
			          <img src="'.base_url('assets/images/'.$details->accounts_picture.'').'" alt="" class="write_comment_img circle responsive-img">
			        </div>
			        <div class="input-field col s11">
			            <input id="writecomment" type="text" class="validate">
			            <label for="writecomment">Write a Comment</label>
			        </div>  
			      </div>
			    </div>
			</div>';
	?>
			<div class="row" id="commentsection">
			<?php
			if(is_array($comments) || is_object($comments)){
				foreach ($comments as $data) {
					echo'
					<div class="col s12">
			        	<div class="card-panel">
					        <div class="card-panel grey lighten-5 z-depth-1">
					          	<div class="row valign-wrapper">
					            	<div class="col s1">
					              		<img src="'.base_url('assets/images/'.$data->accounts_picture.'').'" alt="" class="circle responsive-img comment_img">  
					            	</div>
					            	<div class="col s11">
					              		<div class="col s12">
					              			<p>'.$data->accounts_fname."\t".$data->accounts_lname.' says:</p>
					              			 <span class="grey-text text-darken-1 ultra-small">'.$data->comments_date.'</span>
					              		</div>
					              		<div class="col s12">
					              			<p>'.$data->comments_content.'</p>	
					              		</div>
					            	</div>
					          	</div>
					        </div>				       
			        	</div>
				    </div>
				';
			}
		}				
		?>	    
		    </div>
    	</div>
	</div>
	
</body>
</html>