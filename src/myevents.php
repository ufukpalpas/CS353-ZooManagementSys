<?php
include("config.php");
session_start();
$_SESSION['date_selected'] = 2020-01-01;
if($_SESSION['login_user'] && ($_SESSION['type'] == "visitor"))
{
    $userid = $_SESSION['login_user']; 
    $name = $_SESSION['name'];
	$usertype = $_SESSION['type'];
    if($_SESSION['type'] == "visitor"){
		$moneyquery = "select money from visitor where user_id ='". $userid ."'"; 
        $moneyarr = mysqli_query($mysqli, $moneyquery);
        $fetchmarr = mysqli_fetch_array($moneyarr, MYSQLI_ASSOC);
        $money = $fetchmarr['money'];
        $_SESSION['money'] = $money;
    }
    
} else {
    header("location: index.php");
}

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

if(isset($_POST['search'])){
    $_SESSION['date_selected'] = $_POST['start'];
}

if (!isset($_SESSION['name'])){
    $_SESSION['date_selected'] = "2020-01-01";
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}
/*VISITOR*/
if(isset($_POST['viewp']))
	header("location: myprofilevisitor.php");
if(isset($_POST['editp']))
	header("location: editprofilevisitor.php");
if(isset($_POST['depositm']))
	header("location: depositmoney.php");
if(isset($_POST['mdonation']))
	header("location: makedonation.php");
if(isset($_POST['crcomp']))
	header("location: complaintform.php");
if(isset($_POST['myevents']))
	header("location: myevents.php");
if(isset($_POST['jgroup']))
	header("location: grouptourin.php");
if(isset($_POST['janimal']))
	header("location: birthdayin.php");
if(isset($_POST['mcomment']))
	header("location: comment.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title> KasaloZoo </title>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="style2.css">
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
						<button name="viewp" class="btn">View Profile</a></button>
                        <button name="editp" class="btn">Edit Profile</button>
                        <button name="depositm" class="btn">Deposit Money</button>
                        <button name="mdonation" class="btn">Make Donation</button>
                        <button name="crcomp" class="btn">Create Complaint Form</button>
						<button name="mcomment" class="btn">Make Comment</button>
                        <button name="myevents" class="btn">My Events</button>
                        <button name="jgroup" class="btn">Join a Group Tour</button>
                        <button name="janimal" class="btn">Join a Endangered Birthday</button>
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
                <h2>My Events</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:25%">
            	<!--<hr style="margin-left: 20px; margin-right: 20px;">-->
				<?php

                $selected_date = $_SESSION['date_selected'];
                echo "<form method=\"post\"><label for=\"start1\">Start Date Until:</label>
                <input type=\"date\" id=\"start\" name=\"start\" value=\"".$selected_date."\"><input type=\"submit\" name=\"search\"value=\"Search\"></form><br></br>";
                $query = 
				"select *
				 from pay p, event e
				 where p.user_id = '$userid' AND p.event_id = e.event_id";
                 $query1 = 
                 "select *
                  from attending a, event e
                  where a.user_id = '$userid' AND a.event_id = e.event_id";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<br><th class=\"thtitle\">Event ID<hr></th>    
						<th class=\"thtitle\">Event Date<hr></th>    
						<th class=\"thtitle\">Duration<hr></th>
                        <th class=\"thtitle\">Event Type<hr></th>      
					</tr>";
				$arr = array();
				if($result = $mysqli->query($query)){
                    if($result2 = $mysqli->query($query1)){
                        while(($row = $result->fetch_assoc())!= null)  {
                            if($selected_date < $row['start_date']){
                            
                                echo "<tr>
                                    <th>". $row['event_id'] ."<hr></th>    
                                    <th>". $row['start_date'] ."<hr></th>    
                                    <th>". $row['duration'] ."<hr></th>
                                    <th> Group Tour <hr></th>";
                            }
                            while(($row2 = $result2->fetch_assoc())!= null) {
                                if($selected_date < $row2['start_date']){
                                echo "<tr>
                                    <th>". $row2['event_id'] ."<hr></th>    
                                    <th>". $row2['start_date'] ."<hr></th>    
                                    <th>". $row2['duration'] ."<hr></th>
                                    <th> Animal Birthday <hr></th>";  
                                }
                            }   
                                  
                        }
                    } else {
                        echo "Error while retrieving keeper table. Error: " . mysqli_error($mysqli);
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