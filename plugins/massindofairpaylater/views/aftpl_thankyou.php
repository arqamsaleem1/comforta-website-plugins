<?php
session_start();
if(isset($_SESSION['last_cart'])){
	$massindo_redirect_url = $_SESSION['last_cart'];
}
else{
	$massindo_redirect_url = 'https://www.massindofair.com/';
}
 ?>

<div class="afpl-thankyou-content">
	<div class="afpl-thankyou-container">
		<h2>Thank you for your interest</h2>

		<p>You will be redirected to our partner website to process "Pay Later" payment.</p>
		<p>Thank you for your visit in our website.</p>
		<p><strong>You will be redirected in 3 seconds . . .</strong></p>
		<script>
			 // Your application has indicated there's an error
		     window.setTimeout(function(){

		         // Move to a new location or you can do something else
		         window.location.href = "<?php echo $massindo_redirect_url; ?>";

		     }, 3000);
		</script>
	</div>

</div>

<style type="text/css">
.afpl-thankyou-container {
    padding: 50px;
}
</style>