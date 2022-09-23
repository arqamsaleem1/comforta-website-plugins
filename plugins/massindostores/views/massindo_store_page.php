<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$store_operations = new Massindo_Store_Operations();
$message = '';


if(isset($_POST['store_submit'])){
	if(!empty($_POST['store_title']) && !empty($_POST['city_title']) && !empty($_POST['province']) && !empty($_POST['store_url']) && !empty($_POST['market_place'])){
		$store_title = strtolower($_POST['store_title']);
		$city_title = strtolower($_POST['city_title']);
		$store_province = $_POST['province'];
		$store_url = $_POST['store_url'];
		$market_place = $_POST['market_place'];
		$daerah = $_POST['daerah'];
		$longitude = (isset($_POST['long'])) ? $_POST['long'] : '';
		$latitude = (isset($_POST['lat'])) ? $_POST['lat'] : '';
		
		$store_data = array('store'=>$store_title,'city'=>$city_title,'province'=>$store_province,'store_url'=>$store_url,'market_place'=>$market_place,'daerah'=>$daerah,'longitude'=>$longitude,'latitude'=>$latitude);
		
		$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "massindo_stores where store='$store_title'");
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>Store already exists</p></div>";
		}
		else{
			$result = $store_operations->save_store($store_data);
			if ($result){
				$message = "<div class='message-div success-message alert alert-success'><p>Store is added Successfully</p></div>";
			}
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>Please fill the form properly</p></div>";
	}
}

/*** Update Market Place Form ***/
if(isset($_POST['update_store_submit'])){
	if(!empty($_POST['update_store_title']) && !empty($_POST['update_city_title']) && !empty($_POST['update_province']) && !empty($_POST['update_store_url']) && !empty($_POST['update_market_place']) && !empty($_POST['update_store_id'])){
		$update_store_title = strtolower($_POST['update_store_title']);
		$update_city_title = strtolower($_POST['update_city_title']);
		$update_store_province = $_POST['update_province'];
		$update_store_url = $_POST['update_store_url'];
		$update_market_place = $_POST['update_market_place'];
		$update_daerah = $_POST['update_daerah'];
		$update_longitude = (isset($_POST['update_long'])) ? $_POST['update_long'] : '';
		$update_latitude = (isset($_POST['update_lat'])) ? $_POST['update_lat'] : '';
		$update_store_id = $_POST['update_store_id'];
		
		
		$update_store_data = array('store'=>$update_store_title,'city'=>$update_city_title,'province'=>$update_store_province,'store_url'=>$update_store_url,'market_place'=>$update_market_place,'daerah'=>$update_daerah,'longitude'=>$update_longitude,'latitude'=>$update_latitude);
		
		
		global $wpdb;

		$table_name = $wpdb->prefix . 'massindo_stores';
		$status = $wpdb->update( $table_name, $update_store_data, array( 'id' => $update_store_id ));
		if ($status){
			$message = "<div class='message-div success-message alert alert-success'><p>Market Place is updated</p></div>";
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>Please fill the form properly</p></div>";
	}
}
/*****Import Form Handling*****/
$mst_import = new Massindo_Store_Import();
$import_message = "";
if (isset($_POST['store-import-btn'])) {
	if (file_exists($_FILES['store-import-file']["tmp_name"])){

		$filename = $_FILES['store-import-file']['tmp_name'] ;

		$file_extension = pathinfo($_FILES['store-import-file']["name"], PATHINFO_EXTENSION);
		$allowed_file_extension = "csv";

		if ($file_extension == $allowed_file_extension) {
			$status = $mst_import->import_stores($_FILES['store-import-file']['tmp_name']);
			if($status>0){
				$import_message = "<div class='message-div import-message-div success-message alert alert-success'><p>$status records imported Successfully</p></div>";
			}
			else{
				$import_message = "<div class='message-div import-message-div error-message alert alert-warning'><p>Import Failed, something went wrong</p></div>";
			}
		}
		else{
			$import_message = "<div class='message-div import-message-div error-message alert alert-warning'><p>File extension not supported (only .csv files allowed)</p></div>";
		}

	}
	else{
		$import_message = "<div class='message-div import-message-div error-message alert alert-warning'><p>File is not selected</p></div>";
	}
}
?>

<div class="mst-admin-wrapper">
	<div class="container">
		<div class="mst-admin-container">
			<h2>Add Store here</h2>
			<div class="row">
				<div class="col-md-6">
				<div class="add-store-form-section container">
					<form action="" method="post" class="add-store-form" name="add-store-form">
						<?php if(isset($_POST['store_submit']) and isset($message)){ echo $message; } ?>
						<div class="form-group store-form-group">
							<label>Store</label>
							<input type="text" name="store_title" class="store-field input-text-field store-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>City</label>
							<input type="text" name="city_title" class="city-field input-text-field store-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Province</label>
							<input type="text" name="province" class="province-field input-text-field store-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Store URL</label>
							<input type="text" name="store_url" class="store-field input-text-field store-url-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Market Place</label>
							<input type="text" name="market_place" class="store-field input-text-field store-marketplace-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Daerah</label>
							<input type="text" name="daerah" class="store-field input-text-field store-long-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Longitude</label>
							<input type="text" name="long" class="store-field input-text-field store-long-field-1 form-control">
						</div>
						<div class="form-group store-form-group">
							<label>Latitude</label>
							<input type="text" name="lat" class="store-field input-text-field store-lat-field-1 form-control">
						</div>
						<div class="form-group store-form-group submit-btn-group">
							<input type="submit" name="store_submit" class="store-field submit-field store-field-2 btn btn-sm btn-outline-info" value="submit">
						</div>
					</form>
				</div>
				</div>
				<div class="col-md-4">
					<div class="import-form-area">
						<?php if(isset($_POST['store-import-btn']) and isset($import_message)){ echo $import_message; } ?>
						<form accept="" method="post" name="store-import-form" enctype="multipart/form-data">
							<div class="form-group">
								<label>Import Market Places</label>
								<input type="file" name="store-import-file">
								<p class="import-sub-label"></p>
							</div>
							<div class="form-group">
								<input type="submit" name="store-import-btn" class="btn btn-sm btn-outline-info" value="Import">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="store-details-section details-section">
				<?php
					$stores = $store_operations->get_all_stores();
				?>
				<h2>Market Places</h2>
				<table id="store-table" class="table">
					<thead><tr><th>Store</th><th>City</th><th>Province</th><th>Market Place</th><th scope="col"><button type="submit" name="delete-storeall" id = "delete-storeall" value="storeall" class="delete-storeall-btn btn btn-sm btn-outline-info">Delete All</button></th><th></th></tr></thead>
					<?php foreach ($stores as $store): ?>
					<tr>
						<td><?php echo $store->store; ?></td>
						<td><?php echo $store->city; ?></td>
						<td><?php echo $store->province; ?></td>
						<td><?php echo $store->market_place; ?></td>
						<td>
							<button type="submit" name="delete-store" id = "delete-store-<?php echo ($store->id); ?>" value="<?php echo ($store->id); ?>" class="delete-store-btn btn btn-sm btn-outline-info"><i class="fa fa-trash"></i></button>
						</td>
						<td>
							<button type="submit" name="edit-store" id = "edit-store-<?php echo ($store->id); ?>" value='<?php echo (json_encode($store)); ?>' class="edit-store-btn btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></button>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Button trigger modal -->
<button type="button" id="update-form-popup" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update City</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="update-store-form-section container">
			<form action="" method="post" class="update-store-form" name="update-store-form">
				<?php if(isset($_POST['update_store_submit']) and isset($message)){ echo $message; } ?>
					<input type="hidden" name="update_store_id" class="update-store-id-field input-text-field update-store-id-field-1 form-control">
				<div class="form-group update-store-form-group">
					<label>Store</label>
					<input type="text" name="update_store_title" class="update-store-field input-text-field update-store-field-1 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>City</label>
					<input type="text" name="update_city_title" class="update-city-field input-text-field update-store-field-2 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Province</label>
					<input type="text" name="update_province" class="update-province-field input-text-field update-store-field-3 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Store URL</label>
					<input type="text" name="update_store_url" class="update-store-url-field input-text-field update-store-field-4 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Market Place</label>
					<input type="text" name="update_market_place" class="update-market-place-field input-text-field update-store-field-5 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Daerah</label>
					<input type="text" name="update_daerah" class="update-daerah-field input-text-field update-store-field-6 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Longitude</label>
					<input type="text" name="update_long" class="update-long-field input-text-field update-store-field-7 form-control">
				</div>
				<div class="form-group update-store-form-group">
					<label>Latitude</label>
					<input type="text" name="update_lat" class="update-lat-field input-text-field update-store-field-8 form-control">
				</div>
				<div class="form-group update_store-form-group submit-btn-group">
					<input type="submit" name="update_store_submit" class="update-store-submit-field submit-field update_store-field-9 btn btn-sm btn-outline-info" value="submit">
				</div>
			</form>
		</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>