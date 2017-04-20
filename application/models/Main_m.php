<?php
	class main_m extends CI_Model {
		
		function user_creation_dropdown(){
			$array=array();
			$array["default"]="Select a user class";
			$array[1]="Game Master";
			$array[2]="Player";
			return $array;
		}
	}
?>