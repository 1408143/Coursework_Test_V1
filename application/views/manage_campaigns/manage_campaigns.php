<body>
<?php
	switch($this->session->userdata('userClass')){
		default:
			//this is an error
			redirect('/login/index');
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
						switch($success){
							default:
							break;
							
							case "create_campaign_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully created a new campaign.
									</div>';
							break;
							
							case "modify_campaign_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully modified a campaign.
									</div>';
							break;
							
							case "delete_campaign_success":
								echo '<div class="alert alert-success">
										<a class="close" data-dismiss="alert" href="#">×</a>You have successfully deleted a campaign.
									</div>';
							break;
						}
					?>
					<button type="button" class="btn btn-default" onclick="location.href='<?php echo site_url();?>/manage_campaigns/create_new_campaign'">Create Campaign</button>
					<div class="col-xs-12"></div>	
					<div class="col-xs-6">
						<h3>Your Campaigns</h3>
					</div>
					<div class="col-xs-12"></div>
					<div class="col-xs-8">
					<?php
						echo $table_gm_campaigns;
					?>
					</div>
					
					<!-- Modal dialog -->
					<div id="deleteCampaignModal" class="modal fade" role="dialog">
					  <div class="modal-dialog modal-sm">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="deleteCampaignModalTitle">Delete User</h4>
						  </div>
						  <div class="modal-body">
							<p>Are you sure you want to delete this campaign?</p>
							<!-- <button id="deleteUserModalButton" type="button" class="btn btn-warning" onclick="location.href='<?php //echo site_url();?>/manage_users/delete_user'">Delete User</button>-->
							
							<?php
								echo form_open('manage_campaigns/delete_campaign').form_input(array('name' => 'deleteCampaignModalcampID', 'type'=>'hidden', 'id' =>'deleteCampaignModalcampID')).form_submit('delete_campaign','Delete Campaign','class="btn btn-warning"')."</form>";
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