<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$am_operations = new Am_Operations();
$message = '';

if(isset($_POST['area_submit'])){
	if(!empty($_POST['area_title']) and !empty($_POST['area_city'])){
		$title = strtolower($_POST['area_title']);
		$area_cities = implode(",",$_POST['area_city']);
		
		$areas_table_name = $wpdb->prefix . 'am_areas';
		$area_data = ['area_title'=>$title, 'cities'=>$area_cities];
		global $wpdb;
		$row = $wpdb->get_row("SELECT * FROM $areas_table_name where area_title='$title'");
		
		if(isset($row)){
			$message = "<div class='message-div error-message alert alert-warning'><p>area already exists</p></div>";
			
		}
		else{
			
			$result = $am_operations->save_area($area_data);
			$cities_result = $am_operations->update_areas_in_cities($_POST['area_city'], $title);
			if ($result and $cities_result){

				$message = "<div class='message-div success-message alert alert-success'><p>area is added Successfully ".$cities_result." </p></div>";
			}
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>Please fill the form properly</p></div>";
	}
}
?>
<script>
	var plugin_area_page = true;
</script>


<div class="am-admin-wrapper">
	<div class="container">
		<div class="am-admin-container">
			<div class="add-area-form-section container">
				<h2>Add Area here</h2>
				<form action="" method="post" class="add-area-form" name="add-area-form">
					<?php if(isset($_POST['area_submit']) and isset($message)){ echo $message; } ?>
					<div class="form-group area-form-group">
						<label>Area Title</label>
						<input type="text" name="area_title" class="area-field input-text-field area-field-1 form-control">
					</div>
					<div class="form-group area-form-group">
						<label>Select city(s)</label>
						<select name="area_city[]" class="area-field select2 select-field area-field-2 form-control" multiple="multiple" style="width: 100%;"></select>
					</div>
					<div class="form-group area-form-group submit-btn-group">
						<input type="submit" name="area_submit" class="area-field submit-field btn btn-sm btn-outline-info" value="submit">
					</div>
				</form>
			</div>

			<div class="area-details-section details-section">
				<?php
					$areas = $am_operations->get_all_areas();
				?>
				<h2>area Details</h2>
				<table id="area-table" class="table">
					<thead><tr><th scope="col">ID</th><th scope="col">area Title</th><th scope="col"><button type="submit" name="delete-areaall" id = "delete-areaall" value="areaall" class="delete-areaall-btn btn btn-sm btn-outline-info">Delete All</button></th></tr></thead>
					<?php foreach ($areas as $area): ?>
					<tr>
						<td><?php echo ($area->id); ?></td>
						<td><?php echo $area->area_title; ?></td>
						<td>
							<button type="submit" name="delete-area" id = "delete-area-<?php echo ($area->id); ?>" value="<?php echo ($area->id); ?>" class="delete-area-btn btn btn-sm btn-outline-info"><i class="fa fa-trash"></i></button>
						</td>
						<td>
							<?php
								$area_status = $am_operations->get_area_status($area->id);
								if($area_status->status == true):
							?>
							<button type="submit" name="disable-area" id = "disable-area-<?php echo ($area->id); ?>" value="<?php echo ($area->id); ?>" class="disable-area-btn btn btn-sm btn-outline-info">Disable</button>
							<?php else: ?>
								<button type="submit" name="enable-area" id = "enable-area-<?php echo ($area->id); ?>" value="<?php echo ($area->id); ?>" class="enable-area-btn  btn btn-sm btn-outline-info">Enable</button>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>