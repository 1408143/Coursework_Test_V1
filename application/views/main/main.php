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
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li class="active"><a href="<?php echo site_url();?>/main/index">Home</a></li>
							<li><a href="<?php echo site_url();?>/manage_users/index">Manage Users</a></li>
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
					<h1>Admin Console</h1>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#accounts">Accounts</a></li>
					</ul>

					<div class="tab-content">
						<div id="accounts" class="tab-pane fade in active">
							<div class="col-xs-8">
							<?php
								echo $table;
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	
		break;
		
		//game master case
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
							<li class="active"><a href="<?php echo site_url();?>/main/index">Home</a></li>
							<li><a href="<?php echo site_url();?>/manage_campaigns/index">Manage Campaigns</a></li>
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
					<h1>Game Master Console</h1>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#campaigns">Campaigns</a></li>
					</ul>

					<div class="tab-content">
						<div id="campaigns" class="tab-pane fade in active">
							<div class="col-md-8">
							<?php
								echo $table;
							?>
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
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					  </button>
						<a class="navbar-brand" href="#">RPG Manager</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li class="active"><a href="<?php echo site_url();?>/main/index">Home</a></li>
							<li><a href="<?php echo site_url();?>/manage_characters/index">Manage Characters</a></li>
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
					<h1>Player Console</h1>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#characters">Characters</a></li>
						<li><a data-toggle="tab" href="#campaigns">Campaigns</a></li>
					</ul>

					<div class="tab-content">
						<div id="characters" class="tab-pane fade in active">
							<div class="col-xs-8">
								<?php
									echo $table;
								?>
							</div>
						</div>
						<div id="campaigns" class="tab-pane fade">
							<div class="col-xs-8">
								<?php
									echo $table_campaigns;
								?>
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