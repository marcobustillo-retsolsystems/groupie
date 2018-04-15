<!DOCTYPE html>
<html>
<head>
	<title>News Feed</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
</head>
<body>
	<div id="UpdateStatus" class="tab-content col s12  grey lighten-4">
                      <div class="row">
                        <div class="col s2">
                          <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image-post">
                        </div>
                        <div class="input-field col s10">
                          <textarea id="textarea" row="2" class="materialize-textarea" style="height: 22px;"></textarea>
                          <label for="textarea" class="">What's on your mind?</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s12 m6 share-icons">
                          <a href="#"><i class="mdi-image-camera-alt"></i></a>
                          <a href="#"><i class="mdi-action-account-circle"></i></a>
                          <a href="#"><i class="mdi-hardware-keyboard-alt"></i></a>
                          <a href="#"><i class="mdi-communication-location-on"></i></a>
                        </div>
                        <div class="col s12 m6 right-align">
                           <!-- Dropdown Trigger -->
                            <a class="dropdown-button btn" href="#" data-activates="profliePost"><i class="mdi-action-language"></i> Public</a><ul id="profliePost" class="dropdown-content">
                              <li><a href="#!"><i class="mdi-action-language"></i> Public</a></li>
                              <li><a href="#!"><i class="mdi-action-face-unlock"></i> Friends</a></li>                              
                              <li><a href="#!"><i class="mdi-action-lock-outline"></i> Only Me</a></li>
                            </ul>

                            <!-- Dropdown Structure -->
                            

                            <a class="waves-effect waves-light btn"><i class="mdi-maps-rate-review left"></i>Post</a>
                        </div>
                      </div>
                    </div>
</body>
</html>