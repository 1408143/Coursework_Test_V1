<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error: someone is trying to do bad things
			redirect('/login/logout_user_prejudice');
		break;
		
		//admin case
		case 2:
		?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url();?>/main/index">Home</a></li>
						<li class="active"><a href="<?php echo site_url();?>/manage_characters/index">Manage Characters</a></li>
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
						echo form_open_multipart('manage_characters/modify_character', 'class="form-group"');
							echo '<div class="col-xs-4">';
								echo '<h3>Character Profile</h3>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo '<div class="col-xs-4">';
								//form-group
								echo '<div class="form-group">';
									echo form_error('charClass');
									echo '<label class="sr-only" for="charClass">Class:</label>';
									echo form_dropdown('charClass', $character_class_dropdown,$character_info["charClass"],'class="form-control" name="charClass" selected="warrior"');
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('charLevel');
									echo '<label class="sr-only" for="charLevel">Level:</label>';
									echo form_dropdown('charLevel', $character_level_dropdown,$character_info["charLevel"],'class="form-control" name="charLevel"');
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo form_error('');
									echo '<label for="characterPicture">Character Picture</label>';
									echo '<label class="btn btn-default btn-file">
										<input type="file" name="characterPicture" id="characterPicture" value=""/>
									</label>';
									if($character_info["characterPicture"]!=""){
										echo '<label for="characterPicture">Current setting document is: '.$character_info["characterPicture"].'</label>';
										echo '<br/><a href="'.site_url().'/main/download_character_picture/'.$character_info["characterPicture"].'" > Download File</a>';
									}
								echo '</div>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo '<div class="col-xs-4">';
								echo '<h3>Ability Scores</h3>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							
							echo '<div class="col-xs-3">';
								//form-group
								echo form_error('STR');
								echo form_error('DEX');
								echo form_error('CON');
							echo '</div>';
							echo '<div class="col-xs-3">';
								//form-group
								echo form_error('INT');
								echo form_error('WIS');
								echo form_error('CHA');
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo '<div class="col-xs-1">';
								//form-group
								echo '<div class="form-group">';
									echo '<label class="sr-only" for="STR">STR:</label>';
									$data = array('id'=>'STR', 'name'=>'STR', 'value'=>$character_info["STR"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group">';		
									echo '<label class="sr-only" for="DEX">DEX:</label>';
									$data = array('id'=>'DEX', 'name'=>'DEX', 'value'=>$character_info["DEX"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									
									echo '<label class="sr-only" for="CON">CON:</label>';
									$data = array('id'=>'CON', 'name'=>'CON', 'value'=>$character_info["CON"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
							echo '</div>';
							
							echo '<div class="col-xs-1">';
								//form-group
								echo '<div class="form-group">';
									echo '<label class="sr-only" for="INT">INT:</label>';
									$data = array('id'=>'INT', 'name'=>'INT', 'value'=>$character_info["INT"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo '<label class="sr-only" for="WIS">WIS:</label>';
									$data = array('id'=>'WIS', 'name'=>'WIS', 'value'=>$character_info["WIS"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
								//form-group
								echo '<div class="form-group">';
									echo '<label class="sr-only" for="CHA">CHA:</label>';
									$data = array('id'=>'CHA', 'name'=>'CHA', 'value'=>$character_info["CHA"],'class'=>'form-control');
									echo form_input($data);	
								echo '</div>';
							echo '</div>';
							echo '<div class="col-xs-12"></div>';
							echo form_hidden('charID', $character_info["charID"]);
							echo '<div class="col-xs-4">';
								echo '<div class="form-group">';
									echo form_submit('create_new_character','Modify','class="btn btn-default"');
									echo '<button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_characters/index'."'".'">Back</button>';
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