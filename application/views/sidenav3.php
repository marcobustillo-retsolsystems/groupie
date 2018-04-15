<!DOCTYPE html>
<html>
<head>
	<title>Groupie</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#tracerpage").load("<?php echo base_url('surveycontroller/loadTracer');?>");
		});

	</script>
</head>
<body>
	<nav>
	    <div class="nav-wrapper">
	        <span class="brand-logo center">Graduates Tracer</span>
	        <ul id="nav-mobile" class="left hide-on-med-and-down">
	            <li class="college_label"><span class="flow-text"><?php echo $details->college_fullName;?> &nbsp;</span></li>
	        </ul>
	    </div>
	</nav>

	<div id="tracerpage">
	</div>

</body>
</html>