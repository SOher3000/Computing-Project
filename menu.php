<?php
if(isset($_SESSION['user'])) {

}else{
session_start();
}

$loginItem = '';
if(isset($_SESSION['user'])){
$loginItem = '<a href="logout.php"><div class="LogoutBtn" >Logout</div></a>';
}else{
$loginItem = '<a href="login.php"><div class="LoginBtn" >Login</div></a>';
}

	
	
	
	
	
	
	
	?>
	<div class='NavBar' >
		<div class='NavBarBackground' >
			<div class='BtnBackground' id='BtnHomeBackground' >
				<div class='Btn' id='BtnHome'>
					<div class='BtnTxt' id='BtnTxtHome' >
						<a href="index.php"><p> Home </p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnWelcomeBackground' >
				<div class='Btn' id='BtnWelcome' >
					<div class='BtnTxt' id='BtnTxtWelcome' >
						<a href="#Welcome"><p>Welcome</p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnAboutHallBackground' >
				<div class='Btn' id='BtnAboutHall' >
					<div class='BtnTxt' id='BtnTxtAboutHall' >
						<a href="#AboutHall"><p>About</p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnFacilitiesBackground' >
				<div class='Btn' id='BtnFacilities' >
					<div class='BtnTxt' id='BtnTxtFacilities' >
						<a href="#Facilities"><p>Facilities</p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnBookingBackground' >
				<div class='Btn' id='BtnBooking' >
					<div class='BtnTxt' id='BtnTxtBooking' >
						<a href="#Booking"><p>Booking</p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnContactsBackground' >
				<div class='Btn' id='BtnContacts' >
					<div class='BtnTxt' id='BtnTxtContacts' >
						<a href="#Contacts"><p>Contacts</p></a>
					</div>
				</div>
			</div>
			<div class='BtnBackground' id='BtnLoginoutBackground' >
				<div class='Btn' id='BtnLoginout' >
					<div class='BtnTxt' id='BtnTxtLoginout' >
						<?php
						
						echo "$loginItem";
							?>
					</div>
				</div>
			</div>
		</div>
	</div>