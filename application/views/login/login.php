<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">RPG Manager</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
			<?php
			if(!$this->session->userdata("isLoggedIn")){
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
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<legend>Please Sign In</legend>
				<?php
				//echo date("Y-m-d", strtotime((date("Y-m")."-01") . "+1 months"));
				if ($error=="error"){
				  echo '<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
				  </div>';
				}
				//$msg = 'boop';
				//echo $msg;
				//$encrypted_string = $this->encrypt->encode("0.5");
				//echo $encrypted_string;
				/*$unencrypted_string = $this->encrypt->decode($encrypted_string);
				echo $unencrypted_string;*/
				//echo password_hash("bewp",PASSWORD_DEFAULT);
				
				//form-inline
				echo form_open('login/login_user', 'class="form-inline"');
					//form-group
					echo '<div class="form-group">';
						echo '<div class="col-xs-2">';
							echo '<label class="sr-only" for="login">Login:</label>';
							$data = array('id'=>'login', 'name'=>'login', 'placeholder'=>'Login','class'=>'form-control');
							echo form_input($data);
						echo '</div>';
					echo '</div>';
					//form-group
					echo '<div class="form-group">';
						echo '<div class="col-xs-2">';
							echo '<label class="sr-only" for="password">Password:</label>';
							$data = array('id'=>'password', 'name'=>'password', 'placeholder'=>'Password', 'class'=>'form-control');
							echo form_password($data);
						echo '</div>';
					echo '</div>';
					echo '<div class="form-group">';
						echo '<div class="col-xs-2">';
							echo form_submit('login_user','Sign in','class="btn btn-default"');
						echo '</div>';
					echo '</div>';
				echo '</form>';
				?>
				<footer>
					<em>&copy; 2017</em>
				</footer>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
</body>