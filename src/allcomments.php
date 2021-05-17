<?php
include("config.php"); 
session_start();

function vislogin($mysqli){
	$emaillgn = $_POST['emaillgn'];
    $password = $_POST['password'];
	$query = " select user_id, email, password from user where email=\"$emaillgn\" and password=\"$password\"";
    if(($result = $mysqli->query($query))) {
		if($result->num_rows == 1) {
			$fetcharr0 = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$userid = $fetcharr0['user_id'];
			$query1 = " select user_id from visitor where user_id=\"$userid\"";
			if(($result1 = $mysqli->query($query1))){
					if($result1->num_rows == 1){
						$_SESSION['login_user'] = $userid;
						$_SESSION['type'] = "visitor";
		
						$namequery = "select name from user where user_id ='". $userid ."'"; 
						$namearr = mysqli_query($mysqli, $namequery);
						$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
						$name = $fetcharr['name'];
						$_SESSION['name'] = $name;
		
						$moneyquery = "select money from visitor where user_id ='". $userid ."'"; 
						$moneyarr = mysqli_query($mysqli, $moneyquery);
						$fetchmarr = mysqli_fetch_array($moneyarr, MYSQLI_ASSOC);
						$money = $fetchmarr['money'];
						$_SESSION['money'] = $money;
						header("location: allcommentsin.php");
					} else {
						echo '<script type="text/JavaScript">
						window.alert("Please use employee login!");
						window.location = "allcomments.php";
						</script>';
					}
			}else{
				echo '<script type="text/JavaScript">
				window.alert("Query2 operation failed!");
				window.location = "allcomments.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
					window.alert("Incorrect email or password please try again!");
					window.location = "allcomments.php";
					</script>';
		}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "allcomments.php";
            </script>';
    }
}
function register($mysqli){
	$fullname = $_POST['fullname'];
	$email = $_POST["email"];
	$phoneNum = $_POST["phoneno"];
	$date = $_POST["dateofbirth"];
    $password = $_POST['password'];
	$confpassword = $_POST['confpass'];
	$gender = $_POST['gender'];
	$account_type = $_POST['type'];

	if($confpassword != $password){
		echo '<script type="text/JavaScript">
		window.alert("Your Passwords do not Match!");
		window.location = "allcomments.php";
		</script>';
		return;
	}
	$query = "insert into user(name, phone_number, email, gender, date_of_birth, password)"
		."values(\"" .$fullname. "\", \"" .$phoneNum. "\", \"" .$email. "\", \"" .$gender. "\", \"" . $date ."\", \"" .$password. "\");";
		if($result = $mysqli->query($query)) {
			$account = 0;
			if($account_type == "Student")
				$account = 1;
			$last_id = $mysqli->insert_id;
			$query2 = "insert into visitor(user_id, discount_type) values(\"".$last_id."\", \"".$account."\");";
			if($result3 = $mysqli->query($query2)){
				echo '<script type="text/JavaScript">
				window.alert("Register Successful!");
				window.location = "allcomments.php";
				</script>';
			}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "allcomments.php";
            </script>';
    }
}
function emplogin($mysqli){
	$emailemp = $_POST['emailemp'];
    $password = $_POST['emppass'];
	$query = " select user_id, email, password from user where email=\"$emailemp\" and password=\"$password\"";
    if($result = $mysqli->query($query)) {
		if($result->num_rows == 1){
			$fetcharr0 = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$userid = $fetcharr0['user_id'];

			$query1 = " select user_id from keeper where user_id=\"$userid\"";
			$query2 = " select user_id from veterinarian where user_id=\"$userid\"";
			$query3 = " select user_id from coordinator where user_id=\"$userid\"";
			$query4 = " select user_id from guide where user_id=\"$userid\"";

			$result1 = $result = $mysqli->query($query1);
			$result2 = $result = $mysqli->query($query2);
			$result3 = $result = $mysqli->query($query3);
			$result4 = $result = $mysqli->query($query4);

			if($result1->num_rows == 1){ //keeper
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "keeper";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: allcommentsin.php");
			} else if($result2->num_rows == 1){ //vet
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "vet";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: allcommentsin.php");
			} else if($result3->num_rows == 1){ //coordinator
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "coor";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: allcommentsin.php");
			} else if($result4->num_rows == 1){ //guide
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "guide";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: allcommentsin.php");
			} else {
				echo '<script type="text/JavaScript">
				window.alert("Please use visitor login!");
				window.location = "allcomments.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
					window.alert("Incorrect email or password please try again!");
					window.location = "allcomments.php";
			</script>';
		}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "allcomments.php";
            </script>';
    }
}
if(isset($_POST['vislogin'])){
    vislogin($mysqli);
}
if(isset($_POST['register'])){
	register($mysqli);
}
if(isset($_POST['emploginn'])){
	emplogin($mysqli);
}

?>

<!DOCTYPE html>
<html>
	<head>
        <style type="text/css">
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
            border-bottom: 3px solid #d5d5d5;
            margin-top: 5%;
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
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
        <header>
			<a href="index.php" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="index.php">Main Page</a></li>
					<li><a href="animals.php">Animals</a></li>
					<li><a href="events.php">Events</a></li>
					<li><a href="about.php">About Zoo</a></li>
					<li><a href="#" onclick="togglePopup()">Sign In</a></li>
					<li><a href="#" onclick="toggleRegPopup()">Sign Up</a></li>
				</ul>
			</nav>
		</header>
<main>
    <div class="login-popup" id="login-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="togglePopup()">×</div>
					<p class="poptitle">Sign In</p>
					<div class=tabs>
						<div class="buttons">
							<button onclick="show(0)">Visitor</button>
							<button onclick="show(1)">Employee</button>
						</div>
						<div class="loginPanel">
							<form method = "post">
								<input id="emaillgn" class="id" type="id" name="emaillgn" placeholder="Email" required="required">
								<input id="password" class="pass" type="password" name="password" placeholder="Password" required="required">
								<button class="btn" name="vislogin">Sign In</button>
							</form>
						</div>
						<div class="loginPanel">
							<form method = "post">
								<input name="emailemp" class="id" type="id" name="emailemp" placeholder="Email (employee)" required="required">
								<input name="emppass" class="pass" type="password" name="pass" placeholder="Password" required="required">
								<button class="btn" name="emploginn">Sign In</button>
							</form>
						</div>
					</div>
                </div>
            </div>

            <div class="register-popup" id="register-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleRegPopup()">×</div>
					<p class="poptitle2">Sign Up</p>
					<form method = "post">
						<input name="fullname" class="left" type="text" name="name" placeholder="Full Name" required="required">
						<input name="email" class="right" type="text" name="email" placeholder="Email" required="required">
						<input name="phoneno" class="left" type="text" name="phone" placeholder="Phone Number" required="required">
						<input name="dateofbirth" class="right" type="date" name="date" placeholder="Date of Birth" required="required">
						<input name="password" class="left" type="password" name="pass" placeholder="Password" required="required">
						<input name="confpass" class="right" type="password" name="pass" placeholder="Confirm Password" required="required">
						<p class="gender">Gender: </p>
						<input name="gender" class="radio" type="radio" id="male" value="Male" checked>
						<label class="lbl" for="male">Male</label>
						<input class="radio" type="radio" name="gender" id="female" value="Female">
						<label class="lbl" for="female">Female</label>
						
						<p class="gender">Account Type: </p>
						<input name="type" class="radio" type="radio" id="adult" value="Adult" checked>
						<label class="lbl" for="adult">Adult</label>
						<input class="radio" type="radio" name="type" id="student" value="Student">
						<label class="lbl" for="student">Student</label>
						<button name="register" class="btn">Sign Up</button>
					</form>
                </div>
            </div>

			<script>
				var tabbtns = document.querySelectorAll(".tabs .buttons button");
				var tabPan = document.querySelectorAll(".tabs .loginPanel");
				function show(index) {
					tabbtns.forEach(function(node){
						node.style.backgroundColor="";
						node.style.color="";
					});
					tabbtns[index].style.backgroundColor="#404040";
					tabbtns[index].style.color="white";
					tabPan.forEach(function(node){
						node.style.display="none";
					});
					tabPan[index].style.display="block";
					tabPan[index].style.backgroudColor="#404040";
				}
				show(0);
			</script>
			<script>
                function togglePopup(){
                    document.getElementById("login-popup").classList.toggle("activate");
                }
				function toggleRegPopup(){
                    document.getElementById("register-popup").classList.toggle("activate");
                }
				if ( window.history.replaceState ) {
        			window.history.replaceState( null, null, window.location.href );
    			}
            </script>

    <!-- CODE HERE -->
        <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:30%;">
                <h2 class="title"> Comments</h2>
                <?php   
                echo "<form method='post' class ='date'><label for='start1'>From: </label>
                <input type='date' name='date'>
                <input type='submit' name='submitdate' value='LIST' class ='date_btn'></form>";
                if(isset($_POST['submitdate'])) { 
                    $date = $_POST['date'];
                }
				
                $query = "SELECT * FROM comment ORDER BY date DESC";
                $result = $mysqli -> query($query); 
                
                if(isset($_POST['date'])){
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
