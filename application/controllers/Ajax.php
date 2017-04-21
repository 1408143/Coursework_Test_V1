<?php
	class Ajax extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
			ini_set("display_errors", 0);
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('ajax_m');
		}
		
		public function send_ajax_player_for_campaign(){
			$str="boop";
			//redirect('/main/index');
			$userID=$this->security->xss_clean($this->input->post("userID"));
			
			$username=$this->security->xss_clean($this->input->post("username"));
			
			//fetch characters for this user
			$query=$this->query_m->fetch_all_characters_not_busy_query($userID);
			
			$str=$this->ajax_m->build_player_list_entry($userID, $username, $query);
			
			echo json_encode($str);
		}
	}
?>
