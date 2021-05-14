<?php
include("config.php"); 
session_start();

if($_SESSION['login_user'] && ($_SESSION['type'] == "keeper")) 
{
    $userid = $_SESSION['login_user']; 
	$name = $_SESSION['name'];
} else {
    header("location: index.php");
}

if(isset($_POST['increase_form'])){
	$foodid = array_keys($_POST)[0];
	$added_amount = $_POST[$foodid];
	if(is_numeric($added_amount)){
		$increasefood = "UPDATE food SET stock = stock + ".$added_amount." WHERE barcode=".$foodid; 
		if($mysqli -> query($increasefood)){
			echo "<script type='text/javascript'>
			alert('Added');
			</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>
			alert('Please enter a number!!');
			</script>";
	}
}

if(isset($_POST['food_form'])){
	$barcode = $_POST['barcode'];
	$type = $_POST['type'];
	$name = $_POST['name'];
	$stock = $_POST['stock'];
	$calories = $_POST['calories'];
	
	if(is_numeric($barcode) && is_numeric($stock) && is_numeric($calories) ){
		$add_food = "INSERT INTO food VALUES(".$barcode.",'".$type."',".$calories.",".$stock.",'".$name."')";
		if($mysqli -> query($add_food)){
			echo "<script type='text/javascript'>
			alert('Added');
			</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>
			alert('Please enter a number!!');
			</script>";
	}

	if(isset($_POST['logout'])){
		session_unset(); 
		session_destroy(); 
		header("location: index.php");
		exit;
	}
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
			margin-bottom: 10%;

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
		.add_btn{
			width : 10%;
			height: 600px;
			background-color: #3db7cc;
			border-radius: 5px;
			margin-top: 10px;
		}
		.increase_txt{
			font: 18px helvetica;
			width : 30%;
			height: 40px;
			margin-top: 10px;
			border-radius: 5px;
		}
		.food_btn{
            margin-left: 20%;
            margin-top: 5%;
            width : 50%;
			height: 40px;
            background-color : #3db7cc;
            cursor: pointer;
            font: 18px helvetica;
            border-radius: 20px;
        }
        .food_txt{ 
			width : 18%;
            height : 40px;
            border-radius: 5px;
            border : 1px solid gray;
        }
        .text_field{
            padding-top : 40px;
        }
		.special_button{  
            width : 430%;
            height : 40px;
            margin-top: -30px;
            background-color: transparent;
            border: transparent;
        }
        .special_button:hover, .special_button:focus {
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
            <script>
				function toggleuserPopup(){
                    document.getElementById("keep-popup").classList.toggle("activate");
                }
            </script>
			<!-- CODE HERE -->
			<div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Foods</h1>
                <?php   
                $query = "SELECT * FROM food ";
                $result = $mysqli -> query($query);
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Barcode</b></td>";
				echo  "<td class='tabl' style='color: #3db7cc;' ><b>Name</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Type</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;' ><b>Calories</b></td>";
				echo  "<td class='tabl' style='color: #3db7cc;' ><b>Stock</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    
                    echo  "<td class='tabl'>".$row[0]."<input type='button'  class='special_button' onclick= 'popup(".$row[0].")'>
                            <div class='drop_text' id ='".$row[0]."'>
							<form method='post' name='increase_form'>
								<input type='text' class='increase_txt' placeholder= 'amount' name='".$row[0]."'>
								<input type='submit' name='increase_form' class='add_btn' value='ADD' style='height: 30px;' id='".$row[0]."'> 
							</form>
                            </div></td>";

                    echo "<script type='text/javascript'>
							function popup(row) {
								document.getElementById(row).classList.toggle('show');
							}
                        
                     </script>";
                            
                    echo  "<td class='tabl'>".$row[1]."</td>";
					echo  "<td class='tabl'>".$row[4]."</td>";
					echo  "<td class='tabl'>".$row[2]."</td>";
					echo  "<td class='tabl'>".$row[3]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
				echo "<divclass='text_field'>";
				echo "<h1 class='title' style=' font-size: 30px;'> Add New Food</h1>";
				echo  "<form method='post' name='food_form'>
						<div style='padding-top: 20px;'>
							<input type='text' class='food_txt' name='barcode' placeholder='Barcode' required>
							<input type='text' class='food_txt' name='name' placeholder='Name' required>
							<input type='text' class='food_txt' name='type' placeholder='Type' required>
							<input type='text' class='food_txt' name='calories' placeholder='Calories' required>
							<input type='text' class='food_txt' name='stock' placeholder='Stock' required>
							
							<input type='submit' name='food_form' class='food_btn' value='SUBMIT' > 
						</div>       
					</form>";
				echo "</div>";
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