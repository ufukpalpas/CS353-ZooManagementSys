<?php
include("config.php");
session_start();
if($_SESSION['login_user']) 
{
    $userid = $_SESSION['login_user']; 
    $name = $_SESSION['name'];
    if($_SESSION['type'] == "visitor"){
        $money = $_SESSION['money'];
    }
} else {
    header("location: events.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: events.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> KasaloZoo </title>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="loginstyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>
        <header>
            <a href="indexin.php" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
                    <li><a href="indexin.php">Main Page</a></li>
					<li><a href="animalsin.php">Animals</a></li>
					<li><a href="eventsin.php">Events</a></li>
					<li><a href="aboutin.php">About Zoo</a></li>
                    <?php
                    echo "<li>
                        <a href=\"#\" onclick=\"toggleuserPopup()\">Hello $name ($userid)
                        <img class=\"down\" src=\"image/user.png\" alt=\"user logo\">
                        </a>
                    </li>";
                    
                    echo "<li><a href=\"#\">$money
                    <img class=\"down\" src=\"image/dollar.png\" alt=\"dollar logo\">
                    </a></li>";
                    ?>
                    
				</ul>
			</nav>
		</header>
		<main>
		<div class="user-popup" id="user-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">Deposit Money</button>
                        <button class="btn">Make Donation</button>
                        <button class="btn">Create Complaint Form</button>
                        <button class="btn">My Events</button>
                        <button class="btn">Join a Group Tour</button>
                        <button class="btn">Join a Endangered Birthday</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>
            <script>
				function toggleuserPopup(){
                    document.getElementById("user-popup").classList.toggle("activate");
                }
            </script>
			<section class="event-links">
                <h2>Events</h2>
                <p>Various events for each age groups and different purposes</p>
				<div class="eventswrap">
					
					<a href="educationin.php">
						<div class="cases-link">
                            <img class="edu_prog" src="image/education.jpeg" alt="educational logo">
                        </div>
                        <br>
                        <p class="ev-names">Educational Programs</p>
					</a>
					<a href="conservein.php">
						<div class="cases-link">
							<img class="edu_prog" src="image/conserve.png" alt="conserve logo">
						</div>
                        <br>
                        <p class="ev-names">Conservational <br> Organizaitons</p>
					</a>
					<a href="grouptourin.php">
						<div class="cases-link">
							<img class="edu_prog" src="image/tour.jpg" alt="tour logo">
						</div>
                        <br>
                        <p class="ev-names">Group Tours</p>
					</a>
					<a href="birthdayin.php">
						<div class="cases-link">
							<img class="edu_prog" src="image/birthday.jpg" alt="birthday logo">
						</div>
                        <br>
                        <p class="ev-names">Animal Birthdays</p>
					</a>
				</div>
			</section>
		</main>
		<div class="wrapper"> <!-- alt kısım -->
			<footer>
				<div class="cont">
				<div class="add-link-div">
					<h5>Address</h5>
					<p>
					Bilkent University<br>
					06800 Bilkent, Ankara<br>
					TURKEY
					</p>
					<br>
					<br>
					<a href="#">
						<img src="image/youtube.png" alt="youtube logo">
					</a>
					<a href="#">
						<img src="image/twitter.png" alt="twitter logo">
					</a>
					<a href="#">
						<img src="image/facebook.png" alt="facebook logo">
					</a>
				</div>
				<div class="footer-links">
					<h5>CATEGORIES</h5>
					<ul class="footer-links-first">
                        <li><a href="indexin.php">Main Page</a></li>
						<li><a href="animalsin.php">Animals</a></li>
						<li><a href="eventsin.php">Events</a></li>
						<li><a href="aboutin.php">About Zoo</a></li>
					</ul>
				</div>
				<div class="partner-list">
					<h5>PARTNERS</h5>
					<p>Bilkent University</p>
				</div>
				</div>
			</footer>
		</div>
	</body>
</html>