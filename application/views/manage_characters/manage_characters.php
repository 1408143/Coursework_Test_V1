<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error
			redirect('/login/index');
		break;
		
		//player case
		case 2:
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
				</div>
			</nav>
			<div class="container">
				<div class="row">
					<h1>Manage Characters</h1>
					<?php
						switch($success){
							default:
							break;
							
							case "create_character_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully created a new character.
									</div>';
							break;
							
							case "modify_character_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully modified a character\s profile.
									</div>';
							break;
							
							case "delete_character_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully deleted a character.
									</div>';
							break;
						}
					?>
					<button type="button" class="btn btn-default" onclick="location.href='<?php echo site_url();?>/manage_characters/create_new_character'">Create Character</button>
					<div class="col-md-12"></div>	
					<div class="col-md-6">
					<?php
						echo $table_characters;
					?>
					</div>
					
					<!-- Modal dialog -->
					<div id="deleteCharacterModal" class="modal fade" role="dialog">
					  <div class="modal-dialog modal-sm">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="deleteCharacterModalTitle">Delete User</h4>
						  </div>
						  <div class="modal-body">
							<p>Are you sure you want to delete this character?</p>
							<!-- <button id="deleteUserModalButton" type="button" class="btn btn-warning" onclick="location.href='<?php //echo site_url();?>/manage_users/delete_user'">Delete User</button>-->
							
							<?php
								echo form_open('manage_characters/delete_character').form_input(array('name' => 'deleteCharacterModalcharID', 'type'=>'hidden', 'id' =>'deleteCharacterModalcharID')).form_submit('delete_character','Delete Character','class="btn btn-warning"')."</form>";
							?>
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