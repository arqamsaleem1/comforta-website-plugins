<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$am_operations = new Am_Operations();
$am_import = new Am_Import();
$message = '';
$import_message = "";

if(isset($_POST['province_submit'])){
	if(!empty($_POST['province_title'])){
		$province_title = strtolower($_POST['province_title']);
		$row = $wpdb->get_row("SELECT * FROM wp_am_provinces where province_title='$province_title'");
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>Province already exists</p></div>";
			
		}
		else{
			$result = $am_operations->save_province($province_title);
			if ($result){
				$message = "<div class='message-div success-message alert alert-success'><p>Province is added Successfully</p></div>";
			}
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>Please fill the form properly</p></div>";
	}
}

/*****Import Form Handling*****/
$import_message = "";
if (isset($_POST['province-import-btn'])) {
	if (file_exists($_FILES['province-import-file']["tmp_name"])){

		$filename = $_FILES['province-import-file']['tmp_name'] ;

		$file_extension = pathinfo($_FILES['province-import-file']["name"], PATHINFO_EXTENSION);
		$allowed_file_extension = "csv";

		if ($file_extension == $allowed_file_extension) {
			$status = $am_import->import_province($_FILES['province-import-file']['tmp_name']);
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
			<h2>Add province here</h2>
			<div class="row">
				<div class="col-md-6">
					<div class="add-province-form-section container">
						<form action="" method="post" class="add-province-form" name="add-province-form">
							<?php if(isset($_POST['province_submit']) and isset($message)){ echo $message; } ?>
							<div class="form-group province-form-group">
								<label>province Title</label>
								<input type="text" name="province_title" class="province-field input-text-field province-field-1 form-control">
							</div>
							<div class="form-group province-form-group submit-btn-group">
								<input type="submit" name="province_submit" class="province-field submit-field province-field-2 btn btn-sm btn-outline-info" value="submit">
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-4">
					<div class="import-form-area">
						<?php if(isset($_POST['province-import-btn']) and isset($import_message)){ echo $import_message; } ?>
						<form accept="" method="post" name="province-import-form" enctype="multipart/form-data">
							<div class="form-group">
								<label>Import Provinces</label>
								<input type="file" name="province-import-file">
								<p class="import-sub-label">Columns in the file should be two and in the same order id, province_title.</p>
							</div>
							<div class="form-group">
								<input type="submit" name="province-import-btn" class="btn btn-sm btn-outline-info" value="Import">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="province-details-section details-section">
				<?php
					$provinces = $am_operations->get_all_provinces();
				?>
				<h2>Province Details</h2>
				<table id="province-table" class="table">
					<thead><tr><th scope="col">Province ID</th><th scope="col">Province Title</th><th scope="col"><button type="submit" name="delete-provinceall" id = "delete-provinceall" value="provinceall" class="delete-provinceall-btn btn btn-sm btn-outline-info">Delete All</button></th></tr></thead>
					<?php foreach ($provinces as $province): ?>
					<tr>
						<td><?php echo ($province->id); ?></td>
						<td><?php echo $province->province_title; ?></td>
						<td>
							<button type="submit" name="delete-province" id = "delete-province-<?php echo ($province->id); ?>" value="<?php echo ($province->id); ?>" class="delete-province-btn btn btn-sm btn-outline-info"><i class="fa fa-trash"></i></button>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>