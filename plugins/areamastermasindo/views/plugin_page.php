<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$message = '';

if(isset($_POST['settings_submit'])){
	if(!empty($_POST['settings_submit'])){
		
		$delete_setting = strtolower($_POST['deleteallrecords']);
		if(isset($_POST['deleteallrecords']) and $delete_setting=='yes'){
			$setting_result = update_option('am_delete_data',$delete_setting);
		}
		else{
			$setting_result = update_option('am_delete_data','no');
		}
		
		if ($setting_result){
			$message = "<div class='message-div success-message alert alert-success'><p>Setting Updated Successfully</p></div>";
		}
		
	}
	else{
		$message = "<div class='message-div error-message alert alert-warning'><p>There is some prblem</p></div>";
	}
}
?>
<div class="am-settings">
<div class="container">
	<h2>Area Master Massindo Settings</h2>
	<form action="" method="post" name="am-settings-form">
		<?php if(isset($_POST['postcode_submit']) and isset($message)){ echo $message; } ?>
		<div class="form-group settings-form-group">
			<label>Delete all plugin settings on deactivation.</label>
			<input type="checkbox" name="deleteallrecords" value='yes' class="form-control" <?php if(get_option( 'am_delete_data') == 'yes'): ?> checked <?php endif?>>
		</div>
		<div class="form-group settings-form-group submit-btn-group">
			<input type="submit" name="settings_submit" class="settings-field submit-field settings-field-2 btn btn-sm btn-outline-info" value="save">
		</div>
	</form>
</div>	
</div>