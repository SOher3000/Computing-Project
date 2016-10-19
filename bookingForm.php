<?php
	include_once("header.html");
	include_once("reducedMenu.php");
	include_once("db/db.php");
	
	$error = '';
	
	if(isset($_POST['submitted'])) {
		$Title=mysqli_real_escape_string($db, trim($_POST['Title']));
		$Name=mysqli_real_escape_string($db, trim($_POST['Name']));
		$Surname=mysqli_real_escape_string($db, trim($_POST['Surname']));		
		$Address1=mysqli_real_escape_string($db, trim($_POST['Address1']));
		$Address2=mysqli_real_escape_string($db, trim($_POST['Address2']));
		$Address3=mysqli_real_escape_string($db, trim($_POST['Address3']));
		$Address4=mysqli_real_escape_string($db, trim($_POST['Address4']));
		$PostCode=mysqli_real_escape_string($db, trim($_POST['PostCode']));
		$PhoneNum=mysqli_real_escape_string($db, trim($_POST['PhoneNum']));
		$Email=mysqli_real_escape_string($db, trim($_POST['Email']));
		
		$Date=mysqli_real_escape_string($db, trim($_POST['Date']));
		$TimeStart=mysqli_real_escape_string($db, trim($_POST['TimeStart']));
		$TimeFinish=mysqli_real_escape_string($db, trim($_POST['TimeFinish']));
		$BookingType=mysqli_real_escape_string($db, trim($_POST['BookingType']));
		$Rooms=mysqli_real_escape_string($db, trim($_POST['Rooms']));
		$EquipmentNotes=mysqli_real_escape_string($db, trim($_POST['EquipmentNotes']));
		
		session_start();
		$UserID = empty($_SESSION['userid']) ? 4 : $_SESSION['userid'];
		
		// Check that $TimeStart is not after $TimeFinish
		
		$A = new DateTime(); 
		$A->setTimestamp(strtotime($TimeStart));

		$B = new DateTime(); 
		$B->setTimestamp(strtotime($TimeFinish));

		if ($A > $B) {
			$error = 'The finish time of an event cannot be before the start time.';
		} else {
		
			// Check here that it's free using the DAYS table.
			if(!empty($TimeStart) && !empty($TimeFinish) && !empty($Date)) {
				$StartTime = new DateTime($TimeStart);
				$FinishTime = new DateTime($TimeFinish);
				
				$Times = array(
					$StartTime->format("H:i")
				);
				
				$query = "SELECT `DAYid` FROM `days` WHERE `Date` = '%s' AND (`%s` IS NOT NULL";
				$values = array($Date, $StartTime->format("H:i"));
				
				while($FinishTime->format("H:i") != $StartTime->format("H:i")) {
					$StartTime->add(new DateInterval("PT30M"));			
					$Times[] = $StartTime->format("H:i");
					
					$query .= " OR `%s` IS NOT NULL";
					$values[] = $StartTime->format("H:i");
				}
				
				array_unshift($values, $query . ")");
				// exit(call_user_func_array('sprintf', $values));
				$result = mysqli_query($db, call_user_func_array('sprintf', $values));
				if (mysqli_num_rows($result) === 0) {
					if(!empty($Title) && !empty($Name) && !empty($Surname) && !empty($Address1) && !empty($Address2) && !empty($PostCode) && !empty($PhoneNum) && !empty($Email)){
						$result = mysqli_multi_query($db,"INSERT INTO `bookingowner` SET Title ='$Title', Name ='$Name', Surname ='$Surname', Address1 ='$Address1', Address2 ='$Address2',Address3 ='$Address3', Address4 ='$Address4', PostCode ='$PostCode', PhoneNum ='$PhoneNum', Email='$Email'; INSERT INTO `booking` SET `TimeStart`='$TimeStart', `TimeFinish`='$TimeFinish', `BookingType`='$BookingType', `Room`='$Rooms', `EquipmentNotes`='$EquipmentNotes', `Date`='$Date', `userid` = '$UserID', `bookingOwnerid` = LAST_INSERT_ID();") or die(mysqli_error($db));
						
						if (empty($result)) {
							$error = 'Please fill all boxes.';
						} else {
							// Clears anything out created by the clever mysqli_multi_query
							while (mysqli_more_results($db) && mysqli_next_result($db)) {;}
							
							$bookingid = mysqli_insert_id($db);
							
							// Removing 30m
							$FinishTime = new DateTime($TimeFinish);
							$FinishTime->sub(new DateInterval("PT30M"));
							// echo $FinishTime->format("H:i"), PHP_EOL;
							$TimeFinish = $FinishTime->format("H:i");
							
							// If we assume that $TimeFinish > $TimeStart
							
							$queryTemplate = '`%s` = "%d"';
							$query = array();
							$values = array();
							
							$StartTime = new DateTime($TimeStart);
							
							$query[] = $queryTemplate;
							array_push($values, $StartTime->format("H:i"), $bookingid);
							
							while($FinishTime->format("H:i") != $StartTime->format("H:i")) {
								$StartTime->add(new DateInterval("PT30M"));
								
								$query[] = $queryTemplate;
								array_push($values, $StartTime->format("H:i"), $bookingid);
							}
							
							$query = 'UPDATE `days` SET ' . implode(", ", $query) . ' WHERE `Date`="%s"';
							array_unshift($values, $query);
							$values[] = $Date;
							
							// print_r($query); print_r($values);
							// echo "<br/>"; print_r(call_user_func_array('sprintf', $values));

							
							// $resultUPDATE = mysqli_query($db, 'UPDATE `days` SET `$TimeStart`="$bookingid", `$TimeFinish`="$bookingid" WHERE `Date`="2015-03-29"');
							mysqli_query($db, call_user_func_array('sprintf', $values)) or die(mysqli_error($db));
							
							//exit("booking success!");
							
							header('Location: bookingSuccess.php');
						}
					} else {
					$error = 'Please fill all.';
					}
				}
				else {
					$error = 'Slot taken, choose another date or time.';
				}
			} else {
				$error = 'Please enter a start time, finish time, and date.';
			}
		}
	}
	if(!empty($error)){
		echo "<div class='error' >$error</div>";
	};
	
	?>
	
		<div id='content' >
		<h3>Booking Details</h3>
		<form action='' method='POST' >
		<b>Title</b>&nbsp;<select name='Title'>
							<option value="">-- Please Choose</option>
							<option <?php if (!empty($_POST['Title']) && ($_POST["Title"] == "Miss")) { ?>selected="true"<?php } ?> value='Miss'>Miss</option>
							<option <?php if (!empty($_POST['Title']) && ($_POST["Title"] == "Mrs")) { ?>selected="true"<?php } ?>value='Mrs'>Mrs</option>
							<option <?php if (!empty($_POST['Title']) && ($_POST["Title"] == "Mr")) { ?>selected="true"<?php } ?>value='Mr'>Mr</option>
						</select><br/>
		<b>Name</b>&nbsp;<input type='text' name='Name' <?php if (!empty($_POST['Name'])) { ?>value="<?php echo $_POST['Name'];?>"<?php } ?>/>
						<br/>					
		<b>Surname</b>&nbsp;<input type='text' name='Surname' <?php if (!empty($_POST['Surname'])) { ?>value="<?php echo $_POST['Surname'];?>"<?php } ?>/>
						<br/>
		<b>Address</b>&nbsp;	<br/>
								&nbsp;&nbsp;<small>Line 1</small>&nbsp;<input type='text' name='Address1' size='100' <?php if (!empty($_POST['Address1'])) { ?>value="<?php echo $_POST['Address1'];?>"<?php } ?>/>
								<br/>
								&nbsp;&nbsp;<small>Line 2</small>&nbsp;<input type='text' name='Address2' size='100' <?php if (!empty($_POST['Address2'])) { ?>value="<?php echo $_POST['Address2'];?>"<?php } ?>/>
								<br/>
								&nbsp;&nbsp;<small>Line 3</small>&nbsp;<input type='text' name='Address3' size='100' <?php if (!empty($_POST['Address3'])) { ?>value="<?php echo $_POST['Address3'];?>"<?php } ?>/>
								<br/>
								&nbsp;&nbsp;<small>Line 4</small>&nbsp;<input type='text' name='Address4' size='100' <?php if (!empty($_POST['Address4'])) { ?>value="<?php echo $_POST['Address4'];?>"<?php } ?>/>
								<br/>
								&nbsp;&nbsp;<small>Post Code</small>
								&nbsp;&nbsp;<input type='text' name='PostCode' <?php if (!empty($_POST['PostCode'])) { ?>value="<?php echo $_POST['PostCode'];?>"<?php } ?>/>
								<br/>
		<b>Phone Number</b>&nbsp;
								&nbsp;&nbsp;<input type='text' name='PhoneNum' <?php if (!empty($_POST['PhoneNum'])) { ?>value="<?php echo $_POST['PhoneNum'];?>"<?php } ?>/>
							<br/>
		<b>Email</b>&nbsp;	<input type='email' name='Email' <?php if (!empty($_POST['Email'])) { ?>value="<?php echo $_POST['Email'];?>"<?php } ?>/>
							<br/>
							<br/>
								<p>Use date format YYYY-MM-DD</p>
		<b>Date</b>&nbsp;<input type='date' name='Date' /><br/>
		<b>Start Time</b>&nbsp;<select name='TimeStart'>
							<option value="">-- Please Choose</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "09:00")) { ?>selected="true"<?php } ?> value='09:00' >09:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "09:30")) { ?>selected="true"<?php } ?>value='09:30'>09:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "10:00")) { ?>selected="true"<?php } ?>value='10:00'>10:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "10:30")) { ?>selected="true"<?php } ?>value='10:30'>10:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "11:00")) { ?>selected="true"<?php } ?>value='11:00'>11:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "11:30")) { ?>selected="true"<?php } ?>value='11:30'>11:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "12:00")) { ?>selected="true"<?php } ?>value='12:00'>12:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "12:30")) { ?>selected="true"<?php } ?>value='12:30'>12:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "13:00")) { ?>selected="true"<?php } ?>value='13:00'>13:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "13:30")) { ?>selected="true"<?php } ?>value='13:30'>13:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "14:00")) { ?>selected="true"<?php } ?>value='14:00'>14:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "14:30")) { ?>selected="true"<?php } ?>value='14:30'>14:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "15:00")) { ?>selected="true"<?php } ?>value='15:00'>15:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "15:30")) { ?>selected="true"<?php } ?>value='15:30'>15:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "16:00")) { ?>selected="true"<?php } ?>value='16:00'>16:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "16:30")) { ?>selected="true"<?php } ?>value='16:30'>16:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "17:00")) { ?>selected="true"<?php } ?>value='17:00'>17:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "17:30")) { ?>selected="true"<?php } ?>value='17:30'>17:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "18:00")) { ?>selected="true"<?php } ?>value='18:00'>18:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "18:30")) { ?>selected="true"<?php } ?>value='18:30'>18:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "19:00")) { ?>selected="true"<?php } ?>value='19:00'>19:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "19:30")) { ?>selected="true"<?php } ?>value='19:30'>19:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "20:00")) { ?>selected="true"<?php } ?>value='20:00'>20:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "20:30")) { ?>selected="true"<?php } ?>value='20:30'>20:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "21:00")) { ?>selected="true"<?php } ?>value='21:00'>21:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "21:30")) { ?>selected="true"<?php } ?>value='21:30'>21:30</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "22:00")) { ?>selected="true"<?php } ?>value='22:00'>22:00</option>
							<option <?php if (!empty($_POST['TimeStart']) && ($_POST["TimeStart"] == "22:30")) { ?>selected="true"<?php } ?>value='22:30'>22:30</option>
						</select>
						<br/>					
		<b>Finish Time</b>&nbsp;<select name='TimeFinish'>
							<option value="">-- Please Choose</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "09:00")) { ?>selected="true"<?php } ?>value='09:00'>09:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "09:30")) { ?>selected="true"<?php } ?>value='09:30'>09:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "10:00")) { ?>selected="true"<?php } ?>value='10:00'>10:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "10:30")) { ?>selected="true"<?php } ?>value='10:30'>10:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "11:00")) { ?>selected="true"<?php } ?>value='11:00'>11:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "11:30")) { ?>selected="true"<?php } ?>value='11:30'>11:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "12:00")) { ?>selected="true"<?php } ?>value='12:00'>12:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "12:30")) { ?>selected="true"<?php } ?>value='12:30'>12:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "13:00")) { ?>selected="true"<?php } ?>value='13:00'>13:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "13:30")) { ?>selected="true"<?php } ?>value='13:30'>13:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "14:00")) { ?>selected="true"<?php } ?>value='14:00'>14:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "14:30")) { ?>selected="true"<?php } ?>value='14:30'>14:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "15:00")) { ?>selected="true"<?php } ?>value='15:00'>15:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "15:30")) { ?>selected="true"<?php } ?>value='15:30'>15:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "16:00")) { ?>selected="true"<?php } ?>value='16:00'>16:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "16:30")) { ?>selected="true"<?php } ?>value='16:30'>16:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "17:00")) { ?>selected="true"<?php } ?>value='17:00'>17:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "17:30")) { ?>selected="true"<?php } ?>value='17:30'>17:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "18:00")) { ?>selected="true"<?php } ?>value='18:00'>18:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "18:30")) { ?>selected="true"<?php } ?>value='18:30'>18:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "19:00")) { ?>selected="true"<?php } ?>value='19:00'>19:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "19:30")) { ?>selected="true"<?php } ?>value='19:30'>19:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "20:00")) { ?>selected="true"<?php } ?>value='20:00'>20:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "20:30")) { ?>selected="true"<?php } ?>value='20:30'>20:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "21:00")) { ?>selected="true"<?php } ?>value='21:00'>21:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "21:30")) { ?>selected="true"<?php } ?>value='21:30'>21:30</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "22:00")) { ?>selected="true"<?php } ?>value='22:00'>22:00</option>
							<option <?php if (!empty($_POST['TimeFinish']) && ($_POST["TimeFinish"] == "22:30")) { ?>selected="true"<?php } ?>value='22:30'>22:30</option>
						</select>
						<br/>
		<b>Type of Booking</b>&nbsp;	<br/>
								&nbsp;&nbsp;<input type='radio' name='BookingType' value='One-off' ><small><b>One-off Event</b></small>
								<br/>
								&nbsp;&nbsp;<input type='radio' name='BookingType' value='Weekly' ><small><b>Weekly Event</b></small>
								<br/>
								&nbsp;&nbsp;<input type='radio' name='BookingType' value='Monthly' ><small><b>Monthly Event</b></small>
								<br/>
		<b>Rooms</b>&nbsp;	<select name='Rooms'>
								<option <?php if (!empty($_POST['Rooms']) && ($_POST["Rooms"] == "Hall")) { ?>selected="true"<?php } ?>value='Hall'>Hall</option>
							</select>
							<br/>
								<!---
							
								<option value='Main Hall'>Main Hall</option>
								<option value='Small Hall'>Small Hall</option>
								<option value=''></option>
								
								--->
		<b>Equipment</b>&nbsp;<br/><input type='text' id='EquipmentNotes' name='EquipmentNotes'  size='100' value=''><br/>
								<input type='checkbox' name='EquipNotesNo' value='NoEquip'>I do not need any extra equipment.<br/><br/>
		
		
		<input type='hidden' name='submitted' value='true' />
		<input type='submit' value='Done'/>
		
		</form>
	</div>