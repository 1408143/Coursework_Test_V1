<?php

	class Login extends CI_Controller {
	
		public function __construct(){
			parent::__construct();
			$this->load->model('query_m');
			$this->load->model('login_m');
			$this->load->library('encrypt');
		}
	
		function index(){
			if( $this->session->userdata('userID')){
				redirect('/main/index/');
			} else {
				//Check if page exists
				if(!file_exists(APPPATH.'/views/login/login.php')){
					//Didn't find page
					show_404();
				}
				$this->load->helper('form');
				//If error show
				$data['error'] = $this->security->xss_clean($this->uri->segment(3,""));
				//Set page title
				$data['title']= 'RPG Manager - Login';
				
				//Load header
				$this->load->view('templates/header', $data);
				//Load body
				$this->load->view('login/login',$data);
				//Load footer
				$this->load->view('templates/footer', $data);
			}
		}
		
		function login_user() {
			//check if post data exists and pass through xss filter, then store all post items in array 'userInfo'
			$user_info = $this->input->post(null,true);//check if post data is >0

			//Ensure values exist, and validate the user's credentials
			if(count($user_info)&& $this->login_m->validate_user($user_info['login'],$user_info['password'])){
				// If the user is valid, redirect to the main view
				//check which type of user we are dealing with
				redirect('/main/index/');
				
			}else{
				redirect('/login/index/error');
			}
			
		}
		
		function logout_user() {
		  $this->session->sess_destroy();
		  $this->index();
		}
	}
?>