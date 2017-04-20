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
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
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
			</nav>
			<div class="container">
				<div class="row">		
					<?php
						//form-inline
						echo form_open_multipart('manage_campaigns/modify_campaign', 'class="form-group"');
							echo '<div class="col-xs-4">';
								echo '<h3>Campaign</h3>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo '<div class="col-xs-4">';
								//form-group
								echo '<div class="form-group">';
									echo form_error('campaignTitle');
									echo '<label for="campaignTitle">Campaign Title:</label>';
									$data = array('id'=>'campaignTitle', 'name'=>'campaignTitle', 'value'=>$campaign_info["campaignTitle"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('Players');
									echo '<label for="player_dropdown">Select players:</label>';
									echo form_dropdown('player_dropdown', $player_dropdown,'default','class="form-control" id="player_dropdown"');
									echo'<ul id="player_list_visible" class="col-xs-12">';
									echo $player_character_list;
									echo'</ul>';
								echo '</div>';
							
								//form-group
								echo '<div class="form-group">';
									echo form_error('settingDocument');
									echo '<label for="settingDocument">Setting Document</label>';
									echo '<label class="btn btn-default btn-file">
										<input type="file" name="settingDocument" id="settingDocument" value=""/>
									</label>';
									echo '<label for="settingDocument">Current setting document is: '.$campaign_info["settingDocument"].'</label>';
									echo '<br/><a href="'.site_url().'/main/download_setting_document/'.$campaign_info["settingDocument"].'" > Download File</a>';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo form_hidden('campID', $campaign_info["campID"]);
							echo '<div class="col-xs-4">';
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