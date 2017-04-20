<?php
	class Manage_Account extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			//Check if page exists
			if(!file_exists(APPPATH.'/views/manage_account/manage_account.php')){
				//Didn't find page
				show_404();
			}
			
			$this->load->helper('form');
			$this->load->library('encrypt');
			$this->load->model('manage_account_m');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('login_m');
			$this->load->model('manage_users_m');
			$this->login_m->security_check();
		}

		function index() {
			//Set page title
			$data['title']= 'RPG Manager - Manage Account';
			switch($this->session->userdata('userClass')){
				default:
					//this is an error: something's fishy
					//logout_prejudice
					redirect('/login/index');
				break;
				
				//Game Master case
				case 1:
					//fetch user information
					$query=$this->query_m->fetch_user_info_from_userID_query($this->session->userdata('userID'));
					$data['user_info']=$query->row();
					$data['success'] = $this->session->userdata('success');
				break;
				
				//Player case
				case 2:
					//fetch user information
					$query=$this->query_m->fetch_user_info_from_userID_query($this->session->userdata('userID'));
					$data['user_info']=$query->row();
					$data['success'] = $this->session->userdata('success');
				break;
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			//Load body
			$this->load->view('manage_account/manage_account',$data);
			//Load footer
			$this->load->view('templates/footer', $data);  
		}

		function modify_account(){
			unset($user_info);
			//check if post data exists and pass through xss filter, then store all post items in array 'user_info'
			$user_info = $this->input->post(null,true);//check if post data is >0
			//send to user modification function
			$data['title']= ' RPG Manager - Modify Account';
			
			//session tells us who the user is
			//https will protect the session
			
			//fetch the selected user information
			$data['user_info']=$this->query_m->fetch_user_info_from_userID_query($this->session->userdata['userID'])->row();
			
			//check if this is an first time form, and error return or a legitimate form submit
			//if user_info is NULL, then nothing has been submitted
			if($user_info!=NULL){
				$user_info['userID']=$this->session->userdata('userID');
				$form_type= $user_info['form_type'];
				//set delimiters for errors
				$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
				
				//depending on the form submitted, apply different rules
				switch($form_type){
					default:
					//error:someone is messing with us
					break;
					
					case "password":
						$this->form_validation->set_rules('password', 'Password', "required|min_length[8]|callback_password_not_old[".$user_info['userID']."]");
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
				$this->load->view('manage_account/modify_account_form',$data);
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
			
						//redirect
						redirect('/manage_account/index');
					break;
					
					case "user_info":
						//modify user information
						$this->manage_users_m->modify_user_info($user_info);
						
						//set success tag
						$this->session->set_userdata("success","modify_user_info_success");
						$this->session->mark_as_flash("success");
			
						//redirect
						redirect('/manage_account/index');
						redirect('/manage_account/index');
					break;
				}
			}
			//Load footer
			$this->load->view('templates/footer', $data);			
		}
		
		//userID is passed through arguments in url from the button link
		//could be hijacked this is the admin, and we are checking for security permissions each time
		function delete_user(){
			//fetch userID
			//clean with xss filter
			$data['userID']= $this->security->xss_clean($this->uri->segment(3,""));
			//send to user deletion function
			$this->manage_users_m->delete_user($data['userID']);
			//redirect success
			redirect('/manage_users/index/delete_user_success');
		}
		
		///callbacks for input validations
		
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