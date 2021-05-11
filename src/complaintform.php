<?php
include("config.php"); 
session_start();

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

if(isset($_POST['complaint_form'])) {                
    $date = date('Y-m-d');
    $complaint = $_POST['complaint'];
    $header = $_POST['header'];
    console_log($complaint);
    $insert_query = "INSERT INTO complaint VALUES( default,\"".$complaint."\",\"". $date."\",\"".$header."\",1, 16, '')";
    if($mysqli -> query($insert_query)){
        echo "<script type='text/javascript'>
        alert('Added');
       </script>";
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
        <style type="text/css">
        .image{
            width : 20px;
            height : 20px;
        }
        .table{
            border-collapse: collapse;
            border : 0.5px solid black; 
            font: 18px helvetica;
            text-align: center;
            width : 100%;

        }
        .tabl{
            border-collapse: collapse;
            border-top : 0.5px solid black; 
            border-bottom : 0.5px solid black; 
            font: 18px helvetica;
            text-align: center;
            width : 25%;
            height : 30px;
        } 
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
        }
        .complaint_btn{
            margin-left: 80%;
            margin-top: -10%;
            width : 20%;
            height : 190px;
        }
        .complaint_txt{ 
            width : 40%;
            height : 40px;
        }
        .text_field{
            padding-top : 40px;
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
			<a href="index.html" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="index.html">Main Page</a></li>
					<li><a href="animals.html">Animals</a></li>
					<li><a href="events.html">Events</a></li>
					<li><a href="about.html">About Zoo</a></li>
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
                    <button class="btn">View Profile</button>
                    <button class="btn">Edit Profile</button>
                    <button class="btn">Deposit Money</button>
                    <button class="btn">Make Donation</button>
                    <button class="btn">Create Complaint Form</button>
                    <button class="btn">My Events</button>
                    <button class="btn">Join a Group Tour</button>
                    <button class="btn">Join a Endangered Birthday</button>
                    <button class="btn">Logout</button>
                </div>
            </div>
            <script>
				function toggleuserPopup(){
                    document.getElementById("user-popup").classList.toggle("activate");
                }
            </script>
			<!-- CODE HERE -->
        <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Fill a Complaint</h1>
                <?php   
                $userid = 16;
                $query = "SELECT * FROM complaint WHERE vis_id=".$userid;
                $result = $mysqli -> query($query);
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' ><b>No</b></td>";
                echo  "<td class='tabl' ><b>Date</b></td>";
                echo  "<td class='tabl' ><b>Complaint Status</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    echo  "<td class='tabl'>".$row[0]."</td>";
                    echo  "<td class='tabl'>".$row[2]."</td>";
                    if($row[6]){
                        echo  "<td class='tabl'>"."<img class='image' src='image/tick.png'"."</td>";
                    }
                    else{
                        echo  "<td class='tabl'>"."<img class='image' src='image/cross.png'"."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>"; 
                echo "<div class='text_field'>
                    <form method='post' name='complaint_form'>
                        <div>
                            <input type='text' class='complaint_txt' name='header' placeholder='Enter your complaint header here...'>
                            <div style='padding-top: 20px;'>
                            <input type='text' style='height:200px;'class='complaint_txt' name='complaint' placeholder='Enter your complaint here...'>
                            
                            <input style='height: 60px;' type='submit' name='complaint_form' class='complaint_btn' value='SUBMIT' > 
                            
                            </div>
                        </div>        
                    </form>
                </div>";
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
						<li><a href="index.html">Main Page</a></li>
						<li><a href="animals.html">Animals</a></li>
						<li><a href="events.html">Events</a></li>
						<li><a href="about.html">About Zoo</a></li>
					</ul>
				</div>
				<div class="partner-list">
					<h5>PARTNERS</h5>
					<p>Bilkent University</p>
				</div>
				</div>
			</footer>
		</div>
		<script src="owlcarousel/jquery.min.js"></script>
		<script src="owlcarousel/owl.carousel.js"></script>
		<script>
			$('.owl-carousel').owlCarousel({
				loop:true,
				margin:20,
				nav:false,
				responsive:{
					0:{
						items:1
					},
					600:{
						items:1
					},
					1000:{
						items:1
					}
				}
			})
		</script>
	</body>
</html>