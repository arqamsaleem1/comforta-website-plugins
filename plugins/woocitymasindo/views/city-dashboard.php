<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$woocity_operations = new Woocity_Operations();
$message = '';


if(isset($_POST['city_submit'])){
	if(!empty($_POST['woo_city_id']) && !empty($_POST['city_title']) && !empty($_POST['province']) && !empty($_POST['shipping_cost'])){
		$woo_city_id = strtolower($_POST['woo_city_id']);
		$city_title = strtolower($_POST['city_title']);
		$city_province = $_POST['province'];
		$city_cost = $_POST['shipping_cost'];
		
		$city_data = ['woo_city_id'=>$woo_city_id, 'city'=>$city_title, 'province'=>$city_province, 'cost'=> $city_cost];
		$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "woocity_cities where city='$city_title' OR woo_city_id='$woo_city_id' ");
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>City already exists</p></div>";
			
		}
		else{
			$result = $woocity_operations->save_city($city_data);
			if ($result){
				$message = "<div class='message-div success-message alert alert-success'><p>City is added Successfully</p></div>";
			}
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>Please fill the form properly</p></div>";
	}
}

/*****Import Form Handling*****/
$woocity_import = new Woocity_Import();
$import_message = "";
if (isset($_POST['city-import-btn'])) {
	if (file_exists($_FILES['city-import-file']["tmp_name"])){

		$filename = $_FILES['city-import-file']['tmp_name'] ;

		$file_extension = pathinfo($_FILES['city-import-file']["name"], PATHINFO_EXTENSION);
		$allowed_file_extension = "csv";

		if ($file_extension == $allowed_file_extension) {
			$status = $am_import->import_city($_FILES['city-import-file']['tmp_name']);
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
<script>
var plugin_area_page = false;
</script>
<div class="woocity-admin-wrapper">
	<div class="container">
		<div class="woocity-admin-container">
			<h2>Add city here</h2>
			<div class="row">
				<div class="col-md-6">
				<div class="add-city-form-section container">
					<form action="" method="post" class="add-city-form" name="add-city-form">
						<?php if(isset($_POST['city_submit']) and isset($message)){ echo $message; } ?>
						<div class="form-group city-form-group">
							<label>WOO City ID</label>
							<input type="text" name="woo_city_id" class="woo-city-id-field input-text-field city-field-1 form-control">
						</div>
						<div class="form-group city-form-group">
							<label>City</label>
							<input type="text" name="city_title" class="city-field input-text-field city-field-1 form-control">
						</div>
						<div class="form-group city-form-group">
							<label>Province</label>
							<input type="text" name="province" class="province-field input-text-field province-field-1 form-control">
						</div>
						<div class="form-group cost-form-group">
							<label>Shipping Cost</label>
							<input type="number" name="shipping_cost" class="cost-field input-text-field cost-field-1 form-control">
						</div>
						<div class="form-group city-form-group submit-btn-group">
							<input type="submit" name="city_submit" class="city-field submit-field city-field-2 btn btn-sm btn-outline-info" value="submit">
						</div>
					</form>
				</div>
				</div>
				<div class="col-md-4">
					<div class="import-form-area">
						<?php if(isset($_POST['city-import-btn']) and isset($import_message)){ echo $import_message; } ?>
						<form accept="" method="post" name="city-import-form" enctype="multipart/form-data">
							<div class="form-group">
								<label>Import City Costs</label>
								<input type="file" name="city-import-file">
								<p class="import-sub-label"></p>
							</div>
							<div class="form-group">
								<input type="submit" name="city-import-btn" class="btn btn-sm btn-outline-info" value="Import">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="city-details-section details-section">
				<?php
					$cities = $woocity_operations->get_all_cities();
				?>
				<h2>City Details</h2>
				<table id="city-table" class="table">
					<thead><tr><th>WOO City ID</th><th>City</th><th>Province</th><th>Shipping Cost</th><th scope="col"><button type="submit" name="delete-cityall" id = "delete-cityall" value="cityall" class="delete-cityall-btn btn btn-sm btn-outline-info">Delete All</button></th></tr></thead>
					<?php foreach ($cities as $city): ?>
					<tr>
						<td><?php echo $city->woo_city_id; ?></td>
						<td><?php echo $city->city; ?></td>
						<td><?php echo $city->province; ?></td>
						<td><?php echo $city->cost; ?></td>
						<td>
							<button type="submit" name="delete-city" id = "delete-city-<?php echo ($city->id); ?>" value="<?php echo ($city->id); ?>" class="delete-city-btn btn btn-sm btn-outline-info"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>