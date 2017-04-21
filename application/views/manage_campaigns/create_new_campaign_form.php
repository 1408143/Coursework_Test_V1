<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error: someone is trying to do bad things
			redirect('/login/logout_user_prejudice');
		break;
		
		//gm case
		case 1:
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
							<li class="active"><a href="<?php echo site_url();?>/manage_campaigns/index">Manage Campaigns</a></li>
							<li><a href="<?php echo site_url();?>/manage_account/index">Manage Account</a></li>
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
						echo form_open_multipart('manage_campaigns/create_new_campaign', 'class="form-group"');
							echo '<div class="col-md-4">';
								echo '<h3>Campaign </h3>';
							echo '</div>';
							echo '<div class="col-md-12"></div>';
							echo '<div class="col-md-4">';
								//form-group
								echo '<div class="form-group col-md-12">';
									echo form_error('campaignTitle');
									echo '<label class="sr-only" for="campaignTitle">Campaign Title:</label>';
									$data = array('id'=>'campaignTitle', 'name'=>'campaignTitle', 'placeholder'=>'Name','class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group col-md-12">';
									echo form_error('Players');
									echo '<label class="sr-only" for="player_dropdown">Select players:</label>';
									echo form_dropdown('player_dropdown', $player_dropdown,'default','class="form-control" id="player_dropdown"');
									echo'<ul id="player_list_visible" class="col-md-12"></ul>';
								echo '</div>';
								
								//form-group
								echo '<div class="form-group col-md-12">';
									echo '<label for="settingDocument">Setting Document</label>';
									echo form_error('settingDocument');
									echo '<label class="btn btn-default btn-file">
										<input type="file" name="settingDocument" id="settingDocument" value=""/>
									</label>';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-md-12"></div>';
							echo '<div class="col-md-4">';
								echo '<div class="form-group">';
									echo form_submit('create_new_campaign','Create','class="btn btn-default"');
									echo '<button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_campaigns/index'."'".'">Back</button>';
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