<?php
	class Manage_Campaigns extends CI_Controller{

		public function __construct()
		{
			parent::__construct();
			if( !$this->session->userdata('userID') ) {
				redirect('/login/index');
			}
			//Check if page exists
			if(!file_exists(APPPATH.'/views/manage_campaigns/manage_campaigns.php')){
				//Didn't find page
				show_404();
			}
			$this->load->helper('form');
			$this->load->helper('file');
			$this->load->helper('download');
			$this->load->library('encrypt');
			$this->load->model('manage_campaigns_m');
			$this->load->model('table_m');
			$this->load->model('query_m');
			$this->load->model('login_m');
		}

		function index() {
			//Set page title
			$data['title']= 'RPG Manager - Manage Campaigns';
			switch($this->session->userdata('userClass')){
				default:
					//this is an error: something's fishy
					//logout_prejudice
					redirect('/login/index');
				break;
				
				//game master case
				case 1:
					//when on index, reset incoming flag for potential forms
					//to signal first time arrival
					$this->session->set_userdata("incoming","first");
					$this->session->mark_as_flash('incoming');
					
					$data['table_gm_campaigns']=$this->table_m->table_render("table_gm_campaigns_modify");
					
					$data['success'] = $this->session->userdata("success");
				break;
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			//Load body
			$this->load->view('manage_campaigns/manage_campaigns',$data);
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
				
		function create_new_campaign(){
			//check if post data exists and pass through xss filter, then store all post items in array 'new_user_info'
			//send to user creation function
			$data['title']= 'RPG Manager - Create Campaign';
			$data['player_dropdown']=$this->manage_campaigns_m->gm_campaign_dropdown($this->query_m->fetch_all_player_with_free_characters_query());
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
			
			$this->form_validation->set_rules('campaignTitle', 'Campaign Title', 'required|alpha');
			
			if (!empty($_FILES['settingDocument']['name'])){
				$path = $_FILES['settingDocument']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$this->form_validation->set_rules('settingDocument', 'Setting Document', 'callback_extension_check['.$ext.']');
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				//Load body
				$this->load->view('manage_campaigns/create_new_campaign_form',$data);
			}else{
				$new_campaign_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
								
				//echo $msg;
				$this->manage_campaigns_m->create_new_campaign($new_campaign_info);
				
				//set success tag
				$this->session->set_userdata("success","create_campaign_success");
				$this->session->mark_as_flash("success");
				
				//Load body
				//redirect('/manage_campaigns/index');
			}
			//Load footer
			$this->load->view('templates/footer', $data);  
		}
		
		//userID is passed through arguments in url from the button link
		//could be hijacked this is the admin, and we are checking for security permissions each time
		function modify_campaign(){
			$campaign_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
			
			//first time modify
			if($this->session->userdata('incoming')){
				$campaign_info=$this->query_m->fetch_campaign_for_campID_query($campaign_info["campID"])->row_array();
			}else{
				$campaign_info_temp=$this->query_m->fetch_campaign_for_campID_query($campaign_info["campID"])->row_array();
				$campaign_info['settingDocument']=$campaign_info_temp['settingDocument'];
			}
			
			//build list containing current players and characters
			$data["player_character_list"]=$this->manage_campaigns_m->build_player_character_list($this->query_m->fetch_players_in_campaign_and_characters_query($campaign_info["campID"]));
			
			$data["campaign_info"]=$campaign_info;
			$data['title']= 'RPG Manager - Modify Campaign';
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">×</a>', '</div>');
			
			//check if this is the first pass on the form
			if(!$this->session->userdata('incoming')){
				$this->form_validation->set_rules('campaignTitle', 'Campaign Title', 'required|alpha');
			}
			//validation for file format
			if (!empty($_FILES['settingDocument']['name'])){
				$path = $_FILES['settingDocument']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$this->form_validation->set_rules('settingDocument', 'Setting Document', 'callback_extension_check['.$ext.']');
			}
			
			//Load header
			$this->load->view('templates/header', $data);
			
			if ($this->form_validation->run() == FALSE)
            {
				$data['player_dropdown']=$this->manage_campaigns_m->gm_campaign_dropdown($this->query_m->fetch_all_player_with_free_characters_query());
				//Load body
				$this->load->view('manage_campaigns/modify_campaign_form',$data);
			}else{
				
				if (!empty($_FILES['settingDocument']['name'])){
					$campaign_info["settingDocument"]=$this->manage_campaigns_m->setting_document_upload(1,$campaign_info["campID"]);
				}else{
					$campaign_info["settingDocument"]="";
				}
				
				$this->manage_campaigns_m->modify_campaign($campaign_info);
				
				//set success tag
				$this->session->set_userdata("success","modify_campaign_success");
				$this->session->mark_as_flash("success");
				
				//load body
				redirect('/manage_campaigns/index');
			}
			//Load footer
			$this->load->view('templates/footer', $data);			
		}
		

		function delete_campaign(){
			//fetch charID
			$campaign_info = $this->security->xss_clean($this->input->post(null,true));//check if post data is >0
			//send to user deletion function
			$this->manage_campaigns_m->delete_campaign($campaign_info['deleteCampaignModalcampID']);
			
			//set success tag
			$this->session->set_userdata("success","delete_campaign_success");
			$this->session->mark_as_flash("success");
				
			//load body
			redirect('/manage_campaigns/index/delete_campaign_success');
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
		
		function extension_check($str, $ext){
			
			$ext_list=array('txt','pdf','docx');;
			if(in_array($ext,$ext_list)){
				
				return TRUE;
			}else{
				$this->form_validation->set_message('extension_check', 'The setting document must be either a .txt, .pdf or .docx file');
				return FALSE;
			}
		}
	}
?>