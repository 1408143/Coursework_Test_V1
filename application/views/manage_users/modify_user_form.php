<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error: someone is trying to do bad things
			redirect('/login/logout_user_prejudice');
		break;
		
		//admin case
		case 0:
		?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li><a href="<?php echo site_url();?>/main/index">Home</a></li>
							<li class="active"><a href="<?php echo site_url();?>/manage_users/index">Manage Users</a></li>
							<!-- <li><a href="#">Manage Campaigns</a></li>
							<li><a href="#">Manage Characters</a></li> -->
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
				</div>
			</nav>
			<div class="container">
				<div class="row">		
					<?php
						//form-inline
						echo form_open('manage_users/modify_user', 'class="form-group"');
							echo '<div class="col-md-4">';
							echo '<h3>Change password</h3>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('password');
									echo '<label class="sr-only" for="password">Password:</label>';
									$data = array('id'=>'password', 'name'=>'password', 'placeholder'=>'Password', 'class'=>'form-control');
									echo form_password($data);
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('password_verify');
									echo '<label class="sr-only" for="password">Enter password again:</label>';
									$data = array('id'=>'password_verify', 'name'=>'password_verify', 'placeholder'=>'Confirm Password', 'class'=>'form-control');
									echo form_password($data);
								echo '</div>';
								echo form_hidden('userID', $user_info['userID']);
								echo form_hidden('form_type', 'password');
								//form-group
								echo '<div class="form-group">';
									echo form_submit('modify_user_password','Modify','class="btn btn-default"');
									echo '<button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_users/index'."'".'">Back</button>';
								echo '</div>';
							echo '</div>';
						echo '</form>';
						//form-inline
						echo '<div class="col-md-12"></div>';
						echo form_open('manage_users/modify_user', 'class="form-group"');
							echo '<div class="col-md-4">';
							echo '<h3>Change user information</h3>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('fname');
									if($user_info['fname']==""){
										echo '<label class="sr-only" for="fname">First name:</label>';
										$data = array('id'=>'fname', 'name'=>'fname', 'placeholder'=>'First Name', 'class'=>'form-control');
									}else{
										echo '<label for="fname">First name:</label>';
										$data = array('id'=>'fname', 'name'=>'fname', 'value'=>$user_info['fname'], 'class'=>'form-control');
									}
									echo form_input($data);
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('lname');
									if($user_info['lname']==""){
										echo '<label class="sr-only" for="lname">Last Name:</label>';
										$data = array('id'=>'lname', 'name'=>'lname', 'placeholder'=>'Last Name', 'class'=>'form-control');
									}else{
										echo '<label for="lname">Last Name:</label>';
										$data = array('id'=>'lname', 'name'=>'lname', 'value'=>$user_info['lname'], 'class'=>'form-control');
									}
									echo form_input($data);
								echo '</div>';
								echo '<div class="form-group">';
									echo form_error('email');
									if($user_info['email']==""){
										echo '<label class="sr-only" for="email">Email address:</label>';
										echo '<span class="label label-warning">If the email is not set, there can be no password recovery.</span>';
										$data = array('id'=>'email', 'name'=>'email', 'placeholder'=>'Email', 'class'=>'form-control');
									}else{
										echo '<label for="email">Email address:</label>';
										$data = array('id'=>'email', 'name'=>'email', 'value'=>$user_info['email'], 'class'=>'form-control');
									}
									echo form_input($data);
								echo '</div>';
								echo form_hidden('userID', $user_info['userID']);
								echo form_hidden('form_type', 'user_info');
								//form-group
								echo '<div class="form-group">';
									echo form_submit('modify_user_info','Modify','class="btn btn-default"');
									echo '<button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_users/index'."'".'">Back</button>';
								echo '</div>';
							echo '</div>';
						echo '</form>';
					?>
				</div>
			</div>
	<?php
		break;
	}
	?>
</body>