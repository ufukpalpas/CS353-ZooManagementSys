<?php
include("config.php");
session_start();
if($_SESSION['login_user']) // değişecek
{
    $cageid = $_SESSION['cageid'];
    $animalid = $_SESSION['animalid'];
    
    $anamequery = "select name from animal where animal_id ='". $animalid ."'"; 
    $anamearr = mysqli_query($mysqli, $anamequery);
    $fetchaarr = mysqli_fetch_array($anamearr, MYSQLI_ASSOC);
    $aname = $fetchaarr['name'];

    $userid = $_SESSION['login_user']; // değişecek
    $namequery = "select name from user where user_id ='". $userid ."'"; //session name e kadarlık kısım indexin.html e alınacak buraya sessiondan çekme gelecek
    $namearr = mysqli_query($mysqli, $namequery);
    $fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
    $name = $fetcharr['name'];
    $_SESSION['name'] = $name;

    $moneyquery = "select money from visitor where user_id ='". $userid ."'"; //session name e kadarlık kısım indexin.html e alınacak buraya sessiondan çekme gelecek
    $moneyarr = mysqli_query($mysqli, $moneyquery);// yanlızca visitor
    $fetchmarr = mysqli_fetch_array($moneyarr, MYSQLI_ASSOC);
    $money = $fetchmarr['money'];
    $_SESSION['money'] = $money;
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
			<a href="indexin.html" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="indexin.html">Main Page</a></li>
					<li><a href="animalsin.html">Animals</a></li>
					<li><a href="eventsin.html">Events</a></li>
					<li><a href="aboutin.html">About Zoo</a></li>
                    <li>
                        <a href="#" onclick="toggleuserPopup()">Hello "username" ("user_id")
                        <img class="down" src="image/user.png" alt="user logo">
                        </a>
                    </li>
                    <li><a href="#">"money"</a></li>
                    <img class="dollar" src="image/dollar.png" alt="dollar logo">
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
            <section class="mainsec">
                <?php
                echo "<h2>Cage #$cageid / Animal #$animalid / $aname</h2>
				<div style=\"width:87%; height:87%; background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px;\">
            	<hr style=\"margin-left: 20px; margin-right: 20px;\">";
				
				$query = 
				"select *
				 from animal
				 where animal_id = $animalid;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">Training Topic<hr></th>    
						<th class=\"thtitle\">Training Date<hr></th>    
                        <th class=\"thtitle\">Remove<hr></th> 
                        <th class=\"thtitle\">New Date<hr></th> 
						<th class=\"thtitle\">Update<hr></th>  
				</tr>";
                $arr = array();
				if($result = $mysqli->query($query)){
                    $i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<tr>
								<th>". $row['training_topic'] ."<hr></th>    
								<th>". $row['training_date'] ."<hr></th>    
                                <th><form method=\"post\"><input type=\"submit\" name=\"".$i."req\" class=\"btn3\" value=\"Remove\"></form><hr></th> 
                                <th><input name=\"newd\" class=\"right\" type=\"text\" name=\"newdate\" placeholder=\"Enter new date\" required=\"required\"><hr></th> 
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."tra\" class=\"btn3\" value=\"Update\"></form><hr></th>  
							</tr>";
                            $arr[$i] = $row['animal_id'];
                            $i = $i + 1;
					}
				} else {
					echo "Error while retrieving animal table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";
                /*
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						$place = strval($k) . "req";
						$place2 = strval($k) . "tra";
						if(isset($_POST[$place])){ //Request Treatment
                            //Request Treatment----------------------------------------------------------
							break;
						}
						if(isset($_POST[$place2])){//Training Information
                            $_SESSION['animalid'] = $arr[$k];
							header("location: traininginfo.php");
							break;
						}
					}
				}*/
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