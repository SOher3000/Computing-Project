<?php
	include_once("header.html");
	include_once("reducedMenu.php");
	require_once("db/db.php");

	$newBookingItem = '';
	if(isset($_SESSION['user'])){
	$newBookingItem = '<a href="bookingForm.php"><p>Enter another booking</p></a>';
	}else{
	$newBookingItem = '';
	}

	
	
	
	
	
	?>
	<div id='content' style='text-align:center;' >
		<p><strong>Booking Successful!</strong></p><br/><br/>
		
		<?php
		
		echo $newBookingItem;
		
		?>
	</div>
	