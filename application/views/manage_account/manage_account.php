<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error
			redirect('/login/index');
		break;
		
		//player case
		case 1:
		?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url();?>/main/index">Home</a></li>
						<li><a href="<?php echo site_url();?>/manage_characters/index">Manage Characters</a></li>
						<li class="active"><a href="<?php echo site_url();?>/manage_account/index">Manage Account</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<?php
					if(!$this->session->userdata("userID")){
						echo '<li><a href="'.site_url('login/login_user').'"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
					}else{
						echo '<li><a href="'.site_url('login/logout_user').'"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>';
					}
						
					?>
					</ul>
				</div>
			</nav>
			<div class="container">
				<div class="row">
					<?php
						switch($success){
							default:
							break;
							
							case "modify_user_password_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully changed your password.
									</div>';
							break;
							
							case "modify_user_info_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully modified your account\'s information.
									</div>';
							break;
						}
					?>
					<div class="col-xs-6">
						<h3>Your Account</h3>
						<?php
						echo "<p>Your username is ".ucfirst($user_info->username).".</p>";
						echo "<p>You registered on the ".date('d-m-Y', $user_info->registerDate).".";
						if($user_info->fname!="" || $user_info->lname!=""){
							echo "<p> You've identified yourself as ".ucfirst($user_info->fname)." ".ucfirst($user_info->lname)."</p>";
						}else{
							echo "<p>You haven't given us your first or last name.</p>";
						}
						if($user_info->email!=""){
							echo "<p> Your email address is ".$user_info->email."</p>";
						}else{
							echo "<p>You haven't given us your email</p>";
						}
						?>
					</div>
					<div class="col-xs-12">
					<button type="button" class="btn btn-default" onclick="location.href='<?php echo site_url();?>/manage_account/modify_account'">Modify Account</button>
					<!-- Modal dialog -->
					<div id="deleteUserModal" class="modal fade" role="dialog">
					  <div class="modal-dialog modal-sm">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="deleteUserModalTitle">Delete User</h4>
						  </div>
						  <div class="modal-body">
							<p>Are you sure you want to delete this user?</p>
							<button id="deleteUserModalButton" type="button" class="btn btn-warning" onclick="location.href='<?php echo site_url();?>/manage_users/delete_user'">Delete User</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						  <div class="modal-footer"></div>
						</div>
					  </div>
					</div>
					
				</div>
			</div>
		<?php
	
		break;
		
		//player case
		case 2:
		?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url();?>/main/index">Home</a></li>
						<li><a href="<?php echo site_url();?>/manage_characters/index">Manage Characters</a></li>
						<li class="active"><a href="<?php echo site_url();?>/manage_account/index">Manage Account</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<?php
					if(!$this->session->userdata("userID")){
						echo '<li><a href="'.site_url('login/login_user').'"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
					}else{
						echo '<li><a href="'.site_url('login/logout_user').'"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>';
					}
						
					?>
					</ul>
				</div>
			</nav>
			<div class="container">
				<div class="row">
					<?php
						switch($success){
							default:
							break;
							
							case "modify_user_password_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully changed your password.
									</div>';
							break;
							
							case "modify_user_info_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully modified your account\'s information.
									</div>';
							break;
						}
					?>
					<div class="col-xs-6">
						<h3>Your Account</h3>
						<?php
						echo "<p>Your username is ".ucfirst($user_info->username).".</p>";
						echo "<p>You registered on the ".date('d-m-Y', $user_info->registerDate).".";
						if($user_info->fname!="" || $user_info->lname!=""){
							echo "<p> You've identified yourself as ".ucfirst($user_info->fname)." ".ucfirst($user_info->lname)."</p>";
						}else{
							echo "<p>You haven't given us your first or last name.</p>";
						}
						if($user_info->email!=""){
							echo "<p> Your email address is ".$user_info->email."</p>";
						}else{
							echo "<p>You haven't given us your email</p>";
						}
						?>
					</div>
					<div class="col-xs-12">
					<button type="button" class="btn btn-default" onclick="location.href='<?php echo site_url();?>/manage_account/modify_account'">Modify Account</button>
					<!-- Modal dialog -->
					<div id="deleteUserModal" class="modal fade" role="dialog">
					  <div class="modal-dialog modal-sm">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="deleteUserModalTitle">Delete User</h4>
						  </div>
						  <div class="modal-body">
							<p>Are you sure you want to delete this user?</p>
							<button id="deleteUserModalButton" type="button" class="btn btn-warning" onclick="location.href='<?php echo site_url();?>/manage_users/delete_user'">Delete User</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						  <div class="modal-footer"></div>
						</div>
					  </div>
					</div>
					
				</div>
			</div>
		<?php
	
		break;
	}
?>
</body>