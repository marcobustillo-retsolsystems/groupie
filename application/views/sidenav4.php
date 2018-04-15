<!DOCTYPE html>
<html>
<head>
	<title>Groupie</title>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#adminpage").load("<?php echo base_url('administrator/initializeGraph');?>");
	});
	</script>
</head>
<body>
	<nav>  
		<div class="nav-wrapper">
	    	<div class="row">     
          		<div>
          			<a id="brandLogo "class="brand-logo center"><img src="<?php echo base_url();?>assets/images/logo1.jpg" height="64" width="70"></a>	
          		</div>		 
          		<div class="col s4 offset-s8">
          			<ul id="nav-mobile" class="right">		 
  		        		<li><a href="<?php echo base_url('Login/logout');?>">Log Out</a></li>          
		    		</ul>
              	</div>
		    </div>     		 
	    </div>
	</nav>
	<div id="adminpage">
	</div>

</body>
</html>