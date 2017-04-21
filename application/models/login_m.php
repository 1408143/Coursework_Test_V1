<?php
	class login_m extends CI_Model {
		
		function validate_user( $username, $password ) {
			// Build a query to retrieve the user's details
			// based on the received username
			
			//$results = $this->db->query("SELECT * FROM usr WHERE username = '".password_hash($login)."' AND `password` = '".password_hash($password)."' AND active_user=1");
			$results = $this->query_m->fetch_user_from_usermame_query($username);
			
			// The results of the query are stored in $results.
			// If a value exists, then the user account exists and is validated
			if ( $results->num_rows() == 1 ) {
				$user = $results->row();
				if(password_verify($password,$user->password)){
					// Call set_session to set the user's session vars via CodeIgniter
					
					$this->set_session($user);
					return true;
				}else{
					//The password does not match the username
					return false;
				}
			}else{
				//There does not appear to be a matching username
				return false;
			}
			return false;
		}
		
		function set_session($user) {
			// $this->session->set_userdata is a CodeIgniter function that
			// stores data in CodeIgniter's session storage.  Some of the values are built in
			
			//find out what type of user has logged in
			switch($user->userClass){
				default:
					//error, disconnect and destroy session
					redirect("login/logout_user");
					break;
				
				case 0:
					//Administrator
					$userClass="0";
					break;
					
				case 1:
					//Game Master
					$userClass="1";
					break;
					
				case 2:
					//Player
					$userClass="2";
					break;
			}
			//store identifying information in session along with logged in token
			$userData=array(
						'userID' => $user->userID,
						'userClass' => $userClass
					);
					
			//set session data
			$this->session->set_userdata($userData);
			$this->query_m->update_last_login_query($user->userID, time());
		}
		
		
		
		//function that checks the session userID and userClass (permission level) for possible hijacking
		function security_check(){
			$result=$this->query_m->fetch_user_from_userID_query($this->session->userdata('userID'));
			if($result->num_rows()!=0){
				$current_user=$result->row();
				if($this->session->userdata['userClass']!=$current_user->userClass){
					
				}else{
					//error: someone is trying to hijack us
					//logout_with_prejudice
				}
			}else{
				//error: someone is trying to hijack us
				//logout_with_prejudice
			}
		}
	}
?>