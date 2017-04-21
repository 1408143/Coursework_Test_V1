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
		
		//update new 
		function modify_character_no_picture_query($data){
			$sql="UPDATE chara
			SET charClass=?, charLevel=?, STR=?,`INT`=?, WIS=?, DEX=?, CON=?, CHA=?
			WHERE charID=?";
			return $this->db->query($sql, array($data['charClass'],$data['charLevel'], $data['STR'], $data['INT'], $data['WIS'], $data['DEX'], $data['CON'], $data['CHA'],$data['charID']));
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
		
		function update_campaign_no_document_query($data){
			$sql="UPDATE camp
			SET campaignTitle=?
			WHERE campID=?";
			return $this->db->query($sql, array($data['campaignTitle'],$data['campID']));
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
		
		function fetch_campaigns_for_player_query($userID){
			$sql="SELECT DISTINCT ca.campID, ca.campaignTitle, ca.startDate, ca.settingDocument, u.username, ch.charName
			FROM camp ca
            JOIN camppart cap ON ca.campID = cap.campID
			JOIN usr u ON ca.gameMasterID=u.userID
			JOIN chara ch ON cap.charID = ch.charID
            WHERE cap.charID IN(
				SELECT charID
                FROM chara
                WHERE userID=?
            )";
			return $this->db->query($sql,$userID);
		}
	}
?>