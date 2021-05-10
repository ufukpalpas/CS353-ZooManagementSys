<?php
include("config.php");
session_start();
function vislogin($mysqli){
	$userid = $_POST['userid'];
    $password = $_POST['password'];
	echo $userid;
	$query = " select user_id, password from user where user_id=\"$userid\" and password=\"$password\"";
	$query1 = " select user_id from visitor where user_id=\"$userid\"";
    if(($result = $mysqli->query($query)) && ($result1 = $mysqli->query($query1))) {
		if($result->num_rows == 1){
			if($result1->num_rows == 1){
				$_SESSION['login_user'] = $userid;
				//header("location: grouptour.html");
			} else {
				echo '<script type="text/JavaScript">
				window.alert("Please use employee sign in!");
				window.location = "birthday.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
					window.alert("Incorrect username or ID please try again!");
					window.location = "birthday.php";
			</script>';
		}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "birthday.php";
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
		window.location = "birthday.php";
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
				window.location = "birthday.php";
				</script>';
			}
    } else {
        echo '<script type="text/JavaScript">
                window.alert("Query operation failed!");
                window.location = "birthday.php";
            </script>';
    }
}
if(isset($_POST['vislogin'])){
    vislogin($mysqli);
}
if(isset($_POST['register'])){
	register($mysqli);
}
?>

<!DOCTYPE html>
<html>
	<head>
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
            <section class="mainsec">
                <h2>Animal Birthdays</h2>
				<div class="picdiv">
					<img class="mainpic" src="image/birthdaymain.jpg" alt="birthday foto">
				</div>
                <article>
                    <h3>Don't you want to see our new babies!</h3>
                    <p>
                        You can join our endangered animal birthdays in return for small amounts of donations. <br>
                        You have a chance to see new born monkeys, crocodiles and more.... <br>
                        For mor information Sign Up or Sign In....
                    </p>
                </article>
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
	</body>
</html>