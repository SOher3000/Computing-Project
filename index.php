<?php
	require_once("header.html");
	require_once("menu.php");
	require_once("db/db.php");
	
	$makeBookingLinkItem = '';
	if(isset($_SESSION['user'])){
	$makeBookingLinkItem = '<a href="bookingForm.php" ><p>Make a Booking</p><a/>';
	}else{
	$makeBookingLinkItem = '';
	}
	
	$currentDate = date('Y-m-d');
	$CalDate = mysql_real_escape_string($currentDate);
	//echo $CalDate, PHP_EOL;
	
	if(isset($_POST['submitted'])) {
		$CalDate=trim($_POST['newDate']);
	}

	
	/*//IMPORTANT
	$resultStart = mysqli_query($db, sprintf('SELECT `TimeStart` FROM `booking` WHERE Date="%s"', $CalDate));
	$rowStart = mysqli_fetch_array($resultStart);
	$TimeStart = $rowStart['TimeStart'];
	//echo $TimeStart;
	$TimeStart = substr($TimeStart, 0, 5 );
	echo $TimeStart, PHP_EOL;
	
	$resultFinish = mysqli_query($db, sprintf('SELECT `TimeFinish` FROM `booking` WHERE Date="%s"', $CalDate));
	$rowFinish = mysqli_fetch_array($resultFinish);
	$TimeFinish = $rowFinish['TimeFinish'];
	//echo $TimeFinish;
	$TimeFinish = substr($TimeFinish, 0, 5 );
	//echo $TimeFinish;
	$FinishTime =  new DateTime($TimeFinish);
	$FinishTime->sub(new DateInterval("PT30M"));
	// echo $FinishTime->format("H:i"), PHP_EOL;
	$TimeFinish = $FinishTime->format("H:i");
	echo $TimeFinish, PHP_EOL;
	
	$resultID = mysqli_query($db, sprintf('SELECT `bookingid` FROM `booking` WHERE Date="%s"', $CalDate));
	$rowID = mysqli_fetch_array($resultID);
	$bookingid = $rowID['bookingid'];
	echo $bookingid;
	
	// If we assume that $TimeFinish > $TimeStart
	
	$queryTemplate = '`%s` = "%d"';
	$query = array();
	$values = array();
	
	$StartTime = new DateTime($TimeStart);
	
	$query[] = $queryTemplate;
	array_push($values, $StartTime->format("H:i"), $bookingid);
	
	while($FinishTime->format("H:i") != $StartTime->format("H:i")) {
		$StartTime->add(new DateInterval("PT30M"));
		echo $StartTime->format("H:i");
		
		$query[] = $queryTemplate;
		array_push($values, $StartTime->format("H:i"), $bookingid);
	}
	
	$query = 'UPDATE `days` SET ' . implode(", ", $query) . ' WHERE `Date`="%s"';
	array_unshift($values, $query);
	$values[] = $CalDate;
	
	// print_r($query); print_r($values);
	echo "<br/>"; print_r(call_user_func_array('sprintf', $values));

	
	// $resultUPDATE = mysqli_query($db, 'UPDATE `days` SET `$TimeStart`="$bookingid", `$TimeFinish`="$bookingid" WHERE `Date`="2015-03-29"');
	$resultUPDATE = mysqli_query($db, call_user_func_array('sprintf', $values));
	
	//For ($x = 0, $x >= $TimeStart and $x <= $TimeFinish)*/
	

	?>
		</div>
			<div class='PageMain'>
				<div class='PageContentBackground' >
					<div class='SectionBackground' id='BackgroundWelcome' >
						<a name="Welcome" ></a>	
						<div id='Welcome' class='ContentWrap' >
							<div class='WelcomeContent' >
								<div class='WelcomeContent' id='WelcomeHeader' >
									<div class='HeaderTxt' id='WelcomeHeaderTxt' >
										<p>Welcome</p>
									</div>
								</div>
								<div class='WelcomeContent' id='WelcomeContentMain' >
									<div class='ContentBackground'>
										<div class='ContentTxt' id='WelcomeContentTxt' >
											<p>Welcome to the Herne and Broomfield Community Hall.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="featurette-divider">
					
					<div class='SectionBackground' id='BackgroundAboutHall' >
						<a name="AboutHall" ></a>	
						<div id='AboutHall' class='ContentWrap'>
							<div class='AboutHallContent' >
								<div class='AboutHallContent' id='AboutHallHeader' >
									<div class='HeaderTxt' id='AboutHallHeaderTxt' >
										<p>About The Hall</p>
									</div>
								</div>
								<div class='AboutHallContent' id='AboutHallContentMain' >
									<div class='ContentBackground'>
										<div class='ContentTxt' id='AboutHallContentTxt' >
											<p>About The Hall Content Content Content Content</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="featurette-divider">
					
					<div class='SectionBackground' id='BackgroundFacilities'>
						<a name="Facilities" ></a>	
						<div id='Facilities' class='ContentWrap'>
							<div class='FacilitiesContent' >
								<div class='FacilitiesContent' id='FacilitiesHeader' >
									<div class='HeaderTxt' id='FacilitiesHeaderTxt' >
										<p>Facilities</p>
									</div>
								</div>
								<div class='FacilitiesContent' id='FacilitiesContentMain' >
									<div class='ContentBackground'>
										<div class='ContentTxt' id='FacilitiesContentTxt' >
											<p>Facilities Content Content Content Content</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="featurette-divider">
					
					<div class='SectionBackground' id='BackgroundBooking'>
						<a name="Booking" ></a>	
						<div id='Booking' class='ContentWrap' >
							<div class='BookingContent' >
								<div class='BookingContent' id='BookingHeader' >
									<div class='HeaderTxt' id='BookingHeaderTxt' >
										<p>Booking</p>
									</div>
								</div>
								<div class='BookingContent' id='BookingContentMain' >
									<div class='ContentBackground'>
										<div class='ContentTxt' id='BackingContentTxt' >
											<p>Bookings can be made in half-hour timeslots.<br/>Bookings can currently be only made for the Main Hall (The current hall).</p>
											
										<!---Next part will change depending on selection so will be within php script
										
										     It will also have php within it as queries to the database.           --->										
											
											<div id='TableBackground' >
												<table id='DayBooking' >
													
													
											<!--Changing Date of Calendar-->
											
													
													<div id='DateInput'>
														Use date format YYYY-MM-DD
														<form action='' method='POST'>
															Input date to view bookings:&nbsp;<input type='date' name='newDate' />
															<input type='hidden' name='submitted' value='true' />
															<input type='submit' value='Go'/>
														</form>
													</div>
													
													
													<caption><h4>Bookings for: <?php echo $CalDate;?></h4><br/></caption>
													
											<!--Calendar-->
													<tr>
														<th id='TimeCol'></th>
														<th id='&1'>Main Hall</th>
														<th id='&2' class='inProg'>Small Hall</th>
														<th id='&3' class='inProg'>Meeting Room</th>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>09:00</td>
														<?php 
																		
																	$resultA1 = mysqli_query($db,'SELECT `09:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowA1 = mysqli_fetch_array($resultA1);
																	$queryA1 = $rowA1['09:00'];

																	
																	if (is_null($queryA1)) { 
																		echo '<td id="A1"><p>Free</p></td>';
																	} else {
																		echo '<td id="A1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='A2' class='inProg'></td>
														<td id='A3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>09:30</td>
														<?php 
																		
																	$resultB1 = mysqli_query($db,'SELECT `09:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowB1 = mysqli_fetch_array($resultB1);
																	$queryB1 = $rowB1['09:30'];

																	
																	if (is_null($queryB1)) { 
																		echo '<td id="B1"><p>Free</p></td>';
																	} else {
																		echo '<td id="B1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='B2' class='inProg'></td>
														<td id='B3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>10:00</td>
														<?php 
																		
																	$resultC1 = mysqli_query($db,'SELECT `10:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowC1 = mysqli_fetch_array($resultC1);
																	$queryC1 = $rowC1['10:00'];

																	
																	if (is_null($queryC1)) { 
																		echo '<td id="C1"><p>Free</p></td>';
																	} else {
																		echo '<td id="C1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='C2' class='inProg'></td>
														<td id='C3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>10:30</td>
														<?php 
																		
																	$resultD1 = mysqli_query($db,'SELECT `10:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowD1 = mysqli_fetch_array($resultD1);
																	$queryD1 = $rowD1['10:30'];

																	
																	if (is_null($queryD1)) { 
																		echo '<td id="D1"><p>Free</p></td>';
																	} else {
																		echo '<td id="D1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='D2' class='inProg'></td>
														<td id='D3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>11:00</td>
														<?php 
																		
																	$resultE1 = mysqli_query($db,'SELECT `11:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowE1 = mysqli_fetch_array($resultE1);
																	$queryE1 = $rowE1['11:00'];

																	
																	if (is_null($queryE1)) { 
																		echo '<td id="E1"><p>Free</p></td>';
																	} else {
																		echo '<td id="E1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='E2' class='inProg'></td>
														<td id='E3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>11:30</td>
														<?php 
																		
																	$resultF1 = mysqli_query($db,'SELECT `11:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowF1 = mysqli_fetch_array($resultF1);
																	$queryF1 = $rowF1['11:30'];

																	
																	if (is_null($queryF1)) { 
																		echo '<td id="F1"><p>Free</p></td>';
																	} else {
																		echo '<td id="F1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='F2' class='inProg'></td>
														<td id='F3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>12:00</td>
														<?php 
																		
																	$resultG1 = mysqli_query($db,'SELECT `12:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowG1 = mysqli_fetch_array($resultG1);
																	$queryG1 = $rowG1['12:00'];

																	
																	if (is_null($queryG1)) { 
																		echo '<td id="G1"><p>Free</p></td>';
																	} else {
																		echo '<td id="G1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='G2' class='inProg'></td>
														<td id='G3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>12:30</td>
														<?php 
																		
																	$resultH1 = mysqli_query($db,'SELECT `12:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowH1 = mysqli_fetch_array($resultH1);
																	$queryH1 = $rowH1['12:30'];

																	
																	if (is_null($queryH1)) { 
																		echo '<td id="H1"><p>Free</p></td>';
																	} else {
																		echo '<td id="H1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='H2' class='inProg'></td>
														<td id='H3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>13:00</td>
														<?php 
																		
																	$resultI1 = mysqli_query($db,'SELECT `13:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowI1 = mysqli_fetch_array($resultI1);
																	$queryI1 = $rowI1['13:00'];

																	
																	if (is_null($queryI1)) { 
																		echo '<td id="I1"><p>Free</p></td>';
																	} else {
																		echo '<td id="I1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='I2' class='inProg'></td>
														<td id='I3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>13:30</td>
														<?php 
																		
																	$resultJ1 = mysqli_query($db,'SELECT `13:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowJ1 = mysqli_fetch_array($resultJ1);
																	$queryJ1 = $rowJ1['13:30'];

																	
																	if (is_null($queryJ1)) { 
																		echo '<td id="J1"><p>Free</p></td>';
																	} else {
																		echo '<td id="J1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='J2' class='inProg'></td>
														<td id='J3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>14:00</td>
														<?php 
																		
																	$resultK1 = mysqli_query($db,'SELECT `14:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowK1 = mysqli_fetch_array($resultK1);
																	$queryK1 = $rowK1['14:00'];

																	
																	if (is_null($queryK1)) { 
																		echo '<td id="K1"><p>Free</p></td>';
																	} else {
																		echo '<td id="K1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='K2' class='inProg'></td>
														<td id='K3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>14:30</td>
														<?php 
																		
																	$resultL1 = mysqli_query($db,'SELECT `14:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowL1 = mysqli_fetch_array($resultL1);
																	$queryL1 = $rowL1['14:30'];

																	
																	if (is_null($queryL1)) { 
																		echo '<td id="L1"><p>Free</p></td>';
																	} else {
																		echo '<td id="L1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='L2' class='inProg'></td>
														<td id='L3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>15:00</td>
														<?php 
																		
																	$resultM1 = mysqli_query($db,'SELECT `15:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowM1 = mysqli_fetch_array($resultM1);
																	$queryM1 = $rowM1['15:00'];

																	
																	if (is_null($queryM1)) { 
																		echo '<td id="M1"><p>Free</p></td>';
																	} else {
																		echo '<td id="M1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='M2' class='inProg'></td>
														<td id='M3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>15:30</td>
														<?php 
																		
																	$resultN1 = mysqli_query($db,'SELECT `15:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowN1 = mysqli_fetch_array($resultN1);
																	$queryN1 = $rowN1['15:30'];

																	
																	if (is_null($queryN1)) { 
																		echo '<td id="N1"><p>Free</p></td>';
																	} else {
																		echo '<td id="N1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='N2' class='inProg'></td>
														<td id='N3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>16:00</td>
														<?php 
																		
																	$resultO1 = mysqli_query($db,'SELECT `16:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowO1 = mysqli_fetch_array($resultO1);
																	$queryO1 = $rowO1['16:00'];

																	
																	if (is_null($queryO1)) { 
																		echo '<td id="O1"><p>Free</p></td>';
																	} else {
																		echo '<td id="O1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='O2' class='inProg'></td>
														<td id='O3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>16:30</td>
														<?php 
																		
																	$resultP1 = mysqli_query($db,'SELECT `16:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowP1 = mysqli_fetch_array($resultP1);
																	$queryP1 = $rowP1['16:30'];

																	
																	if (is_null($queryP1)) { 
																		echo '<td id="P1"><p>Free</p></td>';
																	} else {
																		echo '<td id="P1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='P2' class='inProg'></td>
														<td id='P3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>17:00</td>
														<?php 
																		
																	$resultQ1 = mysqli_query($db,'SELECT `17:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowQ1 = mysqli_fetch_array($resultQ1);
																	$queryQ1 = $rowQ1['17:00'];

																	
																	if (is_null($queryQ1)) { 
																		echo '<td id="Q1"><p>Free</p></td>';
																	} else {
																		echo '<td id="Q1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='Q2' class='inProg'></td>
														<td id='Q3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>17:30</td>
														<?php 
																		
																	$resultR1 = mysqli_query($db,'SELECT `17:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowR1 = mysqli_fetch_array($resultR1);
																	$queryR1 = $rowR1['17:30'];

																	
																	if (is_null($queryR1)) { 
																		echo '<td id="R1"><p>Free</p></td>';
																	} else {
																		echo '<td id="R1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='R2' class='inProg'></td>
														<td id='R3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>18:00</td>
														<?php 
																		
																	$resultS1 = mysqli_query($db,'SELECT `18:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowS1 = mysqli_fetch_array($resultS1);
																	$queryS1 = $rowS1['18:00'];

																	
																	if (is_null($queryS1)) { 
																		echo '<td id="S1"><p>Free</p></td>';
																	} else {
																		echo '<td id="S1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='S2' class='inProg'></td>
														<td id='S3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>18:30</td>
														<?php 
																		
																	$resultT1 = mysqli_query($db,'SELECT `18:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowT1 = mysqli_fetch_array($resultT1);
																	$queryT1 = $rowT1['18:30'];

																	
																	if (is_null($queryT1)) { 
																		echo '<td id="T1"><p>Free</p></td>';
																	} else {
																		echo '<td id="T1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='T2' class='inProg'></td>
														<td id='T3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>19:00</td>
														<?php 
																		
																	$resultU1 = mysqli_query($db,'SELECT `19:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowU1 = mysqli_fetch_array($resultU1);
																	$queryU1 = $rowU1['19:00'];

																	
																	if (is_null($queryU1)) { 
																		echo '<td id="U1"><p>Free</p></td>';
																	} else {
																		echo '<td id="U1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='U2' class='inProg'></td>
														<td id='U3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>19:30</td>
														<?php 
																		
																	$resultV1 = mysqli_query($db,'SELECT `19:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowV1 = mysqli_fetch_array($resultV1);
																	$queryV1 = $rowV1['19:30'];

																	
																	if (is_null($queryV1)) { 
																		echo '<td id="V1"><p>Free</p></td>';
																	} else {
																		echo '<td id="V1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='V2' class='inProg'></td>
														<td id='V3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>20:00</td>
														<?php 
																		
																	$resultW1 = mysqli_query($db,'SELECT `20:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowW1 = mysqli_fetch_array($resultW1);
																	$queryW1 = $rowW1['20:00'];

																	
																	if (is_null($queryW1)) { 
																		echo '<td id="W1"><p>Free</p></td>';
																	} else {
																		echo '<td id="W1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='W2' class='inProg'></td>
														<td id='W3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>20:30</td>
														<?php 
																		
																	$resultX1 = mysqli_query($db,'SELECT `20:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowX1 = mysqli_fetch_array($resultX1);
																	$queryX1 = $rowX1['20:30'];

																	
																	if (is_null($queryX1)) { 
																		echo '<td id="X1"><p>Free</p></td>';
																	} else {
																		echo '<td id="X1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='X2' class='inProg'></td>
														<td id='X3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>21:00</td>
														<?php 
																		
																	$resultY1 = mysqli_query($db,'SELECT `21:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowY1 = mysqli_fetch_array($resultY1);
																	$queryY1 = $rowY1['21:00'];

																	
																	if (is_null($queryY1)) { 
																		echo '<td id="Y1"><p>Free</p></td>';
																	} else {
																		echo '<td id="Y1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='Y2' class='inProg'></td>
														<td id='Y3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>21:30</td>
														<?php 
																		
																	$resultZ1 = mysqli_query($db,'SELECT `21:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowZ1 = mysqli_fetch_array($resultZ1);
																	$queryZ1 = $rowZ1['21:30'];

																	
																	if (is_null($queryZ1)) { 
																		echo '<td id="Z1"><p>Free</p></td>';
																	} else {
																		echo '<td id="Z1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='Z2' class='inProg'></td>
														<td id='Z3' class='inProg'></td>
													</tr>
													<tr class='dark' >
														<td id='TimeCol'>22:00</td>
														<?php 
																		
																	$resulta1 = mysqli_query($db,'SELECT `22:00` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowa1 = mysqli_fetch_array($resulta1);
																	$querya1 = $rowa1['22:00'];

																	
																	if (is_null($querya1)) { 
																		echo '<td id="a1"><p>Free</p></td>';
																	} else {
																		echo '<td id="a1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='a2' class='inProg'></td>
														<td id='a3' class='inProg'></td>
													</tr>
													<tr>
														<td id='TimeCol'>22:30</td>
														<?php 
																		
																	$resultb1 = mysqli_query($db,'SELECT `22:30` FROM `days` WHERE `Date` = "'.$CalDate.'"') or die(mysqli_error($db));

																	$rowb1 = mysqli_fetch_array($resultb1);
																	$queryb1 = $rowb1['22:30'];

																	
																	if (is_null($queryb1)) { 
																		echo '<td id="b1"><p>Free</p></td>';
																	} else {
																		echo '<td id="b1" style="background-color:#405C5C; color:#000000;"><p>Booked</p></td>';
																	};
														
																			?>
														<td id='b2' class='inProg'></td>
														<td id='b3' class='inProg'></td>
												</table>
											</div>
											
										<!---End--->
										
										<?php echo "$makeBookingLinkItem"; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="featurette-divider">					

					<div class='SectionBackground' id='BackgroundContacts'>
						<a name="Contacts" ></a>	
						<div id='Contacts' class='ContentWrap' >
							<div class='ContactsContent' >
								<div class='ContactsContent' id='ContactsHeader' >
									<div class='HeaderTxt' id='ContactsHeaderTxt' >
										<p>Contacts</p>
									</div>
								</div>
								<div class='ContactsContent' id='ContactsContentMain' >
									<div class='ContentBackground'>
										<div class='ContentTxt' id='ContactsContentTxt' >
											<p>Contacts Content Content Content Content</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr class="featurette-divider">
					
				</div>
			</div>		
<?php
	include_once("footer.html");
	?>