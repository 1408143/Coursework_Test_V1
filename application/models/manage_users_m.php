<?php
	class manage_users_m extends CI_Model {
		
		function user_creation_dropdown(){
			$array=array();
			$array["default"]="Select a user class";
			$array[1]="Game Master";
			$array[2]="Player";
			return $array;
		}
		function  create_new_user($userData) {
			
			//create a unique random user ID
			$data["userID"]=$this->create_new_user_id();
			
			//check userclass for alterarion, only Game Master and Player accounts should be created
			if(strcmp($userData['user_class'], "1")==0 || strcmp($userData['user_class'],"2")==0){
				$data['userClass'] = $userData['user_class'];
			}else{
				//error: someone is trying to mess with me by creating a new admin account
			}
			
			$data['username'] = $userData['username'];
			
			//hash password with bcrypt
			//salt is stored along with hash
			$data['password'] = password_hash($userData['password'],PASSWORD_DEFAULT);
			
			//we add the password expiry date for the account.
			//365 days till expiry
			$data['passwordResetDate'] = time()+(365*24*60*60);
			
			//set registered date
			$data['registerDate'] = time();
			//insert data
			$this->query_m->create_new_user_query($data);
			
			//create associated userinf row
			$this->query_m->create_new_user_info_query($data['userID']);
			
			return TRUE;
		}
		
		
		//function used to create a random unique user ID
		//we feed it a list of all current IDs in the database
		function create_new_user_id(){
			$user_list=$this->query_m->fetch_all_user_ids_query();
			//toggle token
			$not_unique=true;
			//loop until we find that the ID is unique
			while($not_unique){
				//generate random number between two arbitrary large numbers
				$new_user_id=rand(12314,18763);
				$same_as=false;
				foreach($user_list->result() as $user){
					$user_id_list[]=$user->userID;
				}
				if(!in_array($new_user_id,$user_id_list)){
					$not_unique=false;
				}
			}
			return $new_user_id;	
		}
		
		//function only modifies password
		function  modify_user_password($userData) {
			$data['userID']=$userData["userID"];
			$data['password'] = password_hash($userData['password'],PASSWORD_DEFAULT);
			$data['passwordResetDate'] = time()+(365*24*60*60);
			return $this->query_m->modify_user_password_query($data);
		}
		
		//function only modifies user information (excluding password)
		function  modify_user_info($userData) {
			return $this->query_m->modify_user_info_query($userData);
		}
		
		//function deletes user account
		//cascading rules make it so that related user information will be deleted as well
		function delete_user($userID) {
			$this->load->helper('directory');
			$data['userID']=$userID;
			$campaigns=$this->query_m->fetch_all_campaigns_for_userID_query($userID);
			if(isset($campaigns)){
				$map = directory_map('./uploads/settingDocuments/', 1);
				foreach($campaigns->result() as $row){
					if(isset($row->settingDocument) && in_array($row->settingDocument,$map)){
						unlink("./uploads/settingDocuments/".$row->settingDocument);
					}
				}
			}
			$characters=$this->query_m->fetch_all_characters_for_userID_query($userID);
			if(isset($campaigns)){
				$map = directory_map('./uploads/characterPictures/', 1);
				foreach($characters->result() as $row){
					if(isset($row->characterPicture) && in_array($row->characterPicture,$map)){
						unlink("./uploads/characterPictures/".$row->characterPicture);
					}
				}
			}
			return $this->query_m->delete_user_query($data);
		}
	}
?>