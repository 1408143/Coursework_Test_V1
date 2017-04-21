<?php
	class ajax_m extends CI_Model {
		
		function build_player_list_entry($userID,$username,$query){
			$array=array();
			foreach($query->result() as $row){
				$array[$row->charID]=ucfirst($row->charName);
			}
			//first create a <li> tage linked to an onlclick event for removal
			$str='<li id="'.$userID.'" style="list-style-type: none">'.
			'<div class="col-md-4">'.
			ucfirst($username).
			'</div><div class="col-md-8"></div>'.
			//then add an hidden input for form submission with userID as a value, and id being tagged uniquely for previous test
			'<input type="hidden" name="player_list_invisible-'.$userID.'" value="'.$userID.'" />'.
			//then dropdown for character select
			'<div class="col-md-8">'.
			form_dropdown('characterList-'.$userID, $array,'','class="form-control" name="characterList-'.$userID.'"').
			//then add button for removal
			'</div><div class="col-md-4">'.
			'<button type="button" class="btn btn-default" onclick="removePlayerPresent('.$userID.')">Remove</button>'.
			'</div>'.
			'</li>';
			return $str;
		}
	}
?>