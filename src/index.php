<?php
include("config.php");
session_start();
function vislogin($mysqli){
	$userid = $_POST['userid'];
    $password = $_POST['password'];
	echo $userid;
	$query = " select user_id, password from user where user_id=\"$userid\" and password=\"$password\"";
    if($result = $mysqli->query($query)) {
        if($result->num_rows == 1){
            $_SESSION['login_user'] = $userid;
            //header("location: grouptour.html");
        } else {
            echo '<script type="text/JavaScript">
                    window.alert("Incorrect username or ID please try again!");
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
	$contpassword = $_POST['confpass'];
	$gender = $_POST['gender'];
	if($gender != "Male")
		$gender = "Female";
	/*
	$query1 = "select last_insert_id() as user;";
	$query = "insert into user(user_id, name, phone_number, email, gender, date_of_birth, password)"
		."values(\"" .$userid. "\", \"" .$fullname. "\", \"" .$phoneNum. "\", \"" .$email. "\", \"" .$gender. "\", \"" . $date ."\", \"" .password. "\");";
    if($result = $mysqli->query($query)) {
        if($result->num_rows == 1){
            $_SESSION['login_user'] = $userid;
            header("location: grouptour.html");
        } else {
            echo '<script type="text/JavaScript">
                    window.alert("Incorrect username or ID please try again!");
                    window.location = "index.php";
            </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "index.php";
            </script>';
    }*/
}
if(isset($_POST['vislogin'])){
    vislogin($mysqli);
}
if(isset($_POST['register'])){
	echo '<script type="text/JavaScript">
	function changeBackground(){
		document.getElementById("fullname").style.color = red;
	}
	</script>';
	//register($mysqli);
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
			<a href="index.html" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="index.html">Main Page</a></li>
					<li><a href="animals.html">Animals</a></li>
					<li><a href="events.html">Events</a></li>
					<li><a href="about.html">About Zoo</a></li>
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
								<input id="userid" class="id" type="id" name="userid" placeholder="User ID" required="required">
								<input id="password" class="pass" type="password" name="password" placeholder="Password" required="required">
								<button class="btn" name="vislogin">Sign In</button>
							</form>
						</div>
						<div class="loginPanel">
							<form method = "post">
								<input name="empuserid" class="id" type="id" name="id" placeholder="User ID (employee)" required="required">
								<input name="emppassword" class="pass" type="password" name="pass" placeholder="Password" required="required">
								<button class="btn" name="emplogin">Sign In</button>
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
						<input name="dateofbirth" class="right" type="text" name="date" placeholder="Date of Birth (dd.mm.yy)" required="required">
						<input name="password" class="left" type="password" name="pass" placeholder="Password" required="required">
						<input name="confpass" class="right" type="password" name="pass" placeholder="Confirm Password" required="required">
						<p class="gender">Gender: </p>
						<input name="gender" class="radio" type="radio" name="check" id="male" value="Male" checked>
						<label for="male">Male</label>
						<input class="radio" type="radio" name="check" id="female" value="Female">
						<label for="female">Female</label>
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
						<div class="comment"><h4>2</h4>
						
						</div>
						<div class="comment"><h4>3</h4>
						
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