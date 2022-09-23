<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$am_operations = new Am_Operations();
$message = '';
$cities = $am_operations->get_all_cities();

global $wpdb;

if(isset($_POST['postcode_submit'])){
	if(!empty($_POST['postcode_title']) and !empty($_POST['postcode_city'])){
		$postcode_title = strtolower($_POST['postcode_title']);
		$postcode_city = $_POST['postcode_city'];

		$postcode_data = ['postcode_title'=>$postcode_title, 'city'=>$postcode_city];
		

		$row = $wpdb->get_row("SELECT * FROM wp_am_postcodes where postcode_title='$postcode_title'");
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>Postcode already exists</p></div>";
			
		}
		else{
			$result = $am_operations->save_postcode($postcode_data);
			if ($result){
				$message = "<div class='message-div success-message alert alert-success'><p>postcode is added Successfully</p></div>";
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
if (isset($_POST['postcode-import-btn'])) {
	if (file_exists($_FILES['postcode-import-file']["tmp_name"])){

		$filename = $_FILES['postcode-import-file']['tmp_name'] ;

		$file_extension = pathinfo($_FILES['postcode-import-file']["name"], PATHINFO_EXTENSION);
		$allowed_file_extension = "csv";

		if ($file_extension == $allowed_file_extension) {
			$status = $am_import->import_postcode($_FILES['postcode-import-file']['tmp_name']);
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
			<h2>Add postcode here</h2>
			<div class="row">
				<div class="col-md-6">
					<div class="add-postcode-form-section container">
						<form action="" method="post" class="add-postcode-form" name="add-postcode-form">
							<?php if(isset($_POST['postcode_submit']) and isset($message)){ echo $message; } ?>
							<div class="form-group postcode-form-group">
								<label>postcode Title</label>
								<input type="text" name="postcode_title" class="postcode-field input-text-field postcode-field-1 form-control">
							</div>
							<div class="form-group area-form-group">
								<label>Select city(s)</label>
								<select name="postcode_city" class="postcode-field select-field postcode-field-2 form-control">
									<?php foreach ($cities as $city): ?>
										<option value="<?php echo ($city->id); ?>"><?php echo $city->city_title.', '.$city->province_title.', '.$city->area_title; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group postcode-form-group submit-btn-group">
								<input type="submit" name="postcode_submit" class="postcode-field submit-field postcode-field-2 btn btn-sm btn-outline-info" value="submit">
							</div>
						</form>
					</div>
				</div>

				<div class="col-md-4">
					<div class="import-form-area">
						<?php if(isset($_POST['postcode-import-btn']) and isset($import_message)){ echo $import_message; } ?>
						<form accept="" method="post" name="postcode-import-form" enctype="multipart/form-data">
							<div class="form-group">
								<label>Import Postcodes</label>
								<input type="file" name="postcode-import-file">
								<p class="import-sub-label">Cols in file should be 3 and in order id,postcode_title, city_title. City should exist in the cities table, postcode will map with the city.</p>
							</div>
							<div class="form-group">
								<input type="submit" name="postcode-import-btn" class="btn btn-sm btn-outline-info" value="Import">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="postcode-details-section details-section">
				<?php
					$postcodes = $am_operations->get_all_postcodes();
				?>
				<h2>postcode Details</h2>
				<table id="postcode-table" class="table">
					<thead><tr><th scope="col">postcode ID</th><th scope="col">postcode Title</th><th scope="col">postcode City</th><th scope="col"><button type="submit" name="delete-postcodeall" id = "delete-postcodeall" value="postcodeall" class="delete-postcodeall-btn btn btn-sm btn-outline-info">Delete All</button></th></tr></thead>
					<?php foreach ($postcodes as $postcode): ?>
					<tr>
						<td><?php echo ($postcode->id); ?></td>
						<td><?php echo $postcode->postcode_title; ?></td>
						<td><?php echo $am_operations->get_city($postcode->city)->city_title; ?></td>
						<td>
							<button type="submit" name="delete-postcode" id = "delete-postcode-<?php echo ($postcode->id); ?>" value="<?php echo ($postcode->id); ?>" class="delete-postcode-btn btn btn-sm btn-outline-info"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>