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
						header("location: indexin.php");
					} else {
						echo '<script type="text/JavaScript">
						window.alert("Please use employee login!");
						window.location = "index.php";
						</script>';
					}
			}else{
				echo '<script type="text/JavaScript">
				window.alert("Query2 operation failed!");
				window.location = "index.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
					window.alert("Incorrect email or password please try again!");
					window.location = "index.php";
					</script>';
		}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "index.php";
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
		window.location = "index.php";
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
				window.location = "index.php";
				</script>';
			}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "index.php";
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
				header("location: indexin.php");
			} else if($result2->num_rows == 1){ //vet
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "vet";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: indexin.php");
			} else if($result3->num_rows == 1){ //coordinator
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "coor";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: indexin.php");
			} else if($result4->num_rows == 1){ //guide
				$_SESSION['login_user'] = $userid;
				$_SESSION['type'] = "guide";
				$namequery = "select name from user where user_id ='". $userid ."'"; 
				$namearr = mysqli_query($mysqli, $namequery);
				$fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
				$name = $fetcharr['name'];
				$_SESSION['name'] = $name;
				header("location: indexin.php");
			} else {
				echo '<script type="text/JavaScript">
				window.alert("Please use visitor login!");
				window.location = "index.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
					window.alert("Incorrect email or password please try again!");
					window.location = "index.php";
			</script>';
		}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "index.php";
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

if(isset($_POST['comm'])){
	header("location: allcomments.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> KasaloZoo </title>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">
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

			<section class="cases-links">
				<div class="wrapper">
					<!-- Orta kısım -->
					<div class="main">
						<div class="main-image"> 
							<image src="image/lion.png" alt="Lion image" class="lion-image"></image>
						</div>
						<div class="second">
							<h2>Welcome to KasaloZoo</h2>
							<p>Everything about the zoo and the animals are available online for everyone now!</p>
							<form method="post">
								<button name="comm" class="corner-button">
									<span class="spann">Our Comments</span>
								</button>
							</form>
						</div>
					</div>

					<div class="owl-carousel owl-theme">
						<div class="comment">
							<h5>Walter White</h5>
							<div class="comment-div">
								<p class="comment-header">Best zoo in the area!</p>
								<p class="comment-text">I love KasaloZoo! it is a perfect place for both children and adults...
									<br> Perfect, visit animals closely...
								</p>
								<p class="comment-date">14 APRIL 2018</p>
							</div>
						</div>
						<div class="comment">
							<h5>David Waterfall</h5>
							<div class="comment-div">
								<p class="comment-header">OMG! Sweetest Animals are Here...</p>
								<p class="comment-text">There are thousands of animals! My children love this place enjoy and learn...
									<br> I always prefer this place...
								</p>
								<p class="comment-date">31 MAY 2019</p>
							</div>
						</div>
						<div class="comment">
							<h5>Darlene Alderson</h5>
							<div class="comment-div">
								<p class="comment-header">A Perfect Zoo!</p>
								<p class="comment-text">All animals that I want to see were here. The management of the zoo is also very delighted. 
									<br> I recommend this place.
								</p>
								<p class="comment-date">24 JUNE 2020</p>
							</div>
						</div>
					</div>
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
						<li><a href="index.php">Main Page</a></li>
						<li><a href="animals.php">Animals</a></li>
						<li><a href="events.php">Events</a></li>
						<li><a href="about.php">About Zoo</a></li>
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