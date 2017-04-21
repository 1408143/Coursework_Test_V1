<?php
	class manage_campaigns_m extends CI_Model {
		
		function gm_campaign_dropdown($query){
			$array=array();
			$array["default"]="Select players";
			foreach($query->result() as $row){
				$array[$row->userID]=ucfirst($row->username);
			}
			return $array;
		}
		
		function create_new_campaign($new_campaign_info){
			$campID="";
			$new_campaign_info['gameMasterID']=$this->session->userdata("userID");
			$new_campaign_info['startDate']=time();
			echo "bip";
			if (!empty($_FILES['settingDocument']['name'])){
				
				$new_campaign_info["settingDocument"]=$this->manage_campaigns_m->setting_document_upload(0,$campID);
				echo $new_campaign_info["settingDocument"];
			}else{
				$new_campaign_info["settingDocument"]="";
			}
			
			//create campaign
			$this->query_m->create_new_campaign_query($new_campaign_info);
			//fetch newly created campaign ID
			$campID=$this->db->insert_id();

			
			//players in campaign
			//fetch all key values from post data
			$keys_c_mod_info=array_keys($new_campaign_info);
			$player_id_list=array();
			//sort key values to isolate player IDs
			foreach($keys_c_mod_info as $key){
				//echo $key;
				if(strpos($key,"player_list_invisible-")=="TRUE"){
					$player_id_list[]=$new_campaign_info[$key];
				}
			}
			$data=array();
			foreach($player_id_list as $playerID){
				$data["campID"]=$campID;
				$data["charID"]=$new_campaign_info["characterList-".$playerID];
				$this->query_m->add_player_character_to_campaign($data);
				unset($data);
			}	
		}
		
		function modify_campaign($campaign_info){
			
			if($campaign_info["settingDocument"]!=""){
				$this->query_m->update_campaign_query($campaign_info);
			}else{
				$this->query_m->update_campaign_no_document_query($campaign_info);
			}
			
			
			//fetch current players anc characters
			$query=$this->query_m->fetch_players_in_campaign_and_characters_query($campaign_info["campID"]);
			//players in campaign
			//fetch all key values from post data
			$keys_c_mod_info=array_keys($campaign_info);
			$player_id_list=array();
			//sort key values to isolate player IDs
			foreach($keys_c_mod_info as $key){
				//echo $key."<br/>"; 
				if(strpos($key,"player_list_invisible-")=="TRUE"){
					
					$player_id_list[]=$campaign_info[$key];
				}
			}
			
			foreach($player_id_list as $playerID){
				$data=array();
				//echo $playerID;
				//current player found token
				$current=FALSE;
				//loop through current players
				foreach($query->result() as $row){
					//check if player current
					//echo $current_players[$i]."<br/>";
					//echo $playerID."<br/>";
					if($row->userID==$playerID){
						//set token
						$current=TRUE;
						//check if character is different
						if($row->charID!=$campaign_info["characterList-".$playerID]){
							//if different then update
							$data['campPartID']=$row->campPartID;
							$data['charID']=$campaign_info["characterList-".$playerID];
							$this->query_m->update_campaign_participant_entry_query($data);
							//unset data
						}
					}
				}
				//if not current player, then
				if(!$current){
					$data["campID"]=$campaign_info["campID"];
					$data["charID"]=$campaign_info["characterList-".$playerID];
					$this->query_m->add_player_character_to_campaign($data);
					unset($data);
				}
			}
			//remove players if necessary
			//create tables
			foreach($query->result() as $row){
				$players[]=$row->userID;
				$participation_ids[]=$row->campPartID;
			}
			//loop through tables
			for($i=0;$i<count($players);$i++){
				//keep token fi player still present
				$keep=FALSE;
				foreach($player_id_list as $playerID){
					if($playerID==$players[$i]){
						//if found then true
						$keep=TRUE;
					}
				}
				//if not found then remove
				if(!$keep){
					$this->query_m->remove_player_character_from_campaign($participation_ids[$i]);
				}
			}
		}
		
		function delete_campaign($campID){
			$data['campID']=$campID;
			$query=$this->query_m->fetch_campaign_doc_query($campID);
			if(isset($query)){
				$file=$query->row();
				//echo $file->settingDocumentPath;
				if(isset($file->settingDocumentPath)){
					unlink("./uploads/settingDocuments/".$file->settingDocument);
				}
			}
			$this->query_m->delete_campaign_query($data);
		}
		
		function build_player_character_list($current_players_w_characters){
			$str="";
			foreach($current_players_w_characters->result() as $row){
				//compose dropdown for player characters
				$query2=$this->query_m->fetch_all_characters_not_busy_query($row->userID);
				$array=array();
				//add current character because is considered busy and will not show up in query
				$array[$row->charID]=ucfirst($row->charName);
				foreach($query2->result() as $row2){
					$array[$row2->charID]=ucfirst($row2->charName);
				}
				
				$str=$str.'<li id="'.$row->userID.'" style="list-style-type: none">'.
				'<div class="col-xs-4">'.
				ucfirst($row->username).
				'</div><div class="col-xs-12"></div>'.
				//then add an hidden input for form submission with userID as a value, and id being tagged uniquely for previous test
				'<input type="hidden" name="player_list_invisible-'.$row->userID.'" value="'.$row->userID.'" id="player_list_invisible-'.$row->userID.'"/>'.
				//then dropdown for character select
				'<div class="col-xs-8">'.
				form_dropdown('characterList-'.$row->userID, $array,$row->charID,'class="form-control" name="characterList-'.$row->userID.'" id="characterList-'.$row->userID.'"').
				//then add button for removal
				'</div><div class="col-xs-4">'.
				'<button type="button" class="btn btn-default" onclick="removePlayerPresent('.$row->userID.')">Remove</button>'.
				'</div>'.
				'</li>';
			}
			
			return $str;
		}
		
		function setting_document_upload($flag,$campID){
			//check for names in directory
			$this->load->helper('directory');
			
			
			$path = $_FILES['settingDocument']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			//check that name is unique
			$not_unique=TRUE;
			while($not_unique){
				$document_name="setting_doc_".rand(100000,1000000).".".$ext;
				$map = directory_map('./uploads/settingDocuments/', 1);
				if(count($map)>0){
					if(!in_array($document_name,$map)){
						$not_unique=FALSE;
					}
				}else{
					$not_unique=FALSE;
				}
			}
			
			if($flag==1){
				//delete old file
				$query=$this->query_m->fetch_campaign_doc_query($campID);
				if(isset($query)){
					$file=$query->row();
					//echo $file->settingDocumentPath;
					if(isset($file->settingDocument) && in_array($file->settingDocument,$map)){
						unlink("./uploads/settingDocuments/".$file->settingDocument);
					}
				}
			}
			//config upload helper
			$config['upload_path'] = './uploads/settingDocuments/';
			$config['allowed_types'] = 'pdf|txt|docx';
			$config['max_size']= '100';
			$config['file_name']=$document_name;
			$this->load->library('upload', $config);
			
			//upload
			if (!$this->upload->do_upload('settingDocument'))
			{
				$msg = $this->upload->display_errors('', '');
				//echo $msg;
			}
			else
			{
				//$data = $this->upload->data();
			}
			return $document_name;
		}
	}
?>