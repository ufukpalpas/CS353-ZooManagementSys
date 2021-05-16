<?php
include("config.php"); 
session_start();

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
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
            border-top : 0.5px solid gray;
            border-bottom : 0.5px solid gray;  
            font: 18px helvetica;
            text-align: center;
            width : 100%;

        }
        .tabl{
            border-collapse: collapse;
            border-top : 0.5px solid gray; 
            border-bottom : 0.5px solid gray; 
            font: 13px helvetica;
            text-align: right;
            height : 60px;
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
    <!-- CODE HERE -->
        <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Comments</h1>
                <?php   
                echo "<form method='post' class ='date'><label for='start1'>From: </label>
                <input type='date' name='date'>
                <input type='submit' name='submitdate' value='LIST' class ='date_btn'></form>";
                if(isset($_POST['submitdate'])) { 
                    $date = $_POST['date'];
                    console_log($date);
                }

                $query = "SELECT * FROM comment ORDER BY date DESC";
                $result = $mysqli -> query($query); 
                
                if($_POST['date'] ?? null){
                    $query = "SELECT * FROM comment WHERE date > '".$date."' ORDER BY date DESC";
                    $result = $mysqli -> query($query);  
                }      
         
                echo "<table class='table' >"; 
               
                while ($row = $result -> fetch_row()) {
                    $user = "SELECT name FROM user WHERE user_id =".$row[6];
                    $user = $mysqli -> query($user); 
                    $user = $user->fetch_row();
                    echo "<tr>";
                    echo  "<td  style='width: 50%;   border-top : 0.5px solid gray; 
                    border-bottom : 0.5px solid gray; text-align: left;'>".$row[1]."</td>";
                    echo  "<td class='tabl'><i>at ".$row[2]."</i></td>";  
                    if($row[3] == 1){
                        echo  "<td class='tabl'><i>anon</i></td>"; 
                    }
                    else{
                        echo  "<td class='tabl'><i>written by ".$user[0]."</i></td>"; 
                    }                              
                    
                    echo  "<td class='tabl'> <i>for Group Tour ".$row[7]."</i></td>"; 

                    $starcount = $row[4];
                    $star ="";
                    $count = 0;
                    
                    while($starcount > 0){
                        $star = $star."★";
                        $starcount--;
                        $count++;
                    }
                    while($count < 5){
                        $count++;
                        $star = $star."☆";
                    }
                    echo  "<td class='tabl' style='color: #3db7cc'>".$star."</td>"; 
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
