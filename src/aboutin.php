<?php
include("config.php");
session_start();
if($_SESSION['login_user']) 
{
    $userid = $_SESSION['login_user']; 
    $name = $_SESSION['name'];
	$usertype = $_SESSION['type'];
    if($_SESSION['type'] == "visitor"){
        $money = $_SESSION['money'];
    }
} else {
    header("location: about.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: about.php");
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
                    
                    if($usertype == "visitor")
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
			<div class="user-popup" id="coor-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">Cage Management</button>
                        <button class="btn">Create Event</button>
                        <button class="btn">Respond to Complaint Forms</button>
                        <button class="btn">Management</button>
                        <button class="btn">Register a New Employee</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>

			<div class="user-popup" id="keep-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">My Cages</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>

			<div class="user-popup" id="guide-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">My Tours</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>

			<div class="user-popup" id="vet-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">Treatments</button>
						<button class="btn">Invitations</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>

			<?php
				if($usertype == "visitor"){
					echo "<script>
						function toggleuserPopup(){
							document.getElementById(\"user-popup\").classList.toggle(\"activate\");
						}
					</script>";
				} else if($usertype == "keeper") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"keep-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "vet") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"vet-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "coor") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"coor-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "guide") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"guide-popup\").classList.toggle(\"activate\");
					}
					</script>";
				}
			?>
            <section class="mainsec">
                <h2>About Us</h2>
                <article>
                    <h3>Group 33</h3>
                    <p>
                        Ufuk Palpas 21702958<br>
                        Asya Doğa Özer 21803479<br>
                        Can Kılıç 21703333<br>
                        Ege Çetin 21802305 <br>
                    </p>
                    <p>
                        Project website: &nbsp;
                        <a href="http://www.cs353group33.tk">www.cs353group33.tk</a><br>
                    </p>
                </article>
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