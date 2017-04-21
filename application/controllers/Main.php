<?php
	class main extends CI_Controller{
		
		public function __construct()
		{
			parent::__construct();
			ini_set("display_errors", 0);
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			//Check if page exists
			if(!file_exists(APPPATH.'/views/main/main.php')){
				//Didn't find page
				show_404();
			}
			$this->load->helper('form');
			$this->load->helper('download');
			$this->load->library('encrypt');
			$this->load->model('main_m');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('login_m');
		}

		function index() {
			$result=$this->query_m->fetch_user_from_userID_query($this->session->userdata('userID'));		
			$current_user=$result->row();
			//Set page title
			$data['title']= 'RPG Manager - Home';
			//$data['user_class_dropdown']=$this->main_m->user_creation_dropdown();
			switch($this->session->userdata('userClass')){
				default:
					//this is an error
					redirect('/login/index');
				break;
				
				//admin case
				case 0:
					$this->login_m->security_check();
					$data['table']=$this->table_m->table_render("all_non_admin_users_table");
				break;
				
				//game master case
				case 1:
					$data['table']=$this->table_m->table_render("table_gm_campaigns");
				break;
				
				//player case
				case 2:
					$data['table']=$this->table_m->table_render("table_player_characters");
					$data['table_campaigns']=$this->table_m->table_render("table_player_campaigns");
				break;
			}
			
			//Load header
			
			$this->load->view('templates/header', $data);
			//Load body
			$this->load->view('main/main',$data);
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
		function download_setting_document(){
			force_download('./uploads/settingDocuments/'.$this->uri->segment(3), NULL);
			//$this->main_m->download_setting_document();
		}
		
		function download_character_picture(){
			force_download('./uploads/characterPictures/'.$this->uri->segment(3), NULL);
			//$this->main_m->download_setting_document();
		}
	}
?>
