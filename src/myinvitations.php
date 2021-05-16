<?php
include("config.php"); 
session_start();
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
if($_SESSION['login_user'] && ($_SESSION['type'] == "vet")) 
{
    $userid = $_SESSION['login_user'];
    $name = $_SESSION['name'];
} else {
    header("location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" ){
    $event_id = array_keys($_POST)[0];
    console_log($event_id);
    $updatestatus = "UPDATE invitation SET isAccepted = 1 WHERE event_id =".$event_id. " AND vet_id =". $userid ; //burayı değiş
    if($mysqli -> query($updatestatus)){
        echo "<script type='text/javascript'>
			alert('Joined');
			</script>";
    }
}  

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: index.php");
    exit;
}
/*Vet*/
if(isset($_POST['treatbtn']))
	header("location: treatment.php"); //-----------------------------------------
if(isset($_POST['invbtn']))
	header("location: myinvitations.php"); //-----------------------------------------
if(isset($_POST['treatreq']))
	header("location: treatmentrequest.php");	
if(isset($_POST['viewpemp'])) // common for all emp
	header("location: myprofileemployee.php");
if(isset($_POST['editpemp'])) // common for all emp
	header("location: editprofileemployee.php");
?>

<!DOCTYPE html>
<html>
	<head>
        <style type="text/css">
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
        }
        .table{
            border-collapse: collapse;
            border : 0.5px solid gray; 
            font: 18px helvetica;
            text-align: center;
            width : 100%;

        }
        .tabl{
            border-collapse: collapse;
            border-top : 0.5px solid gray; 
            border-bottom : 0.5px solid gray; 
            font: 18px helvetica;
            text-align: center;
            width : 15%;
            height : 30px;
        } 
        .accept{
            height : 100%;
            background-color: #3db7cc;
            border-radius: 6px;
        }
        .date{
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .date_btn{
            background-color: #3db7cc;
            border-radius: 6px;
        }
        </style>
        <title> KasaloZoo </title>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="loginstyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">
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
                        <button name="viewpemp" class="btn">View Profile</button>
                        <button name="editpemp" class="btn">Edit Profile</button>
                        <button name="treatbtn" class="btn">Treatments</button>
						<button name="treatreq" class="btn">Treatment Requests</button>
						<button name="invbtn" class="btn">Invitations</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>
            <script>
				function toggleuserPopup(){
                    document.getElementById("user-popup").classList.toggle("activate");
                }
            </script>
			<!-- CODE HERE -->
            <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Your Invitations</h1>
                <?php   
                echo "<form method='post' class ='date'><label for='start1'>From: </label>
                <input type='date' name='date'>
                <input type='submit' name='submitdate' value='LIST' class ='date_btn'></form>";
                if(isset($_POST['submitdate'])) { 
                    $date = $_POST['date'];
                    console_log($date);
                }

                $query = "SELECT vet_id, coor_id, event_id, isAccepted FROM invitation NATURAL JOIN event WHERE vet_id=".$userid. " ORDER BY start_date DESC";
                $result = $mysqli -> query($query);
                if($_POST['date'] ?? null){
                    $query = "SELECT vet_id, coor_id, event_id, isAccepted FROM invitation NATURAL JOIN event WHERE vet_id=".$userid." AND start_date > '".$date."' ORDER BY start_date DESC";
                    $result = $mysqli -> query($query);
                }
         
                echo "<table class='table' >"; 
                echo "<tr>";  
                echo  "<td class='tabl' style='color: #3db7cc;'><b>No</b></td>";  
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Invited by</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Topic</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Place</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Duration</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Status</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    $coordinator = "SELECT name FROM user WHERE user_id ='" .$row[1]. "'";
                    $coordinator = $mysqli -> query($coordinator);
                    $event = "SELECT place, topic, start_date, duration FROM educational_program natural join event WHERE event_id =".$row[2];
                    $event = $mysqli -> query($event);
                    $event = $event->fetch_row();

                    echo  "<td class='tabl'>".$row[2]."</td>";
                    echo  "<td class='tabl'>".$coordinator->fetch_row()[0]."</td>";  
                    echo  "<td class='tabl'>".$event[1]."</td>";                               
                    echo  "<td class='tabl'>".$event[0]."</td>";
                    echo  "<td class='tabl'>".$event[2]."</td>";
                    echo  "<td class='tabl'>".$event[3]."</td>";
                    if($row[3] == 1){
                        echo  "<td class='tabl'>Accepted</td>";
                    }
                    else{
                        echo  "<td class='tabl'>
                            <form method='post' name='accept'>
                            <input type='submit' name='".$row[2]."' class='accept' value='ACCEPT' onclick='return confirm(\"Are you sure?\")'> 
                            </form>
                            </td>";
                    }    
                    echo "</tr>";
                }
                echo "</table>";
                ?>
                </div>


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
