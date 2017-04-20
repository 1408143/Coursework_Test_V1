<?php
	class Manage_Users extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
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
			$this->load->model('manage_users_m');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('login_m');
			$this->load->model('manage_users_m');
			$this->login_m->security_check();
		}

		function index() {
			//Set page title
			$data['title']= 'RPG Manager - Manage Users';
			switch($this->session->userdata('userClass')){
				default:
					//this is an error: something's fishy
					//logout_prejudice
					redirect('/login/index');
				break;
				
				//admin case
				case 0:
					//when on index, reset incoming flag for potential forms
					//to signal first time arrival
					$this->session->set_userdata("incoming","first");
					$this->session->mark_as_flash('incoming');
					
					$data['table_game_masters']=$this->table_m->table_render("all_non_game_masters_table_modify");
					$data['table_players']=$this->table_m->table_render("all_non_players_table_modify");
					$data['success'] = $this->session->userdata("success");
				break;
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			//Load body
			$this->load->view('manage_users/manage_users',$data);
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
				
		function create_new_user(){
			//check if post data exists and pass through xss filter, then store all post items in array 'new_user_info'
			//send to user creation function
			$data['title']= 'RPG Manager - Create User';
			$data['user_class_dropdown']=$this->manage_users_m->user_creation_dropdown();
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
			
			$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|callback_unique_username', array('unique_username' => 'This username is already taken. Please choose another.'));
			$this->form_validation->set_rules('password', 'Password', "required|min_length[8]");
			$this->form_validation->set_rules('password_verify', 'Password Confirmation', 'required|matches[password]');
			$this->form_validation->set_rules('user_class', 'User Class', 'callback_not_default[user_class]');
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				//Load body
				$this->load->view('manage_users/create_new_user_form',$data);
			}else{
				$new_user_info = $this->input->post(null,true);//check if post data is >0
				$this->manage_users_m->create_new_user($new_user_info);
				//set success tag
				$this->session->set_userdata("success","new_user_success");
				$this->session->mark_as_flash("success");
				
				//load body
				redirect('/manage_users/index');
			}
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
		//userID is passed through arguments in url from the button link
		//could be hijacked this is the admin, and we are checking for security permissions each time
		function modify_user(){
			
			//check if post data exists and pass through xss filter, then store all post items in array 'user_info'
			$user_info = $this->input->post(null,true);//check if post data is >0
			if($this->session->userdata('incoming')){
					//fetch the selected user information
					$user_info=$this->query_m->fetch_user_info_from_userID_query($user_info['userID'])->row_array();
			}
			$data["user_info"]=$user_info;
			//send to user modification function
			$data['title']= 'RPG Manager - Modify User';
			
			//check if this is an first time form, and error return or a legitimate form submit
			if(!$this->session->userdata('incoming')){
				$form_type= $user_info['form_type'];
				//set delimiters for errors
				$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
				
				//depending on the form submitted, apply different rules
				switch($form_type){
					default:
					//error:someone is messing with us
					break;
					
					case "password":
						$this->form_validation->set_rules('password', 'Password', "required|min_length[8]|callback_password_not_old[".$data['userID']."]");
						$this->form_validation->set_rules('password_verify', 'Password Confirmation', 'required|matches[password]');
					break;
					
					case "user_info":
						$this->form_validation->set_rules('fname', 'First Name', "alpha");
						$this->form_validation->set_rules('lname', 'Last Name', 'alpha');
						$this->form_validation->set_rules('email', 'Email', "valid_email");
					break;
				}
			}
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				//Load body
				$this->load->view('manage_users/modify_user_form',$data);
			}else{
				switch($form_type){
					default:
					//error:someone is messing with us
					break;
					
					case "password":
						//modify password
						$this->manage_users_m->modify_user_password($user_info);
						//set success tag
						$this->session->set_userdata("success","modify_user_password_success");
						$this->session->mark_as_flash("success");
						
						//load body
						redirect('/manage_users/index');
					break;
					
					case "user_info":
						//modify user information
						$this->manage_users_m->modify_user_info($user_info);
						//set success tag
						$this->session->set_userdata("success","modify_user_info_success");
						$this->session->mark_as_flash("success");
						
						//load body
						redirect('/manage_users/index');
					break;
				}
			}
			//Load footer
			$this->load->view('templates/footer', $data);			
		}
		
		//userID is passed through arguments in url from the button link
		//could be hijacked this is the admin, and we are checking for security permissions each time
		function delete_user(){
			//fetch charID
			$user_info = $this->input->post(null,true);//check if post data is >0
			//send to user deletion function
			$this->manage_users_m->delete_user($user_info['deleteUserModaluserID']);
			//set success tag
			$this->session->set_userdata("success","delete_user_success");
			$this->session->mark_as_flash("success");
						
			//load body
			redirect('/manage_users/index');
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
	}
?>