<?php
	class pdf extends CI_Controller{
		public function __construct()
		{
			parent::__construct();
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			//Check if page exists
			if(!file_exists(APPPATH.'/views/pdf/pdf.php')){
				//Didn't find page
				show_404();
			}
			$this->load->library('fpdf');
			$this->load->library('fpdi');
			$this->load->model('query_m');
		}

		function index() {
				$data['title']= 'RPG Manager - Character Sheet';
				$data['player']=$this->query_m->fetch_user_from_userID_query($this->session->userdata('userID'))->row_array();
				$data['character']=$this->query_m->fetch_character_for_charID_query($this->uri->segment(3))->row_array();
				//Load header
				$this->load->view('templates/header_pdf', $data);
				//Load body
				$this->load->view('pdf/pdf',$data);
				//Load footer
				$this->load->view('templates/footer_pdf', $data);
		}
	}
?>