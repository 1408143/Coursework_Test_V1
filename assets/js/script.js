//if(typeof($) != 'function') alert('This component requires jQuery.'); 
//else $(function() { alert('The DOM is ready for jQuery manipulation.'); });

$(document).ready(function () {
	//alert();
	//fetch userID for modal popup
	$('#deleteUserModal').on('show.bs.modal', function (event) {
		
		//fetch triggered button
		var button = $(event.relatedTarget);
		
		//fetch userID from data-userid
		var userID = button.data('userid');
		
		
		var modal = $(this);
		modal.find('.modal-title').text('Delete user ' + userID);
		
		//replace values
		$('#deleteUserModaluserID').attr('value',userID);
	});
	
	//fetch characterID for modal popup
	$('#deleteCharacterModal').on('show.bs.modal', function (event) {
		
		//fetch triggered button
		var button = $(event.relatedTarget);

		//fetch userID from data-userid
		var charID = button.data('charid');
		
		var modal = $(this);
		modal.find('.modal-title').text('Delete user ' + charID);
		
		//set value
		$('#deleteCharacterModalcharID').attr('value',charID);
	});
	
	//fetch campaign for modal popup
	$('#deleteCampaignModal').on('show.bs.modal', function (event) {
		//alert();
		//fetch triggered button
		var button = $(event.relatedTarget);

		//fetch userID from data-userid
		var campID = button.data('campaignid');
		var campTitle = button.data('campaigntitle');
		
		
		var modal = $(this);
		modal.find('.modal-title').text('Delete campaign ' + campTitle.charAt(0).toUpperCase() + campTitle.slice(1));
		
		//set value
		$('#deleteCampaignModalcampID').attr('value',campID);
	});
	
	
	//fetchplayer from dropdown
	$("#player_dropdown").on('change',function(event){

		//fetch userID from value
		var selected_player_userID = $('#player_dropdown').val();
		
		//fetch username from selected
		var selected_player_username= $('#player_dropdown option:selected').text();
		
		//test for default->do nothing
		//test to see if a name allready exists with theis format and this userID attached in the list
		if ($('#player_list_visible').find('input[name="player_list_invisible-'+ selected_player_userID + '"]').length == 0 && selected_player_userID!="default"){
			//alert("bip");
			$.ajax({
				url:'/index.php/ajax/send_ajax_player_for_campaign',
				type:'POST',
				dataType: 'json',
				data: {"userID":selected_player_userID, "username":selected_player_username},
				success: function(output_string){
					$('#player_list_visible').append(output_string);//append new text
				} // End of success function of ajax form
			}); // End of ajax call	
		}
		//var charID = button.data('charid');
	});
});

function removePlayerPresent(select){
	$("#" + select).remove();
}


/*function selectTraumaClientPresent(select){
	var $ul = document.getElementById("trauma_list_visible");
	if ($('#'+$ul.id).find('input[name="trauma_invisible-'+ $('#'+select.id).val()+'"]').length == 0 && $('#'+select.id).val()!="default"){
		$('#'+$ul.id).append(
		'<li id="'+$('#'+select.id).val()+'" onclick="removeClientPresent(this);">' +
		'<input type="hidden" name="trauma_invisible-'+ $('#'+select.id).val()+'" value="' + $('#'+select.id).val() + '" /> '+
		'<input type="hidden" name="client_invisible-'+ $('#'+select.id).val()+'" value="' + $('#'+select.id).val() + '" /> '+
		$('#trauma_l option:selected').text() +'</li>');
	}
}
*/
