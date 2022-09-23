$ = jQuery;

if(plugin_area_page == true){
	console.log(plugin_area_page);
	jQuery.ajax({
		
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_get_all_cities_for_area"},
		success: function(response){
			if( response != "invalid"){
				console.log(response);
				var cities_to_add = JSON.parse(response);
				var cities_array = [];
				
				jQuery.each(cities_to_add, function(index, value ){
					var cityObj = {"id":value.id, "value":value.id, "text":value.city_title+','+value.province_title};
					cities_array.push(cityObj);
				});
			}
			else{
				cities_array = '';
			}
			$('.select2').select2({
				data: cities_array,
				tags: true,
				maximumSelectionLength: 10,
				tokenSeparators: [',', ' '],
				placeholder: "Select or type keywords",
			});
			$(".select2-selected").select2({
			  data: cities_array
			})
			 
		}
	})
}


$('.delete-province-btn').click(function(){
	var curent_item = $(this).parent().parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_delete_province",'id':current_item_value},
		success: function(response){
			if(response == 'deleted'){
				curent_item.html('<p class="message-div success-message alert alert-warning">Province Deleted</p>')
			}
		}
	})
});
$('#delete-provinceall').click(function(){
	var curent_item = $(this).parent().parent();
	
	var result = confirm("are you sure you want to delete all?");
	if (result) {
		
		jQuery.ajax({
		
			url:  plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_all_provinces"},
			success: function(response){
				if(response == 'deleted'){
					curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All Provinces Deleted</p>');
				}
			}
		});
	}
});

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
					curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All cities Deleted</p>');
				}
			}
		});
	}
});
$('.delete-postcode-btn').click(function(){

	var curent_item = $(this).parent().parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_delete_postcode",'id':current_item_value},
		success: function(response){
			if(response == 'deleted'){
				console.log(current_item_value);
				curent_item.html('<p class="message-div success-message alert alert-warning">Postcode Deleted</p>');
	
			}
		}
	})
});
$('#delete-postcodeall').click(function(){
	var curent_item = $(this).parent().parent();
	
	var result = confirm("are you sure you want to delete all?");
	if (result) {
		
		jQuery.ajax({
		
			url:  plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_all_postcodes"},
			success: function(response){
				if(response == 'deleted'){
					curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All Postcodes Deleted</p>');
				}
			}
		});
	}
});
$('.delete-area-btn').click(function(){
	
	var curent_item = $(this).parent().parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_delete_area",'id':current_item_value},
		success: function(response){
			if(response == 'deleted'){
				curent_item.html('<p class="message-div success-message alert alert-warning">Area Deleted</p>');
			}
		}
	})
});
$('#delete-areaall').click(function(){
	var curent_item = $(this).parent().parent();
	
	var result = confirm("are you sure you want to delete all?");
	if (result) {
		
		jQuery.ajax({
		
			url:  plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_all_areas"},
			success: function(response){
				if(response == 'deleted'){
					curent_item.siblings().parent().html('<p class="message-div success-message alert alert-warning">All Areas Deleted</p>');
				}
			}
		});
	}
});
$('.enable-area-btn').click(function(){
	
	var curent_item = $(this).parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_enable_area",'id':current_item_value},
		success: function(response){
			if(response == 'enabled'){
				curent_item.html('<p class="message-div success-message alert alert-warning">Enabled</p>');
			}
		}
	})
});
$('.disable-area-btn').click(function(){
	
	var curent_item = $(this).parent();
	var current_item_value = $(this).attr('value');
	
	jQuery.ajax({
	
		url:  plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_disable_area",'id':current_item_value},
		success: function(response){
			if(response == 'disabled'){
				curent_item.html('<p class="message-div success-message alert alert-warning">Disabled</p>');
			}
		}
	})
});

$(document).ready(function() {
    $('#postcode-table').DataTable();
    $('#province-table').DataTable();
    $('#area-table').DataTable();
    $('#city-table').DataTable();
} );