<?php
	class table_m extends CI_Model {
		
		
		
		public function __construct(){
			parent::__construct();
			$this->load->model('query_m');
			$this->load->library('encrypt');
		}
		
		function set_table_template($table_type){
			//create table and template
				$tmpl = array (
                    'table_open'          => '<table id="table" summary="'.$table_type.'" class="table table-striped">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
				);
				$this->table->set_template($tmpl);
		}
		
		//main rendering function that catches and sorts all table types
		function table_render($table_type){
			switch ($table_type){
				default:
					$table=null;
				break;
				
				case "all_non_admin_users_table":
					$query=$this->query_m->fetch_all_non_admin_users_and_user_info_query();
					$table= $this->table_m->fill_table_all_non_admin_users($query,$table_type);//pass table through data variable
				break;
				
				case "all_non_game_masters_table_modify":
					$query=$this->query_m->fetch_all_game_master_users_query();
					$table= $this->table_m->fill_table_all_non_admin_users_modify($query,$table_type);//pass table through data variable
				break;
				
				case "all_non_players_table_modify":
					$query=$this->query_m->fetch_all_player_users_query();
					$table= $this->table_m->fill_table_all_non_admin_users_modify($query,$table_type);//pass table through data variable
				break;
				
				case "table_player_characters":
					$query=$this->query_m->fetch_all_characters_for_userID_query($this->session->userdata("userID"));
					$table= $this->table_m->fill_table_all_characters($query,$table_type);//pass table through data variable
				break;
				
				case "table_player_characters_modify":
					$query=$this->query_m->fetch_all_characters_for_userID_query($this->session->userdata("userID"));
					$table= $this->table_m->fill_table_all_characters_modify($query,$table_type);//pass table through data variable
				break;
				
				case "table_player_campaigns":
					$query=$this->query_m->fetch_campaigns_for_player_query($this->session->userdata("userID"));
					$table= $this->table_m->fill_table_player_campaigns($query,$table_type);//pass table through data variable
				break;
				
				case "table_gm_campaigns":
					$query=$this->query_m->fetch_all_campaigns_for_userID_query($this->session->userdata("userID"));
					$table= $this->table_m->fill_table_all_campaigns($query,$table_type);//pass table through data variable
				break;
				
				case "table_gm_campaigns_modify":
					$query=$this->query_m->fetch_all_campaigns_for_userID_query($this->session->userdata("userID"));
					$table= $this->table_m->fill_table_all_campaigns_modify($query,$table_type);//pass table through data variable
				break;
			}
			return $table;
		}
		
		function fill_table_all_non_admin_users($query, $table_type) {
			$userClassList=array(0 => 'Administrator', 1 => 'Game Master', 2 => 'Player');
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>User ID</center>", "<center>User Class</center>", "<center>Username</center>", "<center>First Name</center>", "<center>Last Name</center>", "<center>Email</center>", "<center>Last Connected (GMT)</center>");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				unset($columns);
				$columns[]="<center>".$row->userID."</center>";
				$columns[]="<center>".$userClassList[$row->userClass]."</center>";
				$columns[]="<center>".ucfirst($row->username)."</center>";
				if($row->fname!=""){
					$columns[]="<center>".ucfirst($row->fname)."</center>";
				}else{
					$columns[]="<center>None entered</center>";
				}
				if($row->lname!=""){
					$columns[]="<center>".ucfirst($row->lname)."</center>";
				}else{
					$columns[]="<center>None entered</center>";
				}
				if($row->email!=""){
					$columns[]="<center>".$row->email."</center>";
				}else{
					$columns[]="<center>None entered</center>";
				}
				if($row->lastConnection!=0){
					$columns[]="<center>".date('Y-m-d H:i:s', $row->lastConnection)."</center>";
				}else{
					$columns[]="<center>Has yet to connect</center>";
				}
				
				$this->table->add_row($columns);
			}
			return $this->table->generate();
		}
		
		function fill_table_all_non_admin_users_modify($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>User ID</center>", "<center>Username</center>", "<center>Last Connected (GMT) </center>","","");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				unset($columns);
				$columns[]="<center>".$row->userID."</center>";
				$columns[]="<center>".ucfirst($row->username)."</center>";
				if($row->lastConnection!=0){
					$columns[]="<center>".date('Y-m-d H:i:s', $row->lastConnection)."</center>";
				}else{
					$columns[]="<center>Has yet to connect</center>";
				}
				//'<center> <button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_users/modify_user/'.$row->userID."'".'">Modify User</button> </center>',
				$columns[]='<center>'.form_open('manage_users/modify_user').form_hidden('userID',$row->userID).form_submit('modify_user','Modify User','class="btn btn-default"').'</form></center>';
				$columns[]='<center><button type="button" class="btn btn-default" data-toggle="modal" data-target="#deleteUserModal" data-userid="'.$row->userID.'">Delete User</button></center>';
				/*'<center> <button type="button" class="btn btn-default" onclick="location.href='."'".site_url().'/manage_users/create_new_user/'.$row->userID."'".'">Delete User</button> </center>'*/
				$this->table->add_row($columns);
				
			}
			return $this->table->generate();
		}
		
		function fill_table_all_characters($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("","<center>Name</center>", "<center>Level</center>", "<center>Race</center>", "<center>Gender</center>","<center>Class</center>","<center>STR</center>","<center>DEX</center>","<center>CON</center>","<center>INT</center>","<center>WIS</center>","<center>CHA</center>","");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				if($row->characterPicture!=""){
					$this->table->add_row('<img src = "'.base_url().'./uploads/characterPictures/'.$row->characterPicture.'" class="img-responsive"/>',
					"<center>".ucfirst($row->charName)."</center>",
					'<center>'.ucfirst($row->charLevel).'</center>',
					"<center>".ucfirst($row->charRace)."</center>",
					'<center>'.ucfirst($row->charGender).'</center>',
					'<center>'.ucfirst($row->charClass).'</center>',
					'<center>'.$row->STR.'</center>',
					'<center>'.$row->DEX.'</center>',
					'<center>'.$row->CON.'</center>',
					'<center>'.$row->INT.'</center>',
					'<center>'.$row->WIS.'</center>',
					'<center>'.$row->CHA.'</center>',
					'<center><a href="'.site_url().'/pdf/index/'.$row->charID.'"> Download File</a></center>');
				}else{
					$this->table->add_row('<img src = "'.base_url().'./uploads/characterPictures/no-profile-image.jpg" class="img-responsive"/>',
					"<center>".ucfirst($row->charName)."</center>",
					'<center>'.ucfirst($row->charLevel).'</center>',
					"<center>".ucfirst($row->charRace)."</center>",
					'<center>'.ucfirst($row->charGender).'</center>',
					'<center>'.ucfirst($row->charClass).'</center>',
					'<center>'.$row->STR.'</center>',
					'<center>'.$row->DEX.'</center>',
					'<center>'.$row->CON.'</center>',
					'<center>'.$row->INT.'</center>',
					'<center>'.$row->WIS.'</center>',
					'<center>'.$row->CHA.'</center>',
					'<center><a href="'.site_url().'/pdf/index/'.$row->charID.'"> Download File</a></center>');
				}
				
			}
			return $this->table->generate();
		}
		
		function fill_table_all_characters_modify($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>Name</center>", "<center>Level</center>", "<center>Race</center>", "<center>Class</center>","","");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				$this->table->add_row("<center>".ucfirst($row->charName)."</center>",
				"<center>".ucfirst($row->charLevel)."</center>",
				"<center>".ucfirst($row->charRace)."</center>",
				'<center>'.ucfirst($row->charClass).'</center>',
				'<center>'.form_open('manage_characters/modify_character').form_hidden('charID',$row->charID).form_submit('modify_character','Modify Character','class="btn btn-default"').'</form></center>',
				'<center><button type="button" class="btn btn-default" data-toggle="modal" data-target="#deleteCharacterModal" data-charid="'.$row->charID.'">Delete Character</button></center>');
				
			}
			return $this->table->generate();
		}
		function fill_table_player_campaigns($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>Campaign Title</center>", "<center>Game Master</center>","<center>Character</center>","<center>Setting Document</center>");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				if($row->settingDocument!=""){
					$this->table->add_row("<center>".ucfirst($row->campaignTitle)."</center>",
					"<center>".ucfirst($row->username)."</center>",
					"<center>".ucfirst($row->charName)."</center>",
					'<center><a href="'.site_url().'/main/download_setting_document/'.$row->settingDocument.'" > Download File</a></center>'
					);
				}
				else{
					$this->table->add_row("<center>".ucfirst($row->campaignTitle)."</center>",
					"<center>".ucfirst($row->username)."</center>",
					"<center>".ucfirst($row->charName)."</center>",
					'<center>No setting document.</center>'
					);
				}

			}
			return $this->table->generate();
		}
		
		
		function fill_table_all_campaigns($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>Campaign Title</center>", "<center>Start Date</center>","<center>Players</center>", "<center>Characters</center>","<center>Setting Document</center>");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				$query2=$this->query_m->fetch_players_in_campaign_and_characters_query($row->campID);
				$players=array();
				$characters=array();
				foreach($query2->result() as $row2){
					$players[]=ucfirst($row2->username);
					$characters[]=ucfirst($row2->charName);
				}
				if($row->settingDocument!=""){
					$this->table->add_row("<center>".ucfirst($row->campaignTitle)."</center>",
					"<center>".date("Y-m-d",$row->startDate)."</center>",
					form_dropdown('player_dropdown-'.$row->campID, $players,'default','class="form-control" size="3"'),
					form_dropdown('character_dropdown-'.$row->campID, $characters,'default','class="form-control" size="3"'),
					'<center><a href="'.site_url().'/main/download_setting_document/'.$row->settingDocument.'" > Download File</a></center>'
					);
				}
				else{
					$this->table->add_row("<center>".ucfirst($row->campaignTitle)."</center>",
					"<center>".date("Y-m-d",$row->startDate)."</center>",
					form_dropdown('player_dropdown-'.$row->campID, $players,'default','class="form-control" size="3"'),
					form_dropdown('character_dropdown-'.$row->campID, $characters,'default','class="form-control" size="3"'),
					'<center>No setting document.</center>'
					);
				}

			}
			return $this->table->generate();
		}
		
		function fill_table_all_campaigns_modify($query, $table_type) {
			$this->set_table_template($table_type);
			//set table headings
			$this->table->set_heading("<center>Campaign Title</center>", "<center>Start Date</center>", "<center>Players</center>", "<center>Characters</center>");
			
			//fetch query passing argument through
			$i=0;
			foreach ($query->result() as $row)
			{
				$query2=$this->query_m->fetch_players_in_campaign_and_characters_query($row->campID);
				$players=array();
				$characters=array();
				foreach($query2->result() as $row2){
					$players[]=ucfirst($row2->username);
					$characters[]=ucfirst($row2->charName);
				}
				$this->table->add_row("<center>".ucfirst($row->campaignTitle)."</center>",
				"<center>".date("Y-m-d",$row->startDate)."</center>",
				form_dropdown('player_dropdown-'.$row->campID, $players,'default','class="form-control" size="3"'),
				form_dropdown('character_dropdown-'.$row->campID, $characters,'default','class="form-control" size="3"'),
				'<center>'.form_open('manage_campaigns/modify_campaign').form_hidden('campID',$row->campID).form_submit('modify_campaign','Modify Campaign','class="btn btn-default"').'</form></center>',
				'<center><button type="button" class="btn btn-default" data-toggle="modal" data-target="#deleteCampaignModal" data-campaignid="'.$row->campID.'" data-campaigntitle="'.$row->campaignTitle.'">Delete Campaign</button></center>');
				
			}
			return $this->table->generate();
		}
	}	
?>