<?php
	class query_m extends CI_Model {	
	
		//critical marked with '!!!'//
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_users_query(){
			$sql="SELECT userID, userClass, username
			FROM usr";
			return $this->db->query($sql);
		}
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_non_admin_users_and_user_info_query(){
			$sql="SELECT u.userClass, u.username, u.lastConnection, uf.*
			FROM usr u
			JOIN usrinf uf ON u.userID = uf.userID
			WHERE u.userClass!=0";
			return $this->db->query($sql);
		}
		
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_game_master_users_query(){
			$sql="SELECT userID, userClass, username, lastConnection
			FROM usr
			WHERE userClass=1";
			return $this->db->query($sql);
		}
		
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_player_users_query(){
			$sql="SELECT userID, userClass, username, lastConnection 
			FROM usr
			WHERE userClass=2";
			return $this->db->query($sql);
		}
		//!!!!!!!!!!!!!!!!!//
		function fetch_user_from_userID_query($userID){
			$sql="SELECT userID, username, userClass, registerDate
			FROM usr
			WHERE userID = ?";
			return $this->db->query($sql,$userID);
		}
		
		//!!!!!!!!!!!!!!!!!//
		function fetch_user_password_from_userID_query($userID){
			$sql="SELECT password
			FROM usr
			WHERE userID = ?";
			return $this->db->query($sql,$userID);
		}
		
		//!!!!!!!!!!!!!!!!!//
		function fetch_user_info_from_userID_query($userID){
			$sql="SELECT uf.fname, uf.lname, uf.email, u.userID, u.username, u.registerDate
			FROM usrinf uf
			JOIN usr u
			ON uf.userID = u.userID
			WHERE uf.userID = ?";
			return $this->db->query($sql,$userID);
		}
		//!!!!!!!!!!!!!!!!!//
		function fetch_user_from_usermame_query($username){
			$sql="SELECT * 
			FROM usr 
			WHERE username = ?";
			return $this->db->query($sql,$username);
		}
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_usernames_query(){
			$sql="SELECT username
			FROM usr";
			return $this->db->query($sql);
		}
		//!!!!!!!!!!!!!!!!!//
		function fetch_all_user_ids_query(){
			$sql="SELECT userID
			FROM usr";
			return $this->db->query($sql);
		}
		
		//insert last login time
		function update_last_login_query($userID, $timestamp){
			$sql="UPDATE usr
			SET lastCOnnection=?
			WHERE userID=?";
			return $this->db->query($sql, array($timestamp, $userID));
		}
		
		function create_new_user_query($data){
			$sql="INSERT INTO usr(userID, userClass, username, password, passwordResetDate, registerDate) 
				VALUES(?,?,?,?,?,?)";
			return $this->db->query($sql, array($data['userID'], $data['userClass'],$data['username'],$data['password'],$data['passwordResetDate'], $data['registerDate']));
		}
		
		function create_new_user_info_query($userID){
			$sql="INSERT INTO usrinf(userID) 
				VALUES(?);";
			return $this->db->query($sql, $userID);
		}
		
		//insert last login time
		function modify_user_password_query($data){
			$sql="UPDATE usr
			SET password=?, passwordResetDate=?
			WHERE userID=?";
			return $this->db->query($sql, array($data['password'], $data['passwordResetDate'], $data['userID']));
		}
		
		//insert last login time
		function modify_user_info_query($data){
			$sql="UPDATE usrinf
			SET fname=?, lname=?, email=?
			WHERE userID=?";
			return $this->db->query($sql, array($data['fname'], $data['lname'], $data['email'],$data['userID']));
		}
		
		//insert last login time
		function delete_user_query($data){
			$sql="DELETE 
			FROM usr 
			WHERE userID=?";
			return $this->db->query($sql, $data['userID']);
		}
		
		function fetch_all_characters_for_userID_query($userID){
			$sql="SELECT *
			FROM chara
			WHERE userID=?";
			return $this->db->query($sql, $userID);
		}
		
		function fetch_character_for_charID_query($userID){
			$sql="SELECT *
			FROM chara
			WHERE charID=?";
			return $this->db->query($sql, $userID);
		}
		
		function create_new_character_query($data){
			$sql="INSERT INTO chara(userID, charName, charRace, charGender, charClass, charLevel, STR,`INT`, WIS, DEX, CON, CHA, characterPicture) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
			return $this->db->query($sql, array($data['userID'], $data['charName'],$data['charRace'],$data['charGender'],$data['charClass'],$data['charLevel'], $data['STR'], $data['INT'], $data['WIS'], $data['DEX'], $data['CON'], $data['CHA'], $data['characterPicture']));
		}
		
		//insert last login time
		function modify_character_query($data){
			$sql="UPDATE chara
			SET charClass=?, charLevel=?, STR=?,`INT`=?, WIS=?, DEX=?, CON=?, CHA=?, characterPicture=?
			WHERE charID=?";
			return $this->db->query($sql, array($data['charClass'],$data['charLevel'], $data['STR'], $data['INT'], $data['WIS'], $data['DEX'], $data['CON'], $data['CHA'],$data['characterPicture'],$data['charID']));
		}
		
		function fetch_character_picture_query($charID){
			$sql="SELECT characterPicture
			FROM chara
			WHERE charID=?";
			return $this->db->query($sql,$charID);
		}
		
		function delete_character_query($data){
			$sql="DELETE 
			FROM chara 
			WHERE charID=?";
			return $this->db->query($sql, $data['charID']);
		}
		
		function fetch_all_campaigns_for_userID_query($userID){
			$sql="SELECT *
			FROM camp
			WHERE gameMasterID=?";
			return $this->db->query($sql, $userID);
		}
		
		function fetch_all_characters_in_campaigns_query($userID){
			$sql="SELECT charID
			FROM camppart";
			return $this->db->query($sql, $userID);
		}
		
		function create_new_campaign_query($data){
			$sql="INSERT INTO camp(gameMasterID, campaignTitle, startDate, settingDocument) 
				VALUES(?,?,?,?);";
			return $this->db->query($sql, array($data['gameMasterID'],$data['campaignTitle'],$data['startDate'],$data['settingDocument']));
		}
		
		function add_player_character_to_campaign($data){
			$sql="INSERT INTO camppart(campID, charID) 
				VALUES(?,?);";
			return $this->db->query($sql, array($data['campID'],$data['charID']));
		}
		
		function fetch_all_characters_not_busy_query($userID){
			$sql="SELECT ch.charID, ch.charName
			FROM chara ch
			WHERE ch.charID NOT IN(
			SELECT ch.charID
			FROM chara ch
			JOIN camppart ca ON ch.charID = ca.charID)
			AND ch.userID=?";
			return $this->db->query($sql,$userID);
		}
		
		function fetch_all_player_with_free_characters_query(){
			$sql="SELECT userID, username
			FROM usr
			WHERE userClass=2 AND userID IN(
			SELECT userID 
			FROM chara
			WHERE charID NOT IN(
			SELECT charID
			FROM camppart
			))";
			return $this->db->query($sql);
		}
		
		function delete_campaign_query($data){
			$sql="DELETE 
			FROM camp 
			WHERE campID=?";
			return $this->db->query($sql, $data['campID']);
		}
		
		function fetch_players_in_campaign_and_characters_query($campID){
			$sql="SELECT u.userID, u.username, ch.charID, ch.charName, cap.campPartID
			FROM usr u
			JOIN chara ch ON u.userID = ch.userID
			JOIN camppart cap ON ch.charID = cap.charID
			WHERE cap.campID =? and u.userClass=2";
			return $this->db->query($sql,$campID);
		}
		
		function fetch_campaign_doc_query($campID){
			$sql="SELECT settingDocument
			FROM camp
			WHERE campID=?";
			return $this->db->query($sql,$campID);
		}
		
		function fetch_campaign_for_campID_query($campID){
			$sql="SELECT campID, campaignTitle, settingDocument
			FROM camp ca
			WHERE campID=?";
			return $this->db->query($sql,$campID);
		}
		
		function update_campaign_query($data){
			$sql="UPDATE camp
			SET campaignTitle=?, settingDocument=?
			WHERE campID=?";
			return $this->db->query($sql, array($data['campaignTitle'],$data['settingDocument'],$data['campID']));
		}
		
		function update_campaign_participant_entry_query($data){
			$sql="UPDATE camppart
			SET charID=?
			WHERE campPartID=?";
			return $this->db->query($sql, array($data['charID'],$data['campPartID']));
		}
		
		function remove_player_character_from_campaign($campPartID){
			$sql="DELETE 
			FROM camppart 
			WHERE campPartID=?";
			return $this->db->query($sql, $campPartID);
		}
		
		//insert information in any table
		//!!!!!!!!!!!!!!!!!//
		/*function insert_data_query($fields_data, $table_mod){
			$fields=array_keys($fields_data);//keys are the columns of table
			$sql="INSERT INTO ".$table_mod."(";//table_mod is the table name
			for ($i=0;$i<count($fields);$i++){//loop through columns
				$sql=$sql.$fields[$i];
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
			}
			
			$sql=$sql.") VALUES (";

			for ($i=0;$i<count($fields);$i++){//loop through data
				$sql=$sql."'".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql.")";
			$this->db->query($sql);
			return $sql;
			//return 
		}*/
	
		/*function fetch_session_table_query($type, $practitioner_register_ref_no,$start_of_month,$end_of_month){
			//fetch query
			switch ($type){
				default:
					$str="default";
				break;
				case "one_on_one":
					$query=$this->query_m->one_on_one_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "group":
					$query=$this->query_m->group_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "exit":
					$query=$this->query_m->exit_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "evaluation":
					$query=$this->query_m->evaluation_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "supervision":
					$query=$this->query_m->supervision_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "training":
					$query=$this->query_m->training_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "conference":
					$query=$this->query_m->conference_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month);//fetch table with query input
				break;
				case "alliances":
					$query=$this->query_m->alliance_practitioner_table_query();//fetch table with query input
				break;
				case "clients":
					$query=$this->query_m->client_practitioner_table_query($practitioner_register_ref_no);//fetch table with query input	
				break;
			}
			return $query;
		}
		
		function fetch_session_ajax_query($type,$session_register_ref_no){
			//fetch query
			$query="";
			switch ($type){
				default:
					$query="default";
				break;
				case "one_on_one":
					$query=$this->query_m->one_on_one_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "group":
					$query=$this->query_m->group_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "exit":
					$query=$this->query_m->exit_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "evaluation":
					$query=$this->query_m->evaluation_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "supervision":
					$query=$this->query_m->supervision_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "training":
					$query=$this->query_m->training_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "conference":
					$query=$this->query_m->conference_practitioner_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "alliances":
					$query=$this->query_m->alliance_admin_ajax_query($session_register_ref_no);//fetch table with query input
				break;
				case "clients":
					$query=$this->query_m->client_practitioner_ajax_query($session_register_ref_no);//fetch table with query input	
				break;
			}
			return $query;
		}
		
		//request for one on one session info
		function one_on_one_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.*, _type.type_title, _client.client_ref_no, _client.client_id, _client.first_name, _client.last_name, client_session.* 
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN _client ON client_session_register.client_ref_no = _client.client_ref_no
			JOIN client_session ON session_register.session_register_ref_no = client_session.session_register_ref_no
			JOIN expertise_type_register ON client_session.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND client_session.session_register_ref_no IN 
				(SELECT client_session.session_register_ref_no 
				FROM client_session 
				JOIN practitioner_session_register ON client_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?) ";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		//request for one on one session info
		function one_on_one_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no, session_register.admin_approved, practitioner_session_register.practitioner_register_ref_no, practitioner_session_register.attendance AS 'attendance_p',
			practitioner_session_register.volunteer, client_session_register.client_session_register_ref_no, 
			client_session_register.attendance, client_session.expertise_type_register_ref_no, session_register.session_class_ref_no,
			session_register.session_date, session_register.scheduled_time_start, session_register.scheduled_time_finish,  _type.type_title, _client.client_ref_no, 
			_client.first_name, _client.last_name, client_session.client_session_outcome 
			FROM session_register
			JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN _client ON client_session_register.client_ref_no = _client.client_ref_no
			JOIN client_session ON session_register.session_register_ref_no = client_session.session_register_ref_no
			JOIN expertise_type_register ON client_session.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no
			WHERE session_register.session_register_ref_no=?
			ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for group session info
		function group_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT DISTINCT session_register.session_register_ref_no,session_register.session_date,session_register.admin_approved, _type.type_title, group_session.practitioner_register_ref_no
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN group_session ON session_register.session_register_ref_no = group_session.session_register_ref_no
			JOIN _group ON group_session.group_ref_no = _group.group_ref_no
			JOIN expertise_type_register ON _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND group_session.session_register_ref_no IN 
				(SELECT group_session.session_register_ref_no 
				FROM group_session 
				JOIN practitioner_session_register ON group_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?)";
			}
			
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}

		//request for group client number_clients
		function number_group_clients_table_query($session_register_ref_no){
			//create query using 
			$sql="SELECT COUNT(client_session_register.client_ref_no) AS number_clients 
			FROM client_session_register
			WHERE client_session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for group session info
		function group_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT DISTINCT session_register.*, _type.type_title, _group.title, _group.group_ref_no, group_session.practitioner_register_ref_no 
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN group_session ON session_register.session_register_ref_no = group_session.session_register_ref_no
			JOIN _group ON group_session.group_ref_no = _group.group_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_type_register_ref_no = _group.expertise_type_register_ref_no
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no
			WHERE session_register.session_register_ref_no=? ";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for exit session info
		function exit_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date, _client.client_ref_no, _client.client_id
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN _client ON _client.client_ref_no = client_session_register.client_ref_no
			JOIN exit_session ON session_register.session_register_ref_no = exit_session.session_register_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND exit_session.session_register_ref_no IN 
				(SELECT exit_session.session_register_ref_no 
				FROM exit_session 
				JOIN practitioner_session_register ON exit_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?)";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		//request for exit session info
		function exit_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT session_register.*,session_register.session_class_ref_no, practitioner_session_register.practitioner_register_ref_no,
			practitioner_session_register.attendance AS 'attendance_p', practitioner_session_register.volunteer,client_session_register.attendance,
			_client.client_ref_no, _client.first_name, _client.last_name, exit_session.* 
			FROM session_register
			JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN _client ON client_session_register.client_ref_no = _client.client_ref_no
			JOIN exit_session ON session_register.session_register_ref_no = exit_session.session_register_ref_no
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for evaluator session info
		function evaluation_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date, evaluation_session.evaluated_session_register_ref_no, practitioner_register.practitioner_register_ref_no AS 'evaluator' 
			FROM session_register
			JOIN practitioner_session_register ON practitioner_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no
			JOIN evaluation_session ON session_register.session_register_ref_no = evaluation_session.session_register_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND (evaluation_session.session_register_ref_no IN 
				(SELECT evaluation_session.session_register_ref_no 
				FROM evaluation_session 
				JOIN practitioner_session_register ON evaluation_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?) 
				OR evaluation_session.evaluated_session_register_ref_no IN
				(SELECT client_session.session_register_ref_no 
				FROM client_session
				JOIN practitioner_session_register ON client_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?))";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql, array($practitioner_register_ref_no,$practitioner_register_ref_no));
		}
		
		//request for evaluator session info
		function evaluation_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT session_register.*, 
			evaluation_session.evaluated_session_register_ref_no,evaluation_session.evaluation_session_outcome, 
			practitioner_register.practitioner_register_ref_no AS 'evaluator',practitioner_session_register.practitioner_register_ref_no,
			practitioner_session_register.attendance AS 'attendance_p', practitioner_session_register.volunteer,
			alliance.alliance_ref_no, alliance.first_name, alliance.last_name 
			FROM session_register 
			JOIN practitioner_session_register ON practitioner_session_register.session_register_ref_no = session_register.session_register_ref_no 
			JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no 
			JOIN evaluation_session ON session_register.session_register_ref_no = evaluation_session.session_register_ref_no 
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql, $session_register_ref_no);
		}
		
		//request for supervision session info
		function supervision_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date 
			FROM session_register
			JOIN supervision_session ON session_register.session_register_ref_no = supervision_session.session_register_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND supervision_session.session_register_ref_no IN 
				(SELECT supervision_session.session_register_ref_no 
				FROM supervision_session 
				JOIN practitioner_session_register ON supervision_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				WHERE practitioner_register.practitioner_register_ref_no=?)";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		//request for supervision session info
		function supervision_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_class_ref_no,session_register.session_date, supervision_session.supervision_session_outcome,
			session_register.scheduled_time_start, session_register.scheduled_time_finish, supervision_session.supervision_type, supervision_session.supervision_session_ref_no
			FROM session_register
			JOIN supervision_session ON session_register.session_register_ref_no = supervision_session.session_register_ref_no
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for training session info
		function training_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date , training_session.training_title
			FROM session_register
			JOIN training_session ON session_register.session_register_ref_no = training_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND (training_session.training_session_ref_no IN
				(SELECT training_session_trainer.training_session_ref_no 
				FROM training_session_trainer
				JOIN practitioner_register ON practitioner_register.alliance_ref_no = training_session_trainer.alliance_ref_no
				WHERE practitioner_register.practitioner_register_ref_no=?)
				OR
				training_session.training_session_ref_no IN
				(SELECT training_session_attendee.training_session_ref_no 
				FROM training_session_attendee
				JOIN practitioner_register ON practitioner_register.alliance_ref_no = training_session_attendee.alliance_ref_no
				WHERE practitioner_register.practitioner_register_ref_no=?))";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,array($practitioner_register_ref_no,$practitioner_register_ref_no));
		}
		
		//request for training session info
		function training_practitioner_ajax_query($session_register_ref_no){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_class_ref_no, session_register.session_date, 
			session_register.scheduled_time_start, session_register.scheduled_time_finish, training_session.training_session_ref_no, training_session.training_title
			FROM session_register
			JOIN training_session ON session_register.session_register_ref_no = training_session.session_register_ref_no
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for training session info
		function conference_practitioner_table_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			//create query using 
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date, conference_session.conference_title
			FROM session_register
			JOIN conference_session ON session_register.session_register_ref_no = conference_session.session_register_ref_no";
			$sql=$sql." WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." AND conference_session.conference_session_ref_no IN
				(SELECT conference_session_trainer.conference_session_ref_no 
				FROM conference_session_trainer
				JOIN practitioner_register ON practitioner_register.alliance_ref_no = conference_session_trainer.alliance_ref_no
				WHERE practitioner_register.practitioner_register_ref_no=?)
				OR
				conference_session.conference_session_ref_no IN
				(SELECT conference_session_attendee.conference_session_ref_no 
				FROM conference_session_attendee
				JOIN practitioner_register ON practitioner_register.alliance_ref_no = conference_session_attendee.alliance_ref_no
				WHERE practitioner_register.practitioner_register_ref_no=?)";
			}
			$sql=$sql." ORDER BY session_register.session_date DESC";
			return $this->db->query($sql,array($practitioner_register_ref_no,$practitioner_register_ref_no));
		}
		
		function conference_practitioner_ajax_query($session_register_ref_no){
			$sql="SELECT session_register.*, conference_session.*
			FROM session_register
			JOIN conference_session ON session_register.session_register_ref_no = conference_session.session_register_ref_no
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request for non admin client info
		function alliance_practitioner_table_query(){
			//create query using 
			$sql="SELECT DISTINCT alliance.*
			FROM alliance";
			return $this->db->query($sql);
		}
		
		//request for non admin client info
		function alliance_admin_ajax_query($alliance_ref_no){
			//create query using 
			$sql="SELECT DISTINCT alliance.*, contact_info.* , contact_info.contact_info_ref_no AS contact_info_reference_number
			FROM alliance 
			JOIN contact_info ON contact_info.contact_info_ref_no = alliance.contact_info_ref_no 
			WHERE alliance.alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		//request for non admin client info
		function alliance_practitioner_admin_ajax_query($alliance_ref_no){
			//create query using 
			$sql="SELECT practitioner_register_ref_no
			FROM practitioner_register
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		//request for non admin client info
		function alliance_administrator_admin_ajax_query($alliance_ref_no){
			//create query using 
			$sql="SELECT administrator_register_ref_no
			FROM administrator_register
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		//request for non admin client info
		function alliance_handymen_admin_ajax_query($alliance_ref_no){
			//create query using 
			$sql="SELECT handymen_register_ref_no
			FROM handymen_register
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		
		//request for non admin client info
		function client_practitioner_table_query($practitioner_register_ref_no){
			//create query using 
			$sql="SELECT DISTINCT _client.*
			FROM _client";
			//check if admin
			if(!$this->session->userdata('is_admin')){
				//using ? to escape value
				$sql=$sql." 
				JOIN client_session_register ON _client.client_ref_no = client_session_register.client_ref_no
				JOIN practitioner_session_register ON client_session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				WHERE practitioner_session_register.practitioner_register_ref_no=?";
			}
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		//request for non admin client info
		function client_max_date_practitioner_table_query($client_ref_no){
			$sql="SELECT MAX(session_register.session_date) AS session_date
			FROM session_register
			JOIN client_session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
			WHERE client_session_register.client_ref_no=?";
			return $this->db->query($sql, $client_ref_no);
		}
		
		//request for non admin client info
		function client_practitioner_ajax_query($client_ref_no){
			//create query using 
			$sql="SELECT _client.*, MAX(session_register.session_date) AS session_date, contact_info.*, contact_info.contact_info_ref_no AS contact_info_reference_number 
			FROM _client JOIN client_session_register ON _client.client_ref_no = client_session_register.client_ref_no 
			JOIN contact_info ON contact_info.contact_info_ref_no = _client.contact_info_ref_no 
			JOIN session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no 
			WHERE client_session_register.client_ref_no=? ";
			return $this->db->query($sql,$client_ref_no);
		}
		
		//request for alliance/user info
		function profile_query(){
			//create query using 
			$sql="SELECT user.login, alliance.*, contact_info.* 
			FROM user 
			JOIN alliance ON user.user_ref_no = alliance.user_ref_no 
			JOIN contact_info ON alliance.contact_info_ref_no  = contact_info.contact_info_ref_no
			WHERE user.user_ref_no=?";
			return $this->db->query($sql,$this->session->userdata('user_ref_no'));
		}
		
		//request all clients
		function client_list_query(){
			$sql="SELECT client_ref_no, client_id, first_name, last_name 
			FROM _client 
			WHERE activity_level!=0
			ORDER BY last_name DESC";
			return $this->db->query($sql);
		}
		
		//request all clients
		function client_list_active_query(){
			$sql="SELECT client_ref_no, client_id, first_name, last_name 
			FROM _client 
			WHERE activity_level!=0
			ORDER BY last_name DESC";
			return $this->db->query($sql);
		}
		
		//request all clients
		function client_list_inactive_query(){
			$sql="SELECT client_ref_no, client_id, first_name, last_name 
			FROM _client 
			WHERE activity_level=0
			ORDER BY last_name DESC";
			return $this->db->query($sql);
		}
		
		//request all clients
		function client_list_all_query(){
			$sql="SELECT client_ref_no, client_id, first_name, last_name 
			FROM _client 
			ORDER BY last_name DESC";
			return $this->db->query($sql);
		}
		
		//request clients from group session
		function client_group_list_query($session_register_ref_no){
			$sql="SELECT _client.client_ref_no, _client.first_name, _client.last_name 
			FROM _client
			JOIN client_session_register ON client_session_register.client_ref_no = _client.client_ref_no
			JOIN session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			WHERE session_register.session_register_ref_no=?
			ORDER BY _client.last_name";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		//request individual client
		function fetch_client_query($client_ref_no){
			$sql="SELECT _client.client_ref_no, _client.first_name, _client.last_name, contact_info.* 
			FROM _client
			JOIN contact_info ON _client.contact_info_ref_no = contact_info.contact_info_ref_no
			WHERE _client.client_ref_no=?";
			return $this->db->query($sql,$client_ref_no);
		}
		
		//request individual practitioner for user ref no
		function fetch_practitioner_for_user($user_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.*
			FROM practitioner_register
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE alliance.user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		
		//request individual practitioner for user ref no
		function fetch_administrator_for_user($user_ref_no){
			$sql="SELECT administrator_register.administrator_register_ref_no, alliance.*
			FROM administrator_register
			JOIN alliance ON administrator_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE alliance.user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		//request individual practitioner for user ref no
		function fetch_handymen_for_user($user_ref_no){
			$sql="SELECT handymen_register.handymen_register_ref_no, alliance.*
			FROM handymen_register
			JOIN alliance ON handymen_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE alliance.user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		//request individual practitioner for practitioner ref no
		function fetch_alliance_for_practitioner($practitioner_register_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.*
			FROM practitioner_register
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE practitioner_register.practitioner_register_ref_no=?";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		//fetch a practitioner for a given evaluated session ID (cannot be a group id)
		function fetch_practitioner_for_session($session_register_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no 
			FROM practitioner_register
			JOIN practitioner_session_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no
			WHERE session_register_ref_no=?";
			return $this->db->query($sql, $session_register_ref_no);
		}
		
		function fetch_practitioner_for_session_ajax($session_register_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.first_name, alliance.last_name 
			FROM practitioner_register
			JOIN practitioner_session_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE session_register_ref_no=?";
			return $this->db->query($sql, $session_register_ref_no);
		}
		
		
		function practitioners_list_query(){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.first_name, alliance.last_name
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no
			WHERE alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		
		function practitioners_alliance_list_query(){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no 
			WHERE alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		
		function administrators_alliance_list_query(){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name
			FROM administrator_register 
			JOIN alliance ON alliance.alliance_ref_no = administrator_register.alliance_ref_no 
			WHERE alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		
		function supervisors_supervision_list_query($session_register_ref_no){
			$sql="SELECT supervision_session_trainer.supervision_session_trainer_ref_no, alliance.alliance_ref_no, alliance.first_name, alliance.last_name, supervision_session_trainer.supervision_fee
			FROM supervision_session_trainer 
			JOIN supervision_session ON supervision_session.supervision_session_ref_no = supervision_session_trainer.supervision_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = supervision_session_trainer.alliance_ref_no
			WHERE supervision_session.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function attendees_supervision_list_query($session_register_ref_no){
			$sql="SELECT supervision_session_attendee.supervision_session_attendee_ref_no, alliance.alliance_ref_no, alliance.first_name, alliance.last_name
			FROM supervision_session_attendee 
			JOIN supervision_session ON supervision_session.supervision_session_ref_no = supervision_session_attendee.supervision_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = supervision_session_attendee.alliance_ref_no
			WHERE supervision_session.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function practitioners_list_for_group_ref_no_query($group_ref_no){
			$sql="SELECT DISTINCT practitioner_register.practitioner_register_ref_no, alliance.first_name, alliance.last_name
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no
			JOIN expertise_register ON practitioner_register.practitioner_register_ref_no = expertise_register.practitioner_register_ref_no
			JOIN practitioner_type_register ON expertise_register.practitioner_expertise_register_ref_no = practitioner_type_register.practitioner_expertise_register_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_ref_no = expertise_register.expertise_ref_no
			JOIN _group ON _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			WHERE expertise_type_register.type_ref_no=practitioner_type_register.type_ref_no
			AND _group.group_ref_no=?";
			return $this->db->query($sql,$group_ref_no);
		}
		
		//fetch a practitioner for a given evaluated session ID (cannot be a group id)
		function practitioners_group_list_query($session_register_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.first_name, alliance.last_name, practitioner_session_register.attendance, practitioner_session_register.volunteer
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no 
			JOIN practitioner_session_register ON practitioner_register.practitioner_register_ref_no = practitioner_session_register.practitioner_register_ref_no 
			WHERE practitioner_session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function type_list_query(){
			$sql="SELECT expertise_type_register.expertise_type_register_ref_no, _type.type_title 
			FROM _type 
			JOIN expertise_type_register ON _type.type_ref_no = expertise_type_register.type_ref_no";
			return $this->db->query($sql);
		}
		
		//fetch type list for practitioner
		function type_list_practitioner_query($practitioner_register_ref_no){
			$sql="SELECT expertise_type_register.expertise_type_register_ref_no, _type.type_title 
			FROM _type 
			JOIN expertise_type_register ON _type.type_ref_no = expertise_type_register.type_ref_no 
			JOIN expertise_register ON expertise_type_register.expertise_ref_no = expertise_register.expertise_ref_no 
			JOIN practitioner_register ON expertise_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
			WHERE practitioner_register.practitioner_register_ref_no=?";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		//update query session_register
		function update_query($fields_data, $session_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function update_contact_info_query($fields_data,$contact_info_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
				
			}
			$sql=$sql."WHERE contact_info_ref_no=?";
			return $this->db->query($sql,$contact_info_ref_no);
		}
		
		function update_user_query($fields_data,$user_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
				
			}
			$sql=$sql."WHERE user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		function update_alliance_query($fields_data,$alliance_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
				
			}
			$sql=$sql."WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function update_regime_register_query($fields_data,$regime_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
				
			}
			$sql=$sql."WHERE regime_register_ref_no=?";
			return $this->db->query($sql,$regime_register_ref_no);
		}
		
		function update_trauma_register_query($fields_data, $trauma_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE trauma_register_ref_no=?";
			return $this->db->query($sql,$trauma_register_ref_no);
		}
		
		//update trauma
		function update_trauma_query($fields_data, $trauma_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE trauma_ref_no=?";
			return $this->db->query($sql,$trauma_ref_no);
		}
		
		//update trauma
		function update_session_class_query($fields_data, $session_class_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_class_ref_no=?";
			return $this->db->query($sql,$session_class_ref_no);
		}
		
		//update trauma
		function update_session_class_register_query($fields_data, $session_class_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_class_register_ref_no=?";
			return $this->db->query($sql,$session_class_register_ref_no);
		}
		
		function update_calendar_day($fields_data, $calendar_ref_no, $calendar_day_date, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE calendar_ref_no=?
			AND CAST(calendar_day_date AS DATE)= CAST('".$calendar_day_date."' AS DATE)";
			return $this->db->query($sql,$calendar_ref_no);
		}
		
		function update_external_cost_query($fields_data, $external_cost_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE external_cost_ref_no=?";
			return $this->db->query($sql,$external_cost_ref_no);
		}
		
		function update_client_group_query($fields_data, $session_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_register_ref_no=?
			AND client_ref_no=?";
			return $this->db->query($sql,array($session_register_ref_no,$fields_data["client_ref_no"]));
		}
		
		function update_practitioner_group_query($fields_data, $session_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_register_ref_no=?
			AND practitioner_register_ref_no=?";
			return $this->db->query($sql,array($session_register_ref_no,$fields_data["practitioner_register_ref_no"]));
		}
		
		//fetch questionnaires
		function fetch_questionnaire_list_query(){
			$sql="SELECT DISTINCT questionnaire.questionnaire_ref_no, questionnaire.name, questionnaire.type, questionnaire.number_of_questions
			FROM questionnaire";
			return $this->db->query($sql);
		}
		
		//fetch expertise_type_list
		function fetch_expertise_type_register_list_expertise_query($expertise_ref_no){
			$sql="SELECT DISTINCT expertise_type_register.expertise_type_register_ref_no, expertise_type_register.type_ref_no, _type.type_ref_no, _type.type_title
			FROM expertise_type_register
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no
			WHERE expertise_type_register.expertise_ref_no=?";
			return $this->db->query($sql,$expertise_ref_no);
		}
		
		//fetch practitioner_type_list
		function fetch_practitioner_type_register_list_expertise_query($practitioner_ref_no,$expertise_ref_no){
			$sql="SELECT DISTINCT practitioner_type_register.practitioner_type_register_ref_no, practitioner_type_register.type_ref_no, _type.type_title, 
			session_fee_register.session_fee_register_ref_no, session_fee_register.cost_per_session, session_fee_register.session_length, 
			group_session_fee_register.group_session_fee_register_ref_no, group_session_fee_register.cost_per_group_session
			FROM practitioner_type_register 
			JOIN session_fee_register ON practitioner_type_register.practitioner_type_register_ref_no = session_fee_register.practitioner_type_register_ref_no
			JOIN group_session_fee_register ON session_fee_register.practitioner_type_register_ref_no = group_session_fee_register.practitioner_type_register_ref_no
			JOIN expertise_register ON expertise_register.practitioner_expertise_register_ref_no = practitioner_type_register.practitioner_expertise_register_ref_no 
			JOIN _type ON practitioner_type_register.type_ref_no = _type.type_ref_no 
			WHERE expertise_register.practitioner_register_ref_no=?
			AND expertise_register.expertise_ref_no=?";
			return $this->db->query($sql,array($practitioner_ref_no,$expertise_ref_no));
		}
		
		//fetch questionnaires
		function fetch_stable_cost_list_query(){
			$sql="SELECT *
			FROM stable_cost";
			return $this->db->query($sql);
		}
		
		function update_questionnaire_query($fields_data,$questionnaire_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE questionnaire_ref_no=?";
			return $this->db->query($sql, $questionnaire_ref_no);
		}
		
		function update_question_query($fields_data,$question_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE question_ref_no=?";
			return $this->db->query($sql, $question_ref_no);
		}
		
		function update_answer_query($fields_data,$answer_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE answer_ref_no=?";
			return $this->db->query($sql, $answer_ref_no);
		}
		
		function update_stable_cost_query($fields_data,$stable_cost_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE stable_cost_ref_no=?";
			return $this->db->query($sql, $stable_cost_ref_no);
		}
		
		function update_group_query($fields_data,$expertise_type_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE group_ref_no=?";
			return $this->db->query($sql, $expertise_type_register_ref_no);
		}
		
		function update_client_query($fields_data,$client_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE client_ref_no=?";
			return $this->db->query($sql, $client_ref_no);
		}
		
		function update_type_query($fields_data,$type_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE type_ref_no=?";
			return $this->db->query($sql, $type_ref_no);
		}
		
		function update_expertise_query($fields_data,$expertise_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE expertise_ref_no=?";
			return $this->db->query($sql, $expertise_ref_no);
		}
		
		function update_practitioner_type_register_query($fields_data,$practitioner_type_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE practitioner_type_register_ref_no=?";
			return $this->db->query($sql, $practitioner_type_register_ref_no);
		}
		
		function update_session_fee_register_query($fields_data,$session_fee_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE session_fee_register_ref_no=?";
			return $this->db->query($sql, $session_fee_register_ref_no);
		}
		
		function update_group_session_fee_register_query($fields_data,$group_session_fee_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE practitioner_type_register_ref_no=?";
			return $this->db->query($sql, $group_session_fee_register_ref_no);
		}
		
		function update_expertise_register_query($fields_data,$practitioner_expertise_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE practitioner_expertise_register_ref_no=?";
			return $this->db->query($sql, $practitioner_expertise_register_ref_no);
		}
		
		function update_expertise_type_register_query($fields_data,$expertise_type_register_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE expertise_type_register_ref_no=?";
			return $this->db->query($sql, $expertise_type_register_ref_no);
		}

		function update_conference_session_info_query($fields_data,$conference_session_info_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE conference_session_info_ref_no IN 
			(SELECT conference_session_info_ref_no 
			FROM conference_session_trainer 
			WHERE conference_session_info_ref_no=?)";
			return $this->db->query($sql, $conference_session_info_ref_no);
		}
		
		function update_conference_session_info_attendee_query($fields_data,$conference_session_info_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE conference_session_info_ref_no IN 
			(SELECT conference_session_info_ref_no 
			FROM conference_session_attendee 
			WHERE conference_session_info_ref_no=?)";
			return $this->db->query($sql, $conference_session_info_ref_no);
		}	
		
		function update_conference_session_trainer_query($fields_data,$conference_session_trainer_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE conference_session_trainer_ref_no=?";
			return $this->db->query($sql, $conference_session_trainer_ref_no);
		}		
		
		function update_conference_session_attendee_query($fields_data,$conference_session_attendee_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE conference_session_attendee_ref_no=?";
			return $this->db->query($sql, $conference_session_attendee_ref_no);
		}	
		function update_supervision_session_trainer_query($fields_data,$supervision_session_trainer_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE supervision_session_trainer_ref_no=?";
			return $this->db->query($sql, $supervision_session_trainer_ref_no);
		}
		
		function update_supervision_session_attendee_query($fields_data,$supervision_session_attendee_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE supervision_session_attendee_ref_no=?";
			return $this->db->query($sql, $supervision_session_attendee_ref_no);
		}
		function update_training_session_attendee_query($fields_data,$training_session_attendee_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE training_session_attendee_ref_no=?";
			return $this->db->query($sql, $training_session_attendee_ref_no);
		}
		
		function update_training_session_info_query($fields_data,$training_session_trainer_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE training_session_info_ref_no IN 
			(SELECT training_session_info_ref_no 
			FROM training_session_trainer 
			WHERE training_session_trainer_ref_no=?)";
			return $this->db->query($sql, $training_session_trainer_ref_no);
		}	
		
		function update_training_session_trainer_query($fields_data,$training_session_trainer_ref_no, $type){
			$fields=array_keys($fields_data);
			$sql="UPDATE ".$type." 
			SET ";
			for ($i=0;$i<count($fields);$i++){
				$sql=$sql.$fields[$i]."='".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql."WHERE training_session_trainer_ref_no=?";
			return $this->db->query($sql, $training_session_trainer_ref_no);
		}
		
/////////////////////////////////////

		//fetch session class number of questionnaires
		function fetch_session_class_questionnaire_num_query($session_class_ref_no){
			$sql="SELECT COUNT(session_class_register_ref_no) AS num_questionnaires
			FROM session_class_register
			WHERE session_class_ref_no=?";
			return $this->db->query($sql,$session_class_ref_no);
		}
		//fetch questionnaire for a session_register_ref_no
		function fetch_questionnaires_query($session_register_ref_no){
			$sql="SELECT DISTINCT questionnaire.questionnaire_ref_no, questionnaire.name, questionnaire.type, questionnaire.number_of_questions
			FROM questionnaire
			JOIN session_class_register ON questionnaire.questionnaire_ref_no = session_class_register.questionnaire_ref_no
			JOIN session_class ON session_class_register.session_class_ref_no = session_class.session_class_ref_no
			JOIN session_register ON session_class.session_class_ref_no = session_register.session_class_ref_no
			WHERE session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		//fetch questiosn for a questionnaire
		function fetch_questions_query($questionnaire_ref_no){
			$sql="SELECT question.question_ref_no, question.question_number, question.question
			FROM question
			WHERE question.questionnaire_ref_no=? 
			ORDER BY question.question_number";
			return $this->db->query($sql,$questionnaire_ref_no);
		}
		
		//fetch the answers for a question
		function fetch_answers_query($question_ref_no){
			$sql="SELECT answer.answer_ref_no, answer.text_answer
			FROM answer
			WHERE answer.question_ref_no=?";
			return $this->db->query($sql,$question_ref_no);
		}
		
		//fetch the answers for a question number and a questionnaire
		function fetch_answers_question_query($question_number, $questionnaire_ref_no){
			$sql="SELECT answer.answer_ref_no, answer.text_answer
			FROM answer
			JOIN question ON question.question_ref_no = answer.question_ref_no
			WHERE question.question_number=?
			AND question.questionnaire_ref_no=?";
			return $this->db->query($sql,array($question_number,$questionnaire_ref_no));
		}
		
		//fetch client_session_register_ref_no for client questionnaire identification
		function fetch_client_register_query($client_ref_no, $session_ref_no){
			$sql="SELECT client_session_register_ref_no 
			FROM client_session_register
			WHERE client_ref_no=?
			AND session_register_ref_no=?";
			return $this->db->query($sql,array($client_ref_no, $session_ref_no));
		}
/////////////////////////////////////////////////		
		//fetch the client questionnaire for a client, a session_register id and a questionnaire id
		function fetch_client_questionnaire_query($client_session_register_ref_no, $questionnaire_ref_no){
			$sql="SELECT DISTINCT client_questionnaire.client_questionnaire_ref_no, client_questionnaire.questionnaire_text
			FROM client_questionnaire
			WHERE client_questionnaire.client_session_register_ref_no=?
			AND client_questionnaire.questionnaire_ref_no=?";
			return $this->db->query($sql,array($client_session_register_ref_no, $questionnaire_ref_no));
		}
		
		//fetch the client answers for a client_questionnaire
		function fetch_client_answers_query($client_questionnaire_ref_no){
			$sql="SELECT client_answer_ref_no, question_ref_no, answer_ref_no 
			FROM client_answer 
			WHERE client_questionnaire_ref_no=?";
			return $this->db->query($sql,$client_questionnaire_ref_no);
		}
/////////////////////////////////////////////////////
		//update query session_register
		function update_questionnaire_client_answer_query($fields_data,$client_questionnaire_ref_no, $question_ref_no){
			$sql="UPDATE client_answer 
			SET answer_ref_no='".$fields_data["answer_ref_no"]."' 
			WHERE client_questionnaire_ref_no=? 
			AND question_ref_no=? ";
			return $this->db->query($sql, array($client_questionnaire_ref_no, $question_ref_no));
		}
		
		function update_client_questionnaire($fields_data,$client_questionnaire_ref_no){
			$sql="UPDATE client_questionnaire
			SET questionnaire_text='".$fields_data["questionnaire_text"]."' 
			WHERE client_questionnaire_ref_no=?";
			return $this->db->query($sql,$client_questionnaire_ref_no);
		}
		
		function check_questionnaire_client_answer_query($client_questionnaire_ref_no, $question_ref_no){
			$sql="SELECT *
			FROM client_answer
			WHERE client_questionnaire_ref_no=? 
			AND question_ref_no=? ";
			return $this->db->query($sql, array($client_questionnaire_ref_no, $question_ref_no));
		}
		
		//get session class
		function fetch_session_class_query($session_class_ref_no){
			$sql="SELECT *
			FROM session_class
			WHERE session_class_ref_no=?";
			return $this->db->query($sql,$session_class_ref_no);
		}
		
		//get session class list
		function fetch_session_class_list_query(){
			$sql="SELECT session_class.*
			FROM session_class";
			return $this->db->query($sql);
		}
		//get session classes w questionnaires
		function fetch_session_class_questionnaire_list_query($session_class_ref_no){
			$sql="SELECT DISTINCT session_class_register.session_class_register_ref_no, questionnaire.questionnaire_ref_no, questionnaire.name, questionnaire.type
			FROM session_class
			JOIN session_class_register ON session_class.session_class_ref_no = session_class_register.session_class_ref_no
			JOIN questionnaire ON session_class_register.questionnaire_ref_no = questionnaire.questionnaire_ref_no
			WHERE session_class.session_class_ref_no=?";
			return $this->db->query($sql, $session_class_ref_no);
		}
		
		//get session classes w questionnaires
		function fetch_session_class_questionnaires_query($session_class_ref_no){
			$sql="SELECT DISTINCT session_class.class_title, questionnaire.name, questionnaire.type
			FROM session_class
			JOIN session_class_register ON session_class.session_class_ref_no = session_class_register.session_class_ref_no
			JOIN questionnaire ON session_class_register.questionnaire_ref_no = questionnaire.questionnaire_ref_no
			WHERE session_class.session_class_ref_no=?";
			return $this->db->query($sql, $session_class_ref_no);
		}
		//insert information in any table
		function insert_information_query($fields_data, $table_mod){
			$fields=array_keys($fields_data);//keys are the columns of table
			$sql="INSERT INTO ".$table_mod."(";//table_mod is the table name
			for ($i=0;$i<count($fields);$i++){//loop through columns
				$sql=$sql.$fields[$i];
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
			}
			
			$sql=$sql.") VALUES (";

			for ($i=0;$i<count($fields);$i++){//loop through data
				$sql=$sql."'".$fields_data[$fields[$i]]."'";
				if($i<count($fields)-1){
					$sql=$sql.",";
				}
				$sql=$sql." ";
			}
			$sql=$sql.")";
			$this->db->query($sql);
			return $sql;
			//return 
		}
		
		//fetch list of all groups
		function fetch_group_list_query(){
			$sql="SELECT DISTINCT _group.*, _type.type_title
			FROM _group
			JOIN expertise_type_register on _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no
			ORDER BY _group.group_ref_no, _group.is_active";
			return $this->db->query($sql);
		}
		
		//fetch list of all active groups
		function fetch_group_list_active_query(){
			$sql="SELECT DISTINCT _group.*
			FROM _group
			WHERE _group.is_active=true";
			return $this->db->query($sql);
		}
		
		function fetch_practitioners_for_type($type_ref_no){
			$sql="SELECT DISTINCT practitioner_register.practitioner_register_ref_no, alliance.first_name, alliance.last_name 
			FROM `expertise_register`
			JOIN  expertise_type_register ON expertise_type_register.expertise_ref_no =  expertise_register.expertise_ref_no
			JOIN  practitioner_register ON practitioner_register.practitioner_register_ref_no =  expertise_register.practitioner_register_ref_no
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE expertise_type_register.type_ref_no=?";
			return $this->db->query($sql,$type_ref_no);
		}
		
		//fetch lgroup and leader and type
		function fetch_group_query($group_ref_no){
			$sql="SELECT DISTINCT _group.*, expertise_type_register.expertise_ref_no, expertise_type_register.type_ref_no, alliance.first_name, alliance.last_name
			FROM _group
			JOIN expertise_type_register on _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN practitioner_register ON practitioner_register.practitioner_register_ref_no = _group.practitioner_register_ref_no
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no 
			WHERE _group.group_ref_no=?";
			return $this->db->query($sql,$group_ref_no);
		}
		
		//fetch list groups of which a practitioner is a leader
		function fetch_group_list_leader_query($practitioner_register_ref_no){
			$sql="SELECT _group.group_ref_no , _group.title
			FROM _group
			WHERE _group.practitioner_register_ref_no=?";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		// fetch attendance and volunteer for a practitioner and a session
		function fetch_practitioner_session_query($practitioner_register_ref_no, $session_register_ref_no){
			$sql="SELECT practitioner_session_register.practitioner_register_ref_no, practitioner_session_register.attendance,
			practitioner_session_register.volunteer, alliance.first_name, alliance.last_name
			FROM practitioner_session_register
			JOIN practitioner_register ON practitioner_register.practitioner_register_ref_no = practitioner_session_register.practitioner_register_ref_no 
			JOIN alliance ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE practitioner_register.practitioner_register_ref_no=?
			AND practitioner_session_register.session_register_ref_no=?";
			return $this->db->query($sql,array($practitioner_register_ref_no, $session_register_ref_no));
		}
		
		//financials//////////////////////////////////////////////////////////////
		function fetch_financial_valid_client_sessions_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date, session_register.scheduled_time_start, 
				session_register.scheduled_time_finish,  expertise_type_register.expertise_ref_no, _type.*, practitioner_session_register.old_fee, 
				practitioner_session_register.old_session_length
				FROM session_register
				JOIN client_session ON client_session.session_register_ref_no = session_register.session_register_ref_no
				JOIN expertise_type_register ON client_session.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
				JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no
				JOIN practitioner_session_register ON client_session.session_register_ref_no = practitioner_session_register.session_register_ref_no
				WHERE practitioner_session_register.practitioner_register_ref_no=?
				AND practitioner_session_register.volunteer=0
				AND session_register.admin_approved=1
                AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
				return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_cost_per_session_query($practitioner_register_ref_no){
			$sql="SELECT session_fee_register.cost_per_session, session_fee_register.session_length, expertise_register.expertise_ref_no, practitioner_type_register.type_ref_no
				FROM expertise_register
				JOIN practitioner_type_register ON practitioner_type_register.practitioner_expertise_register_ref_no = expertise_register.practitioner_expertise_register_ref_no
				JOIN session_fee_register ON session_fee_register.practitioner_type_register_ref_no = practitioner_type_register.practitioner_type_register_ref_no
				WHERE expertise_register.practitioner_register_ref_no=?";
				return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_financial_valid_group_sessions_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT DISTINCT session_register.session_register_ref_no,session_register.session_date, session_register.scheduled_time_start,session_register.scheduled_time_finish,
			_type.*, expertise_type_register.expertise_ref_no, practitioner_session_register.old_fee, 
				practitioner_session_register.old_session_length
				FROM session_register
				JOIN group_session ON group_session.session_register_ref_no = session_register.session_register_ref_no
				JOIN _group ON group_session.group_ref_no = _group.group_ref_no
				JOIN expertise_type_register ON _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
				JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no
				JOIN practitioner_session_register ON group_session.session_register_ref_no = practitioner_session_register.session_register_ref_no
				WHERE practitioner_session_register.practitioner_register_ref_no=?
				AND practitioner_session_register.volunteer=0
				AND session_register.admin_approved=1
				AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_cost_per_group_session_query($practitioner_register_ref_no){
			$sql="SELECT group_session_fee_register.cost_per_group_session,expertise_register.expertise_ref_no, practitioner_type_register.type_ref_no
				FROM expertise_register
				JOIN practitioner_type_register ON practitioner_type_register.practitioner_expertise_register_ref_no = expertise_register.practitioner_expertise_register_ref_no
				JOIN group_session_fee_register ON group_session_fee_register.practitioner_type_register_ref_no = practitioner_type_register.practitioner_type_register_ref_no
				WHERE expertise_register.practitioner_register_ref_no=?";
				return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_financial_valid_exit_sessions_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date 
			FROM session_register 
			JOIN exit_session ON exit_session.session_register_ref_no = session_register.session_register_ref_no 
			JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no 
			WHERE practitioner_session_register.practitioner_register_ref_no=? 
			AND practitioner_session_register.volunteer=0 
			AND session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_financial_valid_evaluation_sessions_query($practitioner_register_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,practitioner_session_register.*,
			session_register.scheduled_time_start,session_register.scheduled_time_finish, evaluation_session.evaluated_session_register_ref_no
			FROM session_register 
			JOIN evaluation_session ON evaluation_session.session_register_ref_no = session_register.session_register_ref_no 
			JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no 
			WHERE practitioner_session_register.practitioner_register_ref_no=? 
			AND practitioner_session_register.volunteer=0 
			AND session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$practitioner_register_ref_no);
		}
		
		function fetch_regime_user_alliance($user_ref_no){
			$sql="SELECT practitioner_register.practitioner_register_ref_no, alliance.regime, alliance.regime_fee
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no
			WHERE alliance.user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		function fetch_financial_evaluated_session_query($session_register_ref_no){
			$sql="SELECT session_register.session_register_ref_no, practitioner_session_register.practitioner_register_ref_no, expertise_type_register.expertise_ref_no,
			_type.*, session_register.session_register_ref_no,session_register.scheduled_time_start,session_register.scheduled_time_finish
			FROM session_register 
			JOIN client_session ON client_session.session_register_ref_no = session_register.session_register_ref_no 
			JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no 
			JOIN expertise_type_register ON client_session.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no
			WHERE session_register.session_register_ref_no=? ";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_financial_valid_supervision_sessions_query($alliance_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,
			session_register.scheduled_time_start,session_register.scheduled_time_finish, supervision_session_trainer.supervision_fee
			FROM session_register 
			JOIN supervision_session ON supervision_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN supervision_session_trainer ON supervision_session.supervision_session_ref_no = supervision_session_trainer.supervision_session_ref_no
			WHERE supervision_session_trainer.alliance_ref_no=? 
            AND session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_financial_valid_training_sessions_query($alliance_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,
			session_register.scheduled_time_start,session_register.scheduled_time_finish, training_session_trainer.intervention_fee
			FROM session_register 
			JOIN training_session ON training_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN training_session_trainer ON training_session.training_session_ref_no = training_session_trainer.training_session_ref_no
			WHERE training_session_trainer.alliance_ref_no=? 
			AND training_session_trainer.is_alliance=1
            AND session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_financial_conference_sessions_alliance_query($alliance_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,
			session_register.scheduled_time_start,session_register.scheduled_time_finish, conference_session.conference_session_ref_no, conference_session.conference_title, 
			conference_session_trainer.alliance_ref_no, conference_session_trainer.intervention_fee
			FROM session_register 
			JOIN conference_session ON conference_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN conference_session_trainer ON conference_session_trainer.conference_session_ref_no = conference_session.conference_session_ref_no
			WHERE conference_session_trainer.alliance_ref_no=? 
			AND conference_session_trainer.is_alliance=1
            AND session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_financial_conference_sessions_trainer_fees_monthly($start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,conference_session_trainer.is_client, conference_session_trainer.is_alliance,
			conference_session_trainer.intervention_fee
			FROM session_register 
			JOIN conference_session ON conference_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN conference_session_trainer ON conference_session_trainer.conference_session_ref_no = conference_session.conference_session_ref_no
			WHERE session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_financial_conference_trainer_fees_monthly($conference_session_ref_no){
			$sql="SELECT conference_session.conference_session_ref_no, conference_session_trainer.conference_session_trainer_ref_no,
			conference_session_trainer.intervention_fee
			FROM session_register 
			JOIN conference_session ON conference_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN conference_session_trainer ON conference_session_trainer.conference_session_ref_no = conference_session.conference_session_ref_no
			WHERE session_register.admin_approved=1
			AND conference_session.conference_session_ref_no=?";
			return $this->db->query($sql, $conference_session_ref_no);
		}
		
		function fetch_financial_supervision_sessions_trainer_fees_monthly($start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,supervision_session.supervision_session_ref_no,
			supervision_session_trainer.supervision_fee
			FROM session_register 
			JOIN supervision_session ON supervision_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN supervision_session_trainer ON supervision_session.supervision_session_ref_no = supervision_session_trainer.supervision_session_ref_no
			WHERE session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_financial_supervision_trainer_fees_monthly($supervision_session_ref_no){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,supervision_session_trainer.supervision_session_trainer_ref_no,
			supervision_session_trainer.supervision_fee
			FROM session_register 
			JOIN supervision_session ON supervision_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN supervision_session_trainer ON supervision_session.supervision_session_ref_no = supervision_session_trainer.supervision_session_ref_no
			WHERE session_register.admin_approved=1
			AND supervision_session.supervision_session_ref_no=?";
			return $this->db->query($sql,$supervision_session_ref_no);
		}
		
		function fetch_financial_training_sessions_trainer_fees_monthly($start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,training_session_trainer.is_client, training_session_trainer.is_alliance,
			training_session_trainer.intervention_fee
			FROM session_register 
			JOIN training_session ON training_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN training_session_trainer ON training_session.training_session_ref_no = training_session_trainer.training_session_ref_no
			WHERE session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_financial_training_trainer_fees_monthly($training_trainer_ref_no){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,training_session_trainer.training_session_trainer_ref_no,
			training_session_trainer.intervention_fee
			FROM session_register 
			JOIN training_session ON training_session.session_register_ref_no = session_register.session_register_ref_no
			JOIN training_session_trainer ON training_session.training_session_ref_no = training_session_trainer.training_session_ref_no
			WHERE session_register.admin_approved=1
			AND training_session.training_session_ref_no=?";
			return $this->db->query($sql,$training_trainer_ref_no);
		}
		
		function fetch_financial_conference_sessions_query($start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,
			conference_session.conference_session_ref_no, conference_session.conference_title,
			conference_session.attendee_fee, conference_session.alliance_fee
			FROM session_register 
			JOIN conference_session ON conference_session.session_register_ref_no = session_register.session_register_ref_no
			WHERE session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_financial_training_sessions_query($start_of_month,$end_of_month){
			$sql="SELECT session_register.session_register_ref_no, session_register.session_date,
			training_session.training_session_ref_no, training_session.training_title
			FROM session_register 
			JOIN training_session ON training_session.session_register_ref_no = session_register.session_register_ref_no
			WHERE session_register.admin_approved=1
			AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_stable_cost($stable_cost_ref_no){
			$sql="SELECT * 
			FROM stable_cost
			WHERE stable_cost_ref_no=?";
			return $this->db->query($sql,$stable_cost_ref_no);
		}
		function fetch_practitioner_list(){
			$sql="SELECT alliance.*
			FROM practitioner_register
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no
			WHERE alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		
		function fetch_administrator_list(){
			$sql="SELECT alliance.*
			FROM administrator_register
			JOIN alliance ON alliance.alliance_ref_no = administrator_register.alliance_ref_no
			WHERE CAST(alliance.date_left AS DATE)>CAST('".date('Y-m', strtotime ( '-1 year' , strtotime ( date('Y-m') ) )).'-01'."' AS DATE)
			OR alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		
		function fetch_handyman_list(){
			$sql="SELECT alliance.*
			FROM handymen_register
			JOIN alliance ON alliance.alliance_ref_no = handymen_register.alliance_ref_no
			WHERE alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		//fetch all one on one session and exit sessions
		function fetch_session_list_for_client($client_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT practitioner_session_register.old_fee,practitioner_session_register.old_session_length, session_register.scheduled_time_start,
				session_register.scheduled_time_finish
				FROM client_session_register
				JOIN session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
				JOIN practitioner_session_register ON client_session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no
				WHERE client_session_register.client_ref_no=?
				AND practitioner_session_register.volunteer=0
				AND session_register.admin_approved=1
                AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
				return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_one_on_one_sessions_client($client_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT COUNT(session_register.session_register_ref_no) AS total_sessions
				FROM client_session_register
				JOIN session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
				JOIN client_session ON client_session.session_register_ref_no = session_register.session_register_ref_no
				WHERE client_session_register.client_ref_no=?
				AND session_register.admin_approved=1
				AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_group_sessions_client($client_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT COUNT(session_register.session_register_ref_no) AS total_sessions
				FROM client_session_register
				JOIN session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
				JOIN group_session ON group_session.session_register_ref_no = session_register.session_register_ref_no
				WHERE client_session_register.client_ref_no=?
				AND session_register.admin_approved=1
				AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_conference_sessions_client($client_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT COUNT(conference_session.conference_session_ref_no) AS total_sessions
				FROM conference_session
				JOIN conference_session_attendee ON conference_session_attendee.conference_session_ref_no = conference_session.conference_session_ref_no
				JOIN session_register ON session_register.session_register_ref_no = conference_session.session_register_ref_no
				WHERE conference_session_attendee.client_ref_no=?
				AND CAST(session_register.session_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
                AND CAST(session_register.session_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function remove_supervisor_from_supervision_trainer_list_query($supervision_session_trainer_ref_no){
			$sql="DELETE 
			FROM supervision_session_trainer
			WHERE supervision_session_trainer_ref_no=?";
			return $this->db->query($sql,$supervision_session_trainer_ref_no);
		}
		
		function remove_attendee_from_supervision_attendee_list_query($supervision_session_attendee_ref_no){
			$sql="DELETE 
			FROM supervision_session_attendee
			WHERE supervision_session_attendee_ref_no=?";
			return $this->db->query($sql,$supervision_session_attendee_ref_no);
		}
		function remove_trainer_external_from_training_trainer_register_query($training_session_info_ref_no){
			$sql="DELETE 
			FROM training_session_info
			WHERE training_session_info_ref_no=?";
			return $this->db->query($sql,$training_session_info_ref_no);
		}
		
		function remove_trainer_internal_from_training_trainer_register_query($training_session_trainer_ref_no){
			$sql="DELETE 
			FROM training_session_trainer
			WHERE training_session_trainer_ref_no=?";
			return $this->db->query($sql,$training_session_trainer_ref_no);
		}
		
		function remove_trainer_external_from_conference_trainer_register_query($conference_session_info_ref_no){
			$sql="DELETE 
			FROM conference_session_info
			WHERE conference_session_info_ref_no=?";
			return $this->db->query($sql,$conference_session_info_ref_no);
		}
		
		function remove_trainer_internal_from_conference_trainer_register_query($conference_session_trainer_ref_no){
			$sql="DELETE 
			FROM conference_session_trainer
			WHERE conference_session_trainer_ref_no=?";
			return $this->db->query($sql,$conference_session_trainer_ref_no);
		}
		
		function remove_attendee_from_training_attendee_list_query($training_session_attendee_ref_no){
			$sql="DELETE 
			FROM training_session_attendee
			WHERE training_session_attendee_ref_no=?";
			return $this->db->query($sql,$training_session_attendee_ref_no);
		}
		
		function remove_attendee_external_from_conference_attendee_register_query($conference_session_info_ref_no){
			$sql="DELETE 
			FROM conference_session_info
			WHERE conference_session_info_ref_no=?";
			return $this->db->query($sql,$conference_session_info_ref_no);
		}
		
		function remove_attendee_internal_from_conference_attendee_register_query($conference_session_attendee_ref_no){
			$sql="DELETE 
			FROM conference_session_attendee
			WHERE conference_session_attendee_ref_no=?";
			return $this->db->query($sql,$conference_session_attendee_ref_no);
		}
		
		function remove_trauma_from_trauma_register_list_query($trauma_ref_no, $client_ref_no){
			$sql="DELETE 
			FROM trauma_register
			WHERE trauma_ref_no=?
			AND client_ref_no=?";
			return $this->db->query($sql,array($trauma_ref_no, $client_ref_no));
		}
		
		function remove_expertise_from_expertise_register_list_query($practitioner_expertise_register_ref_no){
			$sql="DELETE 
			FROM expertise_register
			WHERE practitioner_expertise_register_ref_no=?";
			return $this->db->query($sql,$practitioner_expertise_register_ref_no);
		}
		
		function remove_type_from_type_register_list_query($practitioner_expertise_register_ref_no,$type_ref_no){
			$sql="DELETE 
			FROM practitioner_type_register
			WHERE practitioner_expertise_register_ref_no=?
			AND type_ref_no=?";
			return $this->db->query($sql,array($practitioner_expertise_register_ref_no,$type_ref_no));
		}
		
		function remove_expertise_type_register_from_expertise_type_register_list_query($type_ref_no, $expertise_ref_no){
			$sql="DELETE 
			FROM expertise_type_register
			WHERE type_ref_no=?
			AND expertise_ref_no=?";
			return $this->db->query($sql,array($type_ref_no, $expertise_ref_no));
		}
		
		function remove_questionnaire_from_session_class_list_query($questionnaire_ref_no, $session_class_ref_no){
			$sql="DELETE 
			FROM session_class_register
			WHERE questionnaire_ref_no=?
			AND session_class_ref_no=?";
			return $this->db->query($sql,array($questionnaire_ref_no, $session_class_ref_no));
		}
		function remove_client_answer_query($client_questionnaire_ref_no, $question_ref_no){
			$sql="DELETE 
			FROM client_answer
			WHERE client_questionnaire_ref_no=?
			AND question_ref_no=?";
			return $this->db->query($sql,array($client_questionnaire_ref_no, $question_ref_no));
		}
		
		//delete client from session
		function remove_client_from_session_list_query($client_ref_no, $session_register_ref_no){
			$sql="DELETE 
			FROM client_session_register
			WHERE client_ref_no=?
			AND session_register_ref_no=?";
			return $this->db->query($sql,array($client_ref_no, $session_register_ref_no));
		}
		
		//delete client from session
		function remove_practitioner_from_session_list_query($practitioner_register_ref_no, $session_register_ref_no){
			$sql="DELETE 
			FROM practitioner_session_register
			WHERE practitioner_register_ref_no=?
			AND session_register_ref_no=?";
			return $this->db->query($sql,array($practitioner_register_ref_no, $session_register_ref_no));
		}
		
		function remove_question_from_question_list_query($question_ref_no){
			$sql="DELETE 
			FROM question
			WHERE question_ref_no=?";
			return $this->db->query($sql,$question_ref_no);
		}
		
		function remove_answer_from_answer_list_query($answer_ref_no){
			$sql="DELETE 
			FROM answer
			WHERE answer_ref_no=?";
			return $this->db->query($sql,$answer_ref_no);
		}
		
		function remove_client_questionnaire_query($client_session_register_ref_no, $questionnaire_ref_no){
			$sql="DELETE 
			FROM client_questionnaire
			WHERE client_session_register_ref_no=?
			AND questionnaire_ref_no=?";
			return $this->db->query($sql,array($client_session_register_ref_no, $questionnaire_ref_no));
		}
		//fetch group leader from group_ref_no
		function fetch_group_leader_for_group_query($group_ref_no){
			$sql="SELECT group_ref_no, practitioner_register_ref_no
			FROM _group
			WHERE group_ref_no=?";
			return $this->db->query($sql,$group_ref_no);
		}
		
		function fetch_alliance_list_all_query($date_chosen){
			$sql="SELECT alliance.* 
			FROM alliance
			WHERE CAST(alliance.date_joined AS DATE)<CAST('".$date_chosen."' AS DATE)";
			return $this->db->query($sql);
		}
		
		//fetch alliance join info
		function fetch_alliance_list_query($date_chosen){
			$sql="SELECT alliance.* 
			FROM alliance
			WHERE CAST(alliance.date_joined AS DATE)<=CAST('".$date_chosen."' AS DATE)
			AND alliance.date_left='0000-00-00'";
			return $this->db->query($sql);
		}
		//fetch alliance join info
		function fetch_alliance_list_calendar_query(){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name 
			FROM alliance
			JOIN calendar ON calendar.alliance_ref_no = alliance.alliance_ref_no";
			return $this->db->query($sql);
		}
		
		//fetch alliance join info
		function fetch_alliance_user_info_query($user_ref_no){
			$sql="SELECT *
			FROM alliance
			WHERE user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		//fetch alliance join info
		function fetch_alliance_info_query($alliance_ref_no){
			$sql="SELECT *
			FROM alliance
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		//fetch alliance join info
		function fetch_alliance_join_info_query($user_ref_no){
			$sql="SELECT alliance_ref_no, date_joined, date_left 
			FROM alliance 
			WHERE user_ref_no=?";
			return $this->db->query($sql,$user_ref_no);
		}
		
		//fetch alliance join info
		function fetch_alliance_calendar_query($alliance_ref_no){
			$sql="SELECT calendar_ref_no 
			FROM calendar 
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		//fetch alliance join info
		function fetch_calendar_alliance_query($calendar_ref_no){
			$sql="SELECT alliance.* 
			FROM calendar
			JOIN alliance ON calendar.alliance_ref_no = alliance.alliance_ref_no	
			WHERE calendar_ref_no=?";
			return $this->db->query($sql,$calendar_ref_no);
		}
		
		//fetch all entered dates for fulltime
		function fetch_entered_calendar_days($alliance_ref_no){
			$sql="SELECT DISTINCT calendar_day.*
			FROM `calendar_day` 
			JOIN calendar ON calendar_day.calendar_ref_no = calendar.calendar_ref_no
			WHERE alliance_ref_no=?
			ORDER BY calendar_day.calendar_day_date";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_entered_calendar_days_invalid($alliance_ref_no){
			$sql="SELECT DISTINCT calendar_day.*
			FROM `calendar_day` 
			JOIN calendar ON calendar_day.calendar_ref_no = calendar.calendar_ref_no
			WHERE alliance_ref_no=?
			AND admin_approved=0
			ORDER BY calendar_day.calendar_day_date";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_calendar_day_calendar_date_query($calendar_ref_no, $calendar_day_date){
			$sql="SELECT *
			FROM calendar_day 
			WHERE calendar_ref_no=?
			AND calendar_day_date='".$calendar_day_date."'";
			return $this->db->query($sql,$calendar_ref_no);
		}
		
		//fetch either approved hours or non approved hours
		function fetch_calendar_day_hours_sum_query($calendar_ref_no,$admin_approved,$start_of_month,$end_of_month){
			$sql="SELECT SUM(worked_hours) AS total_worked_hours, SUM(overtime_hours) AS total_overtime_hours
			FROM calendar_day 
			WHERE calendar_ref_no=?
			AND admin_approved=?
			AND CAST(calendar_day_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(calendar_day_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,array($calendar_ref_no,$admin_approved));
		}
		
		function fetch_calendar_count_absences_query($calendar_ref_no,$admin_approved,$start_of_month,$end_of_month){
			$sql="SELECT COUNT(calendar_day_ref_no) AS count_absences
			FROM calendar_day 
			WHERE calendar_ref_no=?
			AND absence_day=1
			AND admin_approved=?
			AND CAST(calendar_day_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(calendar_day_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,array($calendar_ref_no,$admin_approved));
		}
		
		function fetch_calendar_count_vacation_query($calendar_ref_no,$admin_approved,$start_of_month,$end_of_month){
			$sql="SELECT COUNT(calendar_day_ref_no) as count_vacations
			FROM calendar_day 
			WHERE calendar_ref_no=?
			AND vacation_day=1
			AND admin_approved=?
			AND CAST(calendar_day_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(calendar_day_date AS DATE)< CAST('".$end_of_month."' AS DATE)";
			return $this->db->query($sql,array($calendar_ref_no,$admin_approved));
		}
		
		function fetch_session_one_on_one_approval_admin_query(){
			$sql="SELECT session_register.*, _type.type_title, _client.client_ref_no, _client.first_name, _client.last_name, client_session.* 
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN _client ON client_session_register.client_ref_no = _client.client_ref_no
			JOIN client_session ON session_register.session_register_ref_no = client_session.session_register_ref_no
			JOIN expertise_type_register ON client_session.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON expertise_type_register.type_ref_no = _type.type_ref_no 
			WHERE admin_approved=0";
			return $this->db->query($sql);
		}
		
		function fetch_session_group_approval_admin_query(){
			$sql="SELECT DISTINCT session_register.session_register_ref_no,session_register.session_date, _type.type_title, group_session.practitioner_register_ref_no
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN group_session ON session_register.session_register_ref_no = group_session.session_register_ref_no
			JOIN _group ON group_session.group_ref_no = _group.group_ref_no
			JOIN expertise_type_register ON _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no
			WHERE admin_approved=0";
			return $this->db->query($sql);
		}
		
		function fetch_session_exit_approval_admin_query(){
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date, client_session_register.client_ref_no 
			FROM session_register
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN exit_session ON session_register.session_register_ref_no = exit_session.session_register_ref_no
			WHERE admin_approved=0";
			return $this->db->query($sql);
		}
		
		function fetch_session_evaluation_approval_admin_query(){
			$sql="SELECT session_register.session_register_ref_no,session_register.session_date, evaluation_session.evaluated_session_register_ref_no, practitioner_register.practitioner_register_ref_no AS 'evaluator' 
			FROM session_register
			JOIN practitioner_session_register ON practitioner_session_register.session_register_ref_no = session_register.session_register_ref_no
			JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no
			JOIN evaluation_session ON session_register.session_register_ref_no = evaluation_session.session_register_ref_no
			WHERE admin_approved=0";
			return $this->db->query($sql);
		}
		
		//fetch trauma list
		function fetch_trauma_list(){
			$sql="SELECT DISTINCT *
			FROM trauma";
			return $this->db->query($sql);
		}
		
		//fetch trauma list
		function fetch_current_trauma_list($client_ref_no){
			$sql="SELECT DISTINCT trauma_register.trauma_register_ref_no, trauma.*
			FROM trauma_register
			JOIN trauma ON trauma.trauma_ref_no = trauma_register.trauma_ref_no
			WHERE trauma_register.client_ref_no=?";
			return $this->db->query($sql,$client_ref_no);
		}
		
		//fetch type list
		function fetch_type_list(){
			$sql="SELECT DISTINCT *
			FROM _type";
			return $this->db->query($sql);
		}
		
		//fetch type list
		function fetch_expertise_list(){
			$sql="SELECT expertise.*
			FROM expertise";
			return $this->db->query($sql);
		}
		
		//fetch type list
		function fetch_expertise_practitioner_list($alliance_ref_no){
			$sql="SELECT expertise_register.practitioner_expertise_register_ref_no, expertise_register.expertise_ref_no, expertise.expertise 
			FROM expertise_register 
			JOIN expertise ON expertise.expertise_ref_no = expertise_register.expertise_ref_no 
			JOIN practitioner_register ON practitioner_register.practitioner_register_ref_no= expertise_register.practitioner_register_ref_no 
			WHERE practitioner_register.alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		//fetch trauma for trauma ref no
		function fetch_trauma_for_trauma($trauma_ref_no){
			$sql="SELECT *
			FROM trauma
			WHERE trauma_ref_no=?";
			return $this->db->query($sql,$trauma_ref_no);
		}
		
		function fetch_questionnaire_questions_query($questionnaire_ref_no){
			$sql="SELECT question_ref_no, question_number, question
			FROM question
			WHERE questionnaire_ref_no=?";
			return $this->db->query($sql,$questionnaire_ref_no);
		}
		
		function fetch_questionnaire_query($questionnaire_ref_no){
			$sql="SELECT *
			FROM questionnaire
			WHERE questionnaire_ref_no=?";
			return $this->db->query($sql,$questionnaire_ref_no);
		}
		
		function fetch_type_query($type_ref_no){
			$sql="SELECT *
			FROM _type
			WHERE type_ref_no=?";
			return $this->db->query($sql,$type_ref_no);
		}
		
		function fetch_expertise_query($expertise_ref_no){
			$sql="SELECT *
			FROM expertise
			WHERE expertise_ref_no=?";
			return $this->db->query($sql,$expertise_ref_no);
		}
		
		function fetch_training_trainers_alliance_query($session_register_ref_no){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name, training_session_trainer.*
			FROM training_session_trainer
			JOIN training_session ON training_session.training_session_ref_no= training_session_trainer.training_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = training_session_trainer.alliance_ref_no
			WHERE training_session.session_register_ref_no=?
			AND training_session_trainer.is_alliance=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		function fetch_training_trainers_client_query($session_register_ref_no){
			$sql="SELECT _client.client_ref_no, _client.first_name, _client.last_name, training_session_trainer.*
			FROM training_session_trainer
			JOIN training_session ON training_session.training_session_ref_no= training_session_trainer.training_session_ref_no
			JOIN _client ON _client.client_ref_no = training_session_trainer.client_ref_no
			WHERE training_session.session_register_ref_no=?
			AND training_session_trainer.is_client=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_training_trainers_independent_query($session_register_ref_no){
			$sql="SELECT training_session_trainer.*, training_session_info.*
			FROM training_session_trainer
			JOIN training_session ON training_session.training_session_ref_no= training_session_trainer.training_session_ref_no
			JOIN training_session_info ON training_session_trainer.training_session_info_ref_no = training_session_info.training_session_info_ref_no
			WHERE training_session.session_register_ref_no=?
			AND training_session_trainer.is_client=0
			AND training_session_trainer.is_alliance=0";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_training_session_attendees_list_query($session_register_ref_no){
			$sql="SELECT training_session_attendee.training_session_attendee_ref_no, alliance.*
			FROM training_session_attendee
			JOIN training_session ON training_session.training_session_ref_no= training_session_attendee.training_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = training_session_attendee.alliance_ref_no
			WHERE training_session.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_conference_trainers_alliance_query($session_register_ref_no){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name, conference_session_trainer.*
			FROM conference_session_trainer
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_trainer.conference_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = conference_session_trainer.alliance_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_trainer.is_alliance=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		function fetch_conference_trainers_client_query($session_register_ref_no){
			$sql="SELECT _client.client_ref_no, _client.first_name, _client.last_name, conference_session_trainer.*
			FROM conference_session_trainer
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_trainer.conference_session_ref_no
			JOIN _client ON _client.client_ref_no = conference_session_trainer.client_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_trainer.is_client=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_conference_trainers_independent_query($session_register_ref_no){
			$sql="SELECT conference_session_trainer.*, conference_session_info.*
			FROM conference_session_trainer
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_trainer.conference_session_ref_no
			JOIN conference_session_info ON conference_session_trainer.conference_session_info_ref_no = conference_session_info.conference_session_info_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_trainer.is_client=0
			AND conference_session_trainer.is_alliance=0";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_conference_attendees_alliance_query($session_register_ref_no){
			$sql="SELECT alliance.alliance_ref_no, alliance.first_name, alliance.last_name, conference_session_attendee.*
			FROM conference_session_attendee
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_attendee.conference_session_ref_no
			JOIN alliance ON alliance.alliance_ref_no = conference_session_attendee.alliance_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_attendee.is_alliance=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		function fetch_conference_attendees_clients_query($session_register_ref_no){
			$sql="SELECT _client.client_ref_no, _client.first_name, _client.last_name, conference_session_attendee.*
			FROM conference_session_attendee
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_attendee.conference_session_ref_no
			JOIN _client ON _client.client_ref_no = conference_session_attendee.client_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_attendee.is_client=1";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_conference_attendees_independent_query($session_register_ref_no){
			$sql="SELECT conference_session_attendee.*, conference_session_info.*
			FROM conference_session_attendee
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_attendee.conference_session_ref_no
			JOIN conference_session_info ON conference_session_attendee.conference_session_info_ref_no = conference_session_info.conference_session_info_ref_no
			WHERE conference_session.session_register_ref_no=?
			AND conference_session_attendee.is_alliance=0";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_conference_attendees_query($session_register_ref_no){
			$sql="SELECT conference_session_attendee.conference_session_attendee_ref_no, conference_session_attendee.fee_type, conference_session_attendee.is_alliance,conference_session_attendee.is_client
			FROM conference_session_attendee
			JOIN conference_session ON conference_session.conference_session_ref_no= conference_session_attendee.conference_session_ref_no
			WHERE conference_session.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_alliance_ids_unique(){
			$sql="SELECT DISTINCT alliance_id
			FROM alliance";
			return $this->db->query($sql);
		}
		
		function fetch_client_ids_unique(){
			$sql="SELECT DISTINCT client_id
			FROM _client";
			return $this->db->query($sql);
		}
		function fetch_sessions_of_type_for_practitioner($alliance_ref_no,$session_type){
			$sql="SELECT ".$session_type."_session.session_register_ref_no 
				FROM ".$session_type."_session 
				JOIN practitioner_session_register ON ".$session_type."_session.session_register_ref_no = practitioner_session_register.session_register_ref_no 
				JOIN practitioner_register ON practitioner_session_register.practitioner_register_ref_no = practitioner_register.practitioner_register_ref_no 
				JOIN session_register ON session_register.session_register_ref_no = ".$session_type."_session.session_register_ref_no
				WHERE  CAST(session_register.session_date AS DATE)>= CAST('".date("Y-m-d", strtotime(date("Y-m-d"). "-6 months"))."' AS DATE)
				AND CAST(session_register.session_date AS DATE)< CAST('".date("Y-m-d")."' AS DATE)";
				if(!$this->session->userdata('is_admin')){
					$sql=$sql."AND practitioner_register.alliance_ref_no=?";
				}
				return $this->db->query($sql, $alliance_ref_no);
		}
		
		function fetch_training_sessions_for_practitioner($alliance_ref_no){
			$sql="SELECT session_register_ref_no
			FROM training_session 
			WHERE training_session.training_session_ref_no IN
				(SELECT training_session_trainer.training_session_ref_no 
				FROM training_session_trainer
				WHERE training_session_trainer.alliance_ref_no=?)
				OR
				training_session.training_session_ref_no IN
				(SELECT training_session_attendee.training_session_ref_no 
				FROM training_session_attendee
				WHERE training_session_attendee.alliance_ref_no=?)";
			return $this->db->query($sql,array($alliance_ref_no,$alliance_ref_no));
		}
		
		function fetch_training_sessions_for_admin(){
			$sql="SELECT session_register_ref_no
			FROM training_session";
			return $this->db->query($sql,array($alliance_ref_no,$alliance_ref_no));
		}
		
		function fetch_conference_sessions_for_admin(){
			$sql="SELECT session_register_ref_no
			FROM conference_session";
			return $this->db->query($sql,array($alliance_ref_no,$alliance_ref_no));
		}
		
		function fetch_external_cost_list_not_valid_query($external_cost_type){
			$sql="SELECT *
			FROM external_cost";
			if($external_cost_type=="travel_cost" || $external_cost_type=="group_external_cost"){
				$sql=$sql." JOIN alliance ON alliance.alliance_ref_no = external_cost.alliance_ref_no";
			}
			$sql=$sql." WHERE admin_approved=0
			AND external_cost_type=?
			ORDER BY external_cost_submit_date DESC";
			return $this->db->query($sql,$external_cost_type);
		}
		function fetch_financial_external_costs_query($alliance_ref_no,$start_of_month,$end_of_month){
			$sql="SELECT *
			FROM external_cost
			WHERE CAST(external_cost_approval_date AS DATE)>= CAST('".$start_of_month."' AS DATE)
            AND CAST(external_cost_approval_date AS DATE)< CAST('".$end_of_month."' AS DATE)
			AND alliance_ref_no=?
			AND admin_approved=1
			ORDER BY external_cost_submit_date DESC";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_current_fee_client_session($practitioner_register_ref_no,$expertise_type_register_ref_no ){
			$sql="SELECT session_fee_register.cost_per_session,session_fee_register.session_length
			FROM session_fee_register 
			JOIN practitioner_type_register ON practitioner_type_register.practitioner_type_register_ref_no = session_fee_register.practitioner_type_register_ref_no
			JOIN expertise_register ON expertise_register.practitioner_expertise_register_ref_no = practitioner_type_register.practitioner_expertise_register_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_ref_no = expertise_register.expertise_ref_no
			WHERE practitioner_type_register.type_ref_no=expertise_type_register.type_ref_no
			AND expertise_register.practitioner_register_ref_no=?
			AND expertise_type_register.expertise_type_register_ref_no=?";
			return $this->db->query($sql,array($practitioner_register_ref_no,$expertise_type_register_ref_no));
		}
		
		function fetch_current_fee_group_session($practitioner_register_ref_no,$group_ref_no ){
			$sql="SELECT group_session_fee_register.cost_per_group_session,_group.session_length
			FROM group_session_fee_register 
			JOIN practitioner_type_register ON practitioner_type_register.practitioner_type_register_ref_no = group_session_fee_register.practitioner_type_register_ref_no
			JOIN expertise_register ON expertise_register.practitioner_expertise_register_ref_no = practitioner_type_register.practitioner_expertise_register_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_ref_no = expertise_register.expertise_ref_no
			JOIN _group ON _group.expertise_type_register_ref_no = expertise_type_register.expertise_type_register_ref_no
			WHERE practitioner_type_register.type_ref_no=expertise_type_register.type_ref_no
			AND expertise_register.practitioner_register_ref_no=?
			AND _group.group_ref_no=?";
			return $this->db->query($sql,array($practitioner_register_ref_no,$group_ref_no));
		}
		
		function fetch_old_length_evaluation_session_query($session_register_ref_no){
			$sql="SELECT old_session_length 
			FROM practitioner_session_register 
			WHERE session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_client_session_list_evaluation_for_practitioner($practitioner_register_ref_no){
			$sql="SELECT client_session.session_register_ref_no
			FROM client_session 
			JOIN practitioner_session_register ON client_session.session_register_ref_no = practitioner_session_register.session_register_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_type_register_ref_no = client_session.expertise_type_register_ref_no 
			JOIN expertise_register ON expertise_register.expertise_ref_no = expertise_type_register.expertise_ref_no 
			JOIN practitioner_type_register ON practitioner_type_register.practitioner_expertise_register_ref_no = expertise_register.practitioner_expertise_register_ref_no 
			WHERE practitioner_type_register.type_ref_no=expertise_type_register.type_ref_no 
			AND practitioner_session_register.practitioner_register_ref_no!=?
			AND expertise_register.practitioner_register_ref_no=?
			AND client_session.session_register_ref_no NOT IN
			(SELECT evaluated_session_register_ref_no
			FROM evaluation_session);";
			return $this->db->query($sql,array($practitioner_register_ref_no,$practitioner_register_ref_no));
		}
		
		function get_list_client_date_joined_query($session_date){
			$sql="SELECT client_ref_no, first_name, last_name
			FROM _client
			WHERE CAST(date_joined AS DATE)<= CAST('".$session_date."' AS DATE)
			AND activity_level!=0";
			return $this->db->query($sql);
		}
		
		function get_list_practitioner_date_joined_query($session_date){
			$sql="SELECT practitioner_register_ref_no, first_name, last_name
			FROM alliance
			JOIN practitioner_register ON practitioner_register.alliance_ref_no = alliance.alliance_ref_no
			WHERE CAST(date_joined AS DATE)<= CAST('".$session_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function get_list_alliance_date_joined_query($session_date){
			$sql="SELECT alliance_ref_no, first_name, last_name
			FROM alliance
			WHERE CAST(date_joined AS DATE)<= CAST('".$session_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_expertise_type_for_expertise_type_practitioner_query($practitioner_register_ref_no,$expertise_ref_no,$type_ref_no){
			$sql="SELECT expertise_type_register_ref_no 
			FROM expertise_type_register 
			JOIN expertise_register ON expertise_register.expertise_ref_no = expertise_type_register.expertise_ref_no 
			JOIN practitioner_type_register ON practitioner_type_register.type_ref_no = expertise_type_register.type_ref_no 
			WHERE expertise_register.practitioner_register_ref_no=? 
			AND expertise_register.expertise_ref_no=? 
			AND practitioner_type_register.type_ref_no=?";
			return $this->db->query($sql,array($practitioner_register_ref_no,$expertise_ref_no,$type_ref_no));
		}
		
		function check_regime_query($alliance_ref_no, $start_date){
			$sql="SELECT regime_register_ref_no, old_regime, old_regime_fee
			FROM regime_register
			WHERE CAST(start_date AS DATE)<= CAST('".$start_date."' AS DATE)
			AND CAST(end_date AS DATE)> CAST('".$start_date."' AS DATE)
			AND alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		function check_regime_practitioner_query($alliance_ref_no, $start_date){
			$sql="SELECT old_regime, old_regime_fee
			FROM regime_register
			JOIN practitioner_register ON practitioner_register.alliance_ref_no = regime_register.alliance_ref_no
			WHERE CAST(start_date AS DATE)<= CAST('".$start_date."' AS DATE)
			AND CAST(end_date AS DATE)> CAST('".$start_date."' AS DATE)
			AND alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		function old_regime_list_query($alliance_ref_no){
			$sql="SELECT *
			FROM regime_register
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_max_end_date_regime_register($alliance_ref_no){
			$sql="SELECT MAX(end_date) AS end_date
			FROM `regime_register` 
			WHERE alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_external_costs_for_month($start_date,$end_date){
			$sql="SELECT *
			FROM external_cost
			WHERE CAST(external_cost_submit_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(external_cost_submit_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_donations_for_month($start_date,$end_date){
			$sql="SELECT *
			FROM donation
			WHERE CAST(donation_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(donation_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_contracts_for_month($start_date,$end_date){
			$sql="SELECT *
			FROM contract
			WHERE CAST(contract_submission_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(contract_submission_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_session_type_list($session_type){
			$sql="SELECT session_register.session_register_ref_no
			FROM ".$session_type."_session
			JOIN session_register ON session_register.session_register_ref_no = ".$session_type."_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".date("Y-m-d", strtotime(date("Y-m-d"). "-6 months"))."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".date("Y-m-d")."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function fetch_external_cost_month_alliance($alliance_ref_no, $external_cost_type, $start_date, $end_date){
			$sql="SELECT external_cost_amount
			FROM external_cost 
			WHERE alliance_ref_no=?
			AND external_cost_type=?
			AND admin_approved=1
			AND CAST(external_cost_submit_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(external_cost_submit_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql, array($alliance_ref_no, $external_cost_type));
		}
		
		function fetch_external_cost_month($external_cost_type, $start_date, $end_date){
			$sql="SELECT external_cost_amount
			FROM external_cost 
			WHERE external_cost_type=?
			AND admin_approved=1
			AND CAST(external_cost_submit_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(external_cost_submit_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql, $external_cost_type);
		}
		
		function fetch_count_of_expertise_type_query($client_ref_no,$expertise_type_register_ref_no){
			$sql="SELECT COUNT(client_session.expertise_type_register_ref_no) AS number_of_expertise_type FROM client_session_register
			JOIN client_session ON client_session.session_register_ref_no = client_session_register.session_register_ref_no
			WHERE client_session_register.client_ref_no=?
			AND client_session.expertise_type_register_ref_no=?";
			return $this->db->query($sql, array($client_ref_no,$expertise_type_register_ref_no));
		}
		
		function fetch_expertise_types_client_query($client_ref_no){
			$sql="SELECT DISTINCT client_session.expertise_type_register_ref_no, expertise.expertise, _type.type_title
			FROM client_session_register
			JOIN client_session ON client_session.session_register_ref_no = client_session_register.session_register_ref_no
			JOIN expertise_type_register ON expertise_type_register.expertise_type_register_ref_no = client_session.expertise_type_register_ref_no
			JOIN expertise ON expertise.expertise_ref_no = expertise_type_register.expertise_ref_no
			JOIN _type ON _type.type_ref_no = expertise_type_register.type_ref_no
			WHERE client_session_register.client_ref_no=?";
			return $this->db->query($sql, $client_ref_no);
		}
		
		function fetch_client_questionnaire_earliest_query($client_ref_no){
			$sql="SELECT client_questionnaire.client_questionnaire_ref_no, session_register.session_date , client_questionnaire.questionnaire_text
			FROM `client_questionnaire`
			JOIN client_session_register ON client_session_register.client_session_register_ref_no = client_questionnaire.client_session_register_ref_no
            JOIN session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
			WHERE client_questionnaire.client_questionnaire_ref_no IN (
			SELECT MIN(client_questionnaire_ref_no)
			FROM `client_questionnaire` 
			JOIN client_session_register ON client_session_register.client_session_register_ref_no = client_questionnaire.client_session_register_ref_no 
			WHERE client_session_register.client_ref_no=? 
			AND client_questionnaire.questionnaire_ref_no=1)";
			return $this->db->query($sql, $client_ref_no);
		}
		
		function fetch_client_questionnaire_latest_query($client_ref_no){
			$sql="SELECT client_questionnaire.client_questionnaire_ref_no, session_register.session_date, client_questionnaire.questionnaire_text
			FROM `client_questionnaire`
            JOIN client_session_register ON client_session_register.client_session_register_ref_no = client_questionnaire.client_session_register_ref_no
            JOIN session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
			WHERE client_questionnaire.client_questionnaire_ref_no IN (
			SELECT MAX(client_questionnaire_ref_no)
			FROM `client_questionnaire` 
			JOIN client_session_register ON client_session_register.client_session_register_ref_no = client_questionnaire.client_session_register_ref_no 
			WHERE client_session_register.client_ref_no=?)
			AND client_questionnaire.questionnaire_ref_no=1";
			return $this->db->query($sql, $client_ref_no);
		}
		
		function fetch_verify_available_session_time_frame_user_query($user_ref_no, $session_date, $start_time, $end_time){
			$sql="SELECT session_register.session_register_ref_no, session_register.scheduled_time_start, session_register.scheduled_time_finish
				FROM session_register
				JOIN practitioner_session_register ON session_register.session_register_ref_no = practitioner_session_register.session_register_ref_no
				JOIN practitioner_register ON practitioner_register.practitioner_register_ref_no = practitioner_session_register.practitioner_register_ref_no
				WHERE CAST(session_register.session_date AS DATE)=CAST('".$session_date."' AS DATE)
				AND (((CAST(session_register.scheduled_time_start AS TIME)<=CAST('".$start_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)>CAST('".$start_time."' AS TIME))
				OR
				(CAST(session_register.scheduled_time_start AS TIME)<=CAST('".$end_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)>CAST('".$end_time."' AS TIME)))
				OR 
				(CAST(session_register.scheduled_time_start AS TIME)>=CAST('".$start_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)<=CAST('".$end_time."' AS TIME)))
				AND practitioner_register.practitioner_register_ref_no=?";
			return $this->db->query($sql, $user_ref_no);
		}
		
		function fetch_verify_available_session_time_frame_client_query($client_ref_no, $session_date, $start_time, $end_time){
			$sql="SELECT session_register.session_register_ref_no, session_register.scheduled_time_start, session_register.scheduled_time_finish
				FROM session_register
				JOIN client_session_register ON session_register.session_register_ref_no = client_session_register.session_register_ref_no
				WHERE CAST(session_register.session_date AS DATE)=CAST('".$session_date."' AS DATE)
				AND (((CAST(session_register.scheduled_time_start AS TIME)<=CAST('".$start_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)>CAST('".$start_time."' AS TIME))
				OR
				(CAST(session_register.scheduled_time_start AS TIME)<=CAST('".$end_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)>CAST('".$end_time."' AS TIME)))
				OR 
				(CAST(session_register.scheduled_time_start AS TIME)>=CAST('".$start_time."' AS TIME) AND CAST(session_register.scheduled_time_finish AS TIME)<=CAST('".$end_time."' AS TIME)))
				AND client_session_register.client_ref_no=?";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_user_for_alliance($alliance_ref_no){
			$sql="SELECT * 
			FROM user
			JOIN alliance ON alliance.user_ref_no = user.user_ref_no
			WHERE alliance.alliance_ref_no=?";
			return $this->db->query($sql,$alliance_ref_no);
		}
		
		function fetch_client_activity_level($client_ref_no){
			$sql="SELECT activity_level
			FROM _client
			WHERE client_ref_no=?";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_client_report_practitioner_list($client_ref_no){
			$sql="SELECT DISTINCT alliance.alliance_ref_no, alliance.first_name, alliance.last_name
			FROM practitioner_register 
			JOIN alliance ON alliance.alliance_ref_no = practitioner_register.alliance_ref_no
            JOIN practitioner_session_register ON practitioner_register.practitioner_register_ref_no = practitioner_session_register.practitioner_register_ref_no
            WHERE practitioner_session_register.session_register_ref_no IN 
			(SELECT session_register.session_register_ref_no FROM session_register
            JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no
            WHERE client_session_register.client_ref_no=?)";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function fetch_exit_session_client($client_ref_no){
			$sql="SELECT session_register.session_register_ref_no, exit_session.client_final_thoughts, exit_session.practitioner_final_thoughts, exit_session.whats_next 
			FROM session_register 
			JOIN client_session_register ON client_session_register.session_register_ref_no = session_register.session_register_ref_no 
			JOIN exit_session ON session_register.session_register_ref_no = exit_session.session_register_ref_no 
			WHERE client_session_register.client_ref_no=?";
			return $this->db->query($sql,$client_ref_no);
		}
		
		function session_class_change($session_register_ref_no){
			$sql="DELETE client_questionnaire
			FROM client_questionnaire 
			JOIN client_session_register ON client_session_register.client_session_register_ref_no = client_questionnaire.client_session_register_ref_no
			WHERE client_session_register.session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_session_class($session_register_ref_no){
			$sql="SELECT session_class_ref_no
			FROM session_register
			WHERE session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function fetch_approved_session($session_register_ref_no){
			$sql="SELECT admin_approved
			FROM session_register
			WHERE session_register_ref_no=?";
			return $this->db->query($sql,$session_register_ref_no);
		}
		
		function remove_external_cost_query($external_cost_ref_no){
			$sql="DELETE 
			FROM external_cost
			WHERE external_cost_ref_no=?";
			return $this->db->query($sql,$external_cost_ref_no);
		}
		
		function number_sessions_total_month_query($start_date, $end_date){
			$sql="SELECT count(session_register_ref_no) AS 'count'
			FROM session_register
			WHERE CAST(session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_client_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM client_session
			JOIN session_register ON session_register.session_register_ref_no = client_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_group_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM group_session
			JOIN session_register ON session_register.session_register_ref_no = group_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_evaluation_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM evaluation_session
			JOIN session_register ON session_register.session_register_ref_no = evaluation_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_supervision_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM supervision_session
			JOIN session_register ON session_register.session_register_ref_no = supervision_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_training_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM training_session
			JOIN session_register ON session_register.session_register_ref_no = training_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_sessions_conference_month_query($start_date, $end_date){
			$sql="SELECT count(session_register.session_register_ref_no) AS 'count'
			FROM conference_session
			JOIN session_register ON session_register.session_register_ref_no = conference_session.session_register_ref_no
			WHERE CAST(session_register.session_date AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(session_register.session_date AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_clients_arrive_query($start_date, $end_date){
			$sql="SELECT count(_client.client_ref_no) AS 'count'
			FROM _client
			WHERE CAST(_client.date_joined AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(_client.date_joined AS DATE)< CAST('".$end_date."' AS DATE)";
			return $this->db->query($sql);
		}
		
		function number_clients_exit_query($start_date, $end_date){
			$sql="SELECT count(_client.client_ref_no) AS 'count'
			FROM _client
			WHERE CAST(_client.date_left AS DATE)>= CAST('".$start_date."' AS DATE)
			AND CAST(_client.date_left AS DATE)< CAST('".$end_date."' AS DATE)
			AND _client.activity_level=0";
			return $this->db->query($sql);
		}*/
	}
?>