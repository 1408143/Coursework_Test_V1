<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error
			redirect('/login/index');
		break;
		
		//admin case
		case 0:
		?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url();?>/main/index">Home</a></li>
						<li class="active"><a href="<?php echo site_url();?>/manage_users/index">Manage Users</a></li>
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
							
							case "new_user_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully added a user account to the database.
									</div>';
							break;
							
							case "modify_user_password_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully changed a user\'s password.
									</div>';
							break;
							
							case "modify_user_info_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully modified a user account\'s information.
									</div>';
							break;
						}
					?>
					<button type="button" class="btn btn-default" onclick="location.href='<?php echo site_url();?>/manage_users/create_new_user'">Create User</button>
					<div class="col-xs-12"></div>	
					<div class="col-xs-6">
						<h3>Game Masters</h3>
					</div>
					<div class="col-xs-6">
						<h3>Players</h3>
					</div>
					<div class="col-xs-6">
					<?php
						echo $table_game_masters;
					?>
					</div>
					<div class="col-xs-6">
					<?php
						echo $table_players;
					?>
					</div>
					
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
							<?php
								echo form_open('manage_users/delete_user').form_input(array('name' => 'deleteUserModaluserID', 'type'=>'hidden', 'id' =>'deleteUserModaluserID')).form_submit('delete_user','Delete User','class="btn btn-warning"')."</form>";
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