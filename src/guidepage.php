<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && $_SESSION['type'] = "guide") 
{
    $userid = $_SESSION['login_user']; 
	$name = $_SESSION['name'];
} else {
    header("location: index.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: index.php");
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
					<li><a href="indexin.html">Main Page</a></li>
					<li><a href="animalsin.html">Animals</a></li>
					<li><a href="eventsin.html">Events</a></li>
					<li><a href="aboutin.html">About Zoo</a></li>
                    <?php
                    echo "<li>
                        <a href=\"#\" onclick=\"toggleuserPopup()\">Hello $name ($userid)
                        <img class=\"down\" src=\"image/user.png\" alt=\"user logo\">
                        </a>
                    </li>";
                    ?>
				</ul>
			</nav>
		</header>
		<main>
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
            <script>
				function toggleuserPopup(){
                    document.getElementById("guide-popup").classList.toggle("activate");
                }
            </script>
            <section class="mainsec">
                <h2>My Group Tours</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:26%">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select g.event_id, g.capacity, g.participant_count, e.start_date, e. duration
				 from group_tour g, event e
				 where g.guide_id = \"". $userid ."\" and g.event_id = e.event_id;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>    
						<th class=\"thtitle\">Capacity<hr></th>    
						<th class=\"thtitle\">Participant Count<hr></th>    
						<th class=\"thtitle\">Start Date<hr></th>   
						<th class=\"thtitle\">Duration<hr></th>  
					</tr>";
				if($result = $mysqli->query($query)){
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<tr>
								<th>". $row['event_id'] ."<hr></th>    
								<th>". $row['capacity'] ."<hr></th>    
								<th>". $row['participant_count'] ."<hr></th>    
								<th>". $row['start_date'] ."<hr></th>    
								<th>". $row['duration'] ."<hr></th>    
							</tr>";
					}
				} else {
					echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";
				?>
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
						<li><a href="indexin.html">Main Page</a></li>
						<li><a href="animalsin.html">Animals</a></li>
						<li><a href="eventsin.html">Events</a></li>
						<li><a href="aboutin.html">About Zoo</a></li>
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