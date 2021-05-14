<?php
include("config.php"); 
session_start();
if($_SESSION['login_user'] && ($_SESSION['type'] == "coor")) 
{
    $userid = $_SESSION['login_user']; 
	$name = $_SESSION['name'];
} else {
    header("location: index.php");
}

if(isset($_POST['complaint_response'])) { 
    $formid = $_POST['option'];
    $restext = $_POST['response'];

    $insert_query = "UPDATE complaint SET respond_text ='".$restext."', coor_id = $userid WHERE form_id =".$formid; //bu 1 değişcek
    if($mysqli -> query($insert_query)){
        echo "<script type='text/javascript'>
        alert('Added');
       </script>";
    }
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
    <style type="text/css">
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
            margin-top: -20%;
            width : 20%;
            height : 190px;
            background-color : #3db7cc;
            cursor: pointer;
            font: 18px helvetica;
            border-radius: 20px;
        }
        .response_txt{ 
            width : 75%;
            height : 40px;
            border-radius: 5px;
            border : 1px solid gray;
        }
        .text_field{
            padding-top : 40px;
        }
        .select_event{
            border-radius: 5px;
        }
        .special_button{  
            width : 300%;
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
            width: 75%;
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
            <script>
				function toggleuserPopup(){
                    document.getElementById("coor-popup").classList.toggle("activate");
                }
            </script>
			<!-- CODE HERE -->
            <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Answer a Complaint</h1>
                <?php  
                $query = "SELECT * FROM complaint WHERE coor_id IS NULL";
                $result = $mysqli -> query($query);
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>No</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>About</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    $but = $row[0];
                    $complaint = "SELECT form_text, about FROM complaint WHERE form_id=".$but;
                    $complaint = $mysqli -> query($complaint);
                    $complaint = mysqli_fetch_row($complaint);
                    $comp = $complaint[0];
                    $about = $complaint[1];
                    
                    echo  "<td class='tabl'>".$row[0]."<input type='button'  class='special_button' onclick= 'popup(".$row[0].")'>
                            <div class='drop_text' id ='".$row[0]."'><b>Complaint:</b> ".$comp ."
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
                    
                        echo  "<td class='tabl' style='padding-top:10px;'>".$about;
                        echo  "</td>";
                    
                    echo "</tr>";
                }
                echo "</table>"; 

                //SECOND TABLE
                echo "<h1 class='title'> Your Answers</h1>";
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>No</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>About</b></td>";
                echo "</tr>";
                $answers = "SELECT * FROM complaint WHERE coor_id=$userid";
                $answers = $mysqli -> query($answers);
                
                while ($row = $answers -> fetch_row()) {
                    echo "<tr>";
                    $comp_a = $row[1];
                    $about_a = $row[3];
                    
                    echo  "<td class='tabl'>".$row[0]."<input type='button'  class='special_button' onclick= 'popup(".$row[0].")'>
                            <div class='drop_text' id ='".$row[0]."'><b>Complaint:</b> ".$comp_a."</br><b>Answer: </b>".$row[6]." 
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
                    
                        echo  "<td class='tabl' style='padding-top:10px;'>".$about_a;
                        echo  "</td>";
                    
                    echo "</tr>";
                }
                echo "</table>"; 

                echo "<div class='text_field'>
                    <form method='post' name='complaint_response'>
                        <div>
                            <select class='select_event' name='option' required>
                            <option value='' disabled selected>Choose Complaint</option>";
                            $result = $mysqli -> query($query);
                            while ($row = $result -> fetch_row()) {
                                echo "<option value=".$row[0].">Complaint No: ".$row[0]."</option>";
                            }
                echo "      </select>
                            <div style='padding-top: 20px;'>
                            <input type='text' style='height:200px;'class='response_txt' name='response' placeholder='Enter your response here...' required>
                            <input style='height: 60px;' type='submit' name='complaint_response' class='complaint_btn' value='SUBMIT' > 
                            
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