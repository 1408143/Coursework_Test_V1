<?php
	class Manage_Characters extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
			ini_set("display_errors", 0);
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			//Check if page exists
			if(!file_exists(APPPATH.'/views/manage_users/manage_users.php')){
				//Didn't find page
				show_404();
			}
			$this->load->helper('form');
			$this->load->library('encrypt');
			$this->load->model('manage_characters_m');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('login_m');
		}

		function index() {
			//Set page title
			$data['title']= 'RPG Manager - Manage Characters';
			switch($this->session->userdata('userClass')){
				default:
					//this is an error: something's fishy
					//logout_prejudice
					redirect('/login/index');
				break;
				
				//admin case
				case 2:
					//when on index, reset incoming flag for potential forms
					//to signal first time arrival
					$this->session->set_userdata("incoming","first");
					$this->session->mark_as_flash('incoming');
					
					$data['table_characters']=$this->table_m->table_render("table_player_characters_modify");
					$data['success'] = $this->session->userdata("success");
				break;
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			//Load body
			$this->load->view('manage_characters/manage_characters',$data);
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
				
		function create_new_character(){
			//check if post data exists and pass through xss filter, then store all post items in array 'new_user_info'
			//send to user creation function
			$data['title']= 'RPG Manager - Create Character';
			$data['character_gender_dropdown']=$this->manage_characters_m->character_gender_dropdown();
			$data['character_race_dropdown']=$this->manage_characters_m->character_race_dropdown();
			$data['character_class_dropdown']=$this->manage_characters_m->character_class_dropdown();
			$data['character_level_dropdown']=$this->manage_characters_m->character_level_dropdown();
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
			
				$this->form_validation->set_rules('charName', 'Character Name', 'required|alpha');
				$this->form_validation->set_rules('charRace', 'Character Race', "required|callback_not_default");
				$this->form_validation->set_rules('charGender', 'Character Gender', 'required|callback_not_default');
				$this->form_validation->set_rules('charClass', 'Character Class', 'required|callback_not_default');
				$this->form_validation->set_rules('charLevel', 'Character Level', 'required|callback_not_default');
				$this->form_validation->set_rules('STR', 'STR value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('DEX', 'DEX value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('CON', 'CON value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('INT', 'INT value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('WIS', 'WIS value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('CHA', 'CHA value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
			
			
			if (!empty($_FILES['characterPicture']['name'])){
				//echo $_FILES['characterPicture']['name'];
				$path = $_FILES['characterPicture']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$this->form_validation->set_rules('characterPicture', 'Character Picture', 'callback_extension_check['.$ext.']');
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				//Load body
				$this->load->view('manage_characters/create_new_character_form',$data);
			}else{
				$new_character_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
				$this->manage_characters_m->create_new_character($new_character_info);
				
				//set success tag
				$this->session->set_userdata("success","create_character_success");
				$this->session->mark_as_flash("success");
				
				//Load body
				//redirect('/manage_characters/index');
			}
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
		//userID is passed through arguments in url from the button link
		//could be hijacked this is the admin, and we are checking for security permissions each time
		function modify_character(){
			
			$character_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
			if($this->session->userdata('incoming')){
				$character_info=$this->query_m->fetch_character_for_charID_query($character_info["charID"])->row_array();
			}else{
				$character_info["characterPicture"]=$this->query_m->fetch_character_picture_query($character_info["charID"])->row()->characterPicture;
			}
			$data["character_info"]=$character_info;
			//check if post data exists and pass through xss filter, then store all post items in array 'new_user_info'
			//send to user creation function
			$data['title']= 'RPG Manager - Create Character';
			$data['character_gender_dropdown']=$this->manage_characters_m->character_gender_dropdown();
			$data['character_race_dropdown']=$this->manage_characters_m->character_race_dropdown();
			$data['character_class_dropdown']=$this->manage_characters_m->character_class_dropdown();
			$data['character_level_dropdown']=$this->manage_characters_m->character_level_dropdown();
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
			
			//check if this is the first pass on the form
			if(!$this->session->userdata('incoming')){
				$this->form_validation->set_rules('charClass', 'Character Class', 'required|callback_not_default');
				$this->form_validation->set_rules('charLevel', 'Character Level', 'required|callback_not_default');
				$this->form_validation->set_rules('STR', 'STR value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('DEX', 'DEX value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('CON', 'CON value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('INT', 'INT value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('WIS', 'WIS value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
				$this->form_validation->set_rules('CHA', 'CHA value', 'required|numeric|greater_than[0]|less_than_equal_to[40]');
			}
			
			if (!empty($_FILES['characterPicture']['name'])){
				//echo $_FILES['characterPicture']['name'];
				$path = $_FILES['characterPicture']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$this->form_validation->set_rules('characterPicture', 'Character Picture', 'callback_extension_check['.$ext.']');
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				//Load body
				$this->load->view('manage_characters/modify_character_form',$data);
			}else{
				
				if (!empty($_FILES['characterPicture']['name'])){
					//echo "bewp";
					echo $_FILES['characterPicture']['name'];
					$character_info["characterPicture"]=$this->manage_characters_m->picture_upload(1,$character_info['charID']);
					
				}else{
					//echo "no";
					$character_info["characterPicture"]="";
				}
				$this->manage_characters_m->modify_character($character_info);
				
				//set success tag
				$this->session->set_userdata("success","modify_character_success");
				$this->session->mark_as_flash("success");
				
				//load body
				redirect('/manage_characters/index');
			}
			//Load footer
			$this->load->view('templates/footer', $data);			
		}
		

		function delete_character(){
			//fetch charID
			$character_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
			//send to user deletion function
			$this->manage_characters_m->delete_character($character_info['deleteCharacterModalcharID']);
			
			//set success tag
			$this->session->set_userdata("success","delete_character_success");
			$this->session->mark_as_flash("success");
				
			//load body
			redirect('/manage_characters/index/delete_user_success');
		}
		
		///callbacks for input validations
	
		//here $str is the username
		function unique_username($str){
			//fetch all usernames
			$query=$this->query_m->fetch_all_usernames_query();
			//throw in array
			foreach($query->result() as $row){
				$username_array[]=$row->username;
			}
			
			//check if username is allready used
			if(!in_array($str,$username_array)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		function not_default($str){
			if ($str!= "default"){
				return TRUE;
			}
			else{
				$this->form_validation->set_message('not_default', 'The %s field cannot be default');
				return FALSE;
				
			}
		}
		
		function password_not_old($str, $userID){
			//fetch user from userID
			$results=$this->query_m->fetch_user_password_from_userID_query($userID);
			$user = $results->row();
			
			//check that the password does not match the current one
			if(password_verify($str,$user->password)){
				$this->form_validation->set_message('password_not_old', 'The $s cannot be similar the old password');
				return FALSE;
			}else{
				return TRUE;
			}
			
		}
		
		function extension_check($str, $ext){
			
			$ext_list=array('jpg','png');;
			if(in_array($ext,$ext_list)){
				
				return TRUE;
			}else{
				$this->form_validation->set_message('extension_check', 'The character picture must be either a .png or .jpg file');
				return FALSE;
			}
		}
	}
?>
