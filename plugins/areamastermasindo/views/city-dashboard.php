<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$am_operations = new Am_Operations();
$message = '';
$provinces = $am_operations->get_all_provinces();


if(isset($_POST['city_submit'])){
	if(!empty($_POST['city_title']) && !empty($_POST['city_province'])){
		$city_title = strtolower($_POST['city_title']);
		$city_province_id = $_POST['city_province'];
		$city_province_title = strtolower($am_operations->get_province($city_province_id)->province_title);
		
		$city_data = ['city_title'=>$city_title, 'province'=>$city_province_id, 'province_title'=> $city_province_title];
		$row = $wpdb->get_row("SELECT * FROM wp_am_cities where city_title='$city_title'");
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>City already exists</p></div>";
			
		}
		else{
			$result = $am_operations->save_city($city_data);
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
$am_import = new Am_Import();
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
<div class="am-admin-wrapper">
	<div class="container">
		<div class="am-admin-container">
			<h2>Add city here</h2>
			<div class="row">
				<div class="col-md-6">
				<div class="add-city-form-section container">
					<form action="" method="post" class="add-city-form" name="add-city-form">
						<?php if(isset($_POST['city_submit']) and isset($message)){ echo $message; } ?>
						<div class="form-group city-form-group">
							<label>City title</label>
							<input type="text" name="city_title" class="city-field input-text-field city-field-1 form-control">
						</div>
						<div class="form-group city-form-group">
							<label>Select Province</label>
							<select name="city_province" class="city-field select-field city-field-2 form-control">
								<?php foreach ($provinces as $province): ?>
									<option value="<?php echo ($province->id); ?>"><?php echo $province->province_title; ?></option>
								<?php endforeach; ?>
							</select>
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
								<label>Import Provinces</label>
								<input type="file" name="city-import-file">
								<p class="import-sub-label">Cols in file should be 3 and in order id,city_title, province_title. Province should exist in the provinces table, city will map with the province.</p>
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
					$cities = $am_operations->get_all_cities();
				?>
				<h2>City Details</h2>
				<table id="city-table" class="table">
					<thead><tr><th>ID</th><th>City Title</th><th>Province</th><th scope="col"><button type="submit" name="delete-cityall" id = "delete-cityall" value="cityall" class="delete-cityall-btn btn btn-sm btn-outline-info">Delete All</button></th></tr></thead>
					<?php foreach ($cities as $city): ?>
					<tr>
						<td><?php echo ($city->id); ?></td>
						<td><?php echo $city->city_title; ?></td>
						<td><?php echo $am_operations->get_province($city->province)->province_title; ?></td>
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