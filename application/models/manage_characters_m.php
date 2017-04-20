<?php
	class manage_characters_m extends CI_Model {
		
		function character_gender_dropdown(){
			$array=array();
			$array["default"]="Select a gender";
			$array["male"]="Male";
			$array["female"]="Female";
			return $array;
		}
		
		function character_race_dropdown(){
			$array=array();
			$array["default"]="Select a race";
			$array["human"]="Human";
			$array["elf"]="Elf";
			$array["dwarf"]="Dwarf";
			$array["halfling"]="Halfling";
			return $array;
		}
		
		function character_class_dropdown(){
			$array=array();
			$array["default"]="Select a class";
			$array["warrior"]="Warrior";
			$array["ranger"]="Ranger";
			$array["thief"]="Thief";
			$array["mage"]="Mage";
			$array["priest"]="Priest";
			return $array;
		}
		
		function character_level_dropdown(){
			$array=array();
			$array["default"]="Select a level";
			for($i=1;$i<=20;$i++){
				$array[$i]=$i;
			}
			return $array;
		}
		
		function create_new_character($new_character_info){
			$charID="";
			echo $_FILES['characterPicture']['name'];
			if (!empty($_FILES['characterPicture']['name'])){
				echo "bip";
				$new_character_info["characterPicture"]=$this->manage_characters_m->picture_upload(0,$charID);
			}else{
				$new_character_info["characterPicture"]="";
			}
			
			$new_character_info['userID']=$this->session->userdata("userID");
			$this->query_m->create_new_character_query($new_character_info);
			$charID=$this->db->insert_id();
			
			
		}
		
		function modify_character($character_info){
			
			$this->query_m->modify_character_query($character_info);
		}
		
		function delete_character($charID){
			$data['charID']=$charID;
			$query=$this->query_m->fetch_character_picture_query($charID);
			if(isset($query)){
				$file=$query->row();
				//echo $file->settingDocumentPath;
				if(isset($file->characterPicture)){
					unlink("./uploads/characterPictures/".$file->characterPicture);
				}
			}
			
			$this->query_m->delete_character_query($data);
		}
		
		function picture_upload($flag,$charID){
			//check for names in directory
			$this->load->helper('directory');
			
			$path = $_FILES['characterPicture']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			//check that name is unique
			$not_unique=TRUE;
			while($not_unique){
				$document_name="character_picture_".rand(1000001,2000000).".".$ext;
				$map = directory_map('./uploads/characterPictures/', 1);
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
				$query=$this->query_m->fetch_character_picture_query($charID);
				if(isset($query)){
					$file=$query->row();
					//echo $file->settingDocumentPath;
					if(isset($file->characterPicture) && in_array($file->characterPicture,$map)){
						unlink("./uploads/characterPictures/".$file->characterPicture);
					}
				}
			}
			//config upload helper
			$config['upload_path'] = './uploads/characterPictures/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']= '100';
			$config['file_name']=$document_name;
			$this->load->library('upload', $config);
			
			//upload
			if (!$this->upload->do_upload('characterPicture'))
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