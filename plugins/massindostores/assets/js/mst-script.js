$ = jQuery;

$('.delete-store-btn').click(function(){
	var curent_item = $(this).parent().parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_delete_store",'id':current_item_value},
		success: function(response){
			if(response == 'deleted'){
				curent_item.html('<p class="message-div success-message alert alert-warning">City Deleted</p>');
			}
		}
	})
});
$('#delete-storeall').click(function(){
	var curent_item = $(this).parent().parent();
	
	var result = confirm("are you sure you want to delete all?");
	if (result) {
		
		jQuery.ajax({
		
			url:  plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_all_stores"},
			success: function(response){
				if(response == 'deleted'){
					//curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All cities Deleted</p>');
					
					alert('All stores Deleted');
				}
			}
		});
	}
});
$('.edit-store-btn').click(function(){
	console.log("hello");
	var updateStoreObj = JSON.parse($(this).attr('value'));
	$('.update-store-id-field').val(updateStoreObj.id);
	$('.update-store-field').val(updateStoreObj.store);
	$('.update-city-field').val(updateStoreObj.city);
	$('.update-province-field').val(updateStoreObj.province);
	$('.update-store-url-field').val(updateStoreObj.store_url);
	$('.update-market-place-field').val(updateStoreObj.market_place);
	$('.update-daerah-field').val(updateStoreObj.daerah);
	$('.update-long-field').val(updateStoreObj.longitude);
	$('.update-lat-field').val(updateStoreObj.latitude);
	
	$('#update-form-popup').trigger("click");
	//console.log(updateCityObj);
});

$(document).ready(function() {
    $('#city-table').DataTable();
	$('#update-form-popup').hide();
} );
