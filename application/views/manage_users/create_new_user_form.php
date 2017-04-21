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
						echo form_open('manage_users/create_new_user', 'class="form-group"');
							echo '<div class="col-md-4">';
							echo '<h3>Create a new user</h3>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('username');
									echo '<label class="sr-only" for="username">Username:</label>';
									$data = array('id'=>'username', 'name'=>'username', 'placeholder'=>'Username','class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
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
									echo '<label class="sr-only" for="password_verify">Enter password again:</label>';
									$data = array('id'=>'password_verify', 'name'=>'password_verify', 'placeholder'=>'Confirm Password', 'class'=>'form-control');
									echo form_password($data);
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('user_class');
									echo '<label class="sr-only" for="user_class">Select user class:</label>';
									echo form_dropdown('user_class', $user_class_dropdown,'','class="form-control" name="user_class"');
								echo '</div>';
								echo '<div class="form-group">';
									echo form_submit('create_new_user','Create','class="btn btn-default"');
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