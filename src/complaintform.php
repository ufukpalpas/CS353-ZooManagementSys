<?php
include("config.php"); 
session_start();
if($_SESSION['login_user']) 
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

if(isset($_POST['complaint_form'])) {                
    $date = date('Y-m-d');
    $complaint = $_POST['complaint'];
    $header = $_POST['header'];
    $insert_query = "INSERT INTO complaint VALUES( default,\"".$complaint."\",\"". $date."\",\"".$header."\",default, $userid, default)";
    if($mysqli -> query($insert_query)){
        echo "<script type='text/javascript'>
        alert('Added');
       </script>";
    }
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
            width : 25%;
            height : 30px;
        } 
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
        }
        .complaint_btn{
            margin-left: 80%;
            width : 20%;
            height : 190px;
            background-color : #3db7cc;
            cursor: pointer;
            font: 18px helvetica;
            border-radius: 20px;
        }
        .complaint_txt{ 
            width : 75%;
            height : 40px;
            border-radius: 5px;
            border : 1px solid gray;
        }
        .text_field{
            padding-top : 40px;
        }
        .special_button{  
            width : 200%;
            height : 40px;
            margin-top: -30px;
            background-color: transparent;
            border: transparent;
        }
        .special_button:hover, .special_button:focus {
            background-color: transparent;
        }
        .special_button2:hover, .special_button2:focus {
            background-color: transparent;
        }
        .drop_text {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            width: 50%;
            height: 10%;
            overflow: auto;
            box-shadow: none;
            z-index: 1;
            border: 1px solid gray;
            border-radius: 3px;
            text-align: left;
        }
        .drop_text a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;  
        }
        .show {display: block;}
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
                <h1 class="title"> Fill a Complaint</h1>
                <?php   
                $query = "SELECT * FROM complaint WHERE vis_id=".$userid;
                $result = $mysqli -> query($query);
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>No</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Complaint Status</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    $but = $row[0];
                    $complaint = "SELECT form_text, about, respond_text FROM complaint WHERE form_id=".$but;
                    $complaint = $mysqli -> query($complaint);
                    $complaint = mysqli_fetch_row($complaint);
                    $comp = $complaint[0];
                    $about = $complaint[1];
                    
                    echo  "<td class='tabl'>".$row[0]."<input type='button'  class='special_button' onclick= 'popup(".$row[0].")'>
                            <div class='drop_text' id ='".$row[0]."'><b>About:</b> ".$about."</br><b>Complaint:</b> ".$comp ."
                            </div></td>";

                    echo "<script type='text/javascript'>
                            function popup(row) {
                                document.getElementById(row).classList.toggle('show');
                            }
                            window.onclick = function(event) {
                            if (!event.target.matches('.special_button')) {
                                var dropdowns = document.getElementsByClassName('drop_text');
                                var i;
                                for (i = 0; i < dropdowns.length; i++) {
                                var openDropdown = dropdowns[i];
                                if (openDropdown.classList.contains('show')) {
                                    openDropdown.classList.remove('show');
                                }
                                }
                            }
                        }     
                     </script>";
                            
                    echo  "<td class='tabl'>".$row[2]."</td>";
                    if($row[6]){
                        echo  "<td class='tabl' style='padding-top:10px;'>"."<img class='image' style='height : 25px; width : 27px;' src='image/tick.png'>";
                        echo  "<input type='button'  class='special_button' onclick= 'popup(".$row[0].$row[4].$row[5].")'
                                style='width : 100%;
                                height : 40px;
                                margin-top: -30px;
                                background-color: transparent;
                                border: transparent;'>
                                <div class='drop_text' style='width: 25%;' id ='".$row[0].$row[4].$row[5]."'>". $complaint[2]."
                                </div></td>";
       
                    }
                    else{
                        echo  "<td class='tabl' style='padding-top:10px;'>"."<img class='image' src='image/cross.png'"."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>"; 
                echo "<div class='text_field'>
                    <form method='post' name='complaint_form'>
                        <div>
                            <input type='text' class='complaint_txt' name='header' placeholder='Enter your complaint header here...' required>
                            <div style='padding-top: 20px;'>
                            <input type='text' style='height:200px;'class='complaint_txt' name='complaint' placeholder='Enter your complaint here...' required>
                            
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
