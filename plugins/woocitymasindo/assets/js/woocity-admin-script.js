$ = jQuery;

$('.delete-city-btn').click(function(){
	var curent_item = $(this).parent().parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_delete_city",'id':current_item_value},
		success: function(response){
			if(response == 'deleted'){
				curent_item.html('<p class="message-div success-message alert alert-warning">City Deleted</p>');
			}
		}
	})
});
$('#delete-cityall').click(function(){
	var curent_item = $(this).parent().parent();
	
	var result = confirm("are you sure you want to delete all?");
	if (result) {
		
		jQuery.ajax({
		
			url:  plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_all_cities"},
			success: function(response){
				if(response == 'deleted'){
					//curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All cities Deleted</p>');
					
					alert('All cities Deleted');
				}
			}
		});
	}
});


$(document).ready(function() {
    $('#city-table').DataTable();
} );