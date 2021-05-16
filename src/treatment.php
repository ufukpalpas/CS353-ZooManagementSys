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

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: index.php");
    exit;
}  
/*Vet*/
if(isset($_POST['treatbtn']))
	header("location: treatment.php"); 
if(isset($_POST['invbtn']))
	header("location: myinvitations.php"); 
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
        .image{
            width : 20px;
            height : 20px;
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
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
        }
        .treat_txt{
            margin-top: 10px;
            width: 25%;
            height: 50px;
        }
        .treat_btn{
            height: 50px;
            width: 10%;
            background-color:#3db7cc;
            border-radius: 5px;
            margin-top: 12px;
        }
        .special_button{
            width : 75%;
            height : 40px;
            margin-top: -10px;
            margin-left: -68%;
            background-color: transparent;
            position: absolute;
            border: transparent;
        }
        .special_button:hover, .special_button:focus {
            background-color: transparent;
        }
        .drop_text {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 75%;
            height: 10%;
            margin-left: -60%;
            margin-top: 0.5%;
            overflow: auto;
            box-shadow: none;
            z-index: 1;
            border: 1px solid gray;
            border-radius: 3px;
            text-align: center;
        }
        .drop_text a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;  
        }
        .show {display: block;}
        </style>
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
     <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:30%;">
                <h1 class="title">Your Treatments</h1>
                <?php   
                $query = "SELECT request_id, request_date, findings, animal_id  FROM treatment_request NATURAL JOIN request WHERE vet_id=".$userid." AND isAccepted = 1";
                $result = $mysqli -> query($query);
           
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Id</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Animal</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Findings</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Status</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    console_log( $row[0]);
                    $ingive = "SELECT * FROM give WHERE request_id= ".$row[0];
                    $ingive = $mysqli -> query($ingive);
                    $ingive = $ingive -> fetch_row();
                    console_log("give:");
                    console_log( $ingive);
                 

                    echo  "<td class='tabl'>" .$row[0] ;
                    echo  "<td class='tabl'>" .$row[1] ;
                    echo  "<td class='tabl'>" .$row[3] ;
                    echo  "<td class='tabl'>" .$row[2] ;
                    if($ingive ?? null){
                        echo  "<td class='tabl' style='padding-top:10px;'><img class='image' style='height : 25px; width : 27px;' src='image/tick.png'>";
                    }
                    else{
                        echo  "<td class='tabl' style='padding-top:10px;'><img class='image' style='height : 25px; width : 27px;' src='image/cross.png'>";
                        echo  "<input type='button'  class='special_button' onclick= 'popup(".$row[0].")'>
                                <div class='drop_text' style='width: 25%;' id ='".$row[0]."'>
                                <form method='post' name='treat_form'>
                                    <input type='text' class='treat_txt' name='medicine' placeholder='Medicine' required>
                                    <input type='text' class='treat_txt' name='diet' placeholder='Recommended diet' required>
                                    <input type='text' class='treat_txt' name='duration' placeholder='Duration' required>
                                    <input type='submit' name='treat_form' class='treat_btn' value='DONE' >
                                </form>
                                </div></td>";
                                if(isset($_POST['treat_form'])) { 
                                    $medicine = $_POST['medicine'];
                                    $diet = $_POST['diet'];
                                    $duration = $_POST['duration'];

                                    $addtreatment = "INSERT INTO treatment VALUES(default, '$medicine', '$diet', '$duration')";
                                
                                    $addtogive = "INSERT INTO give VALUES()";
                                    if($mysqli -> query($addtreatment)){
                                        $last_id = $mysqli->insert_id;
                                        $addtogive = "INSERT INTO give VALUES($row[3], $last_id, $row[0])";
                                        if($mysqli -> query($addtogive)){
                                            echo "<script type='text/javascript'>
                                                alert('Added');
                                                </script>";
                                            echo("<meta http-equiv='refresh' content='0'>");    
                                        }   
                                    }
                                }
                    }

                    echo" <script type='text/javascript'>
                        function popup(row) {
                            document.getElementById(row).classList.toggle('show');
                        }
   
                     </script>";                              

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
