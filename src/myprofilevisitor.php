<?php
include("config.php");
session_start();
if($_SESSION['login_user'])
{
    $userid = $_SESSION['login_user'];
    $namequery = "select name from user where user_id ='". $userid ."'"; 
                $namearr = mysqli_query($mysqli, $namequery);
                $fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
                $name = $fetcharr['name'];
                $_SESSION['name'] = $name;
    if($_SESSION['type'] == "visitor"){
        $money = $_SESSION['money'];
		$typequery = "select discount_type from visitor where user_id ='". $userid ."'";
        $typearr = mysqli_query($mysqli, $typequery);
        $fetcharr = mysqli_fetch_array($typearr, MYSQLI_ASSOC);
        $type = $fetcharr['discount_type'];
    }
} else {
    header("location: birthday.php");
}

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: birthday.php");
    exit;
}

if(isset($_POST['edit'])){
    header("location: editprofilevisitor.php");
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
?>

<!DOCTYPE html>
<html>
<head>
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
                <button class="btn">View Profile</button>
                <button class="btn">Edit Profile</button>
                <button class="btn">Deposit Money</button>
                <button class="btn">Make Donation</button>
                <button class="btn">Create Complaint Form</button>
                <button class="btn">My Events</button>
                <button class="btn">Join a Group Tour</button>
                <button class="btn">Join a Endangered Birthday</button>
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
    <section class="mainsec">
        <h2>My Profile</h2>
        <div style="text-align: center">
        <?php
                $sql = "select u.name, u.email, u.phone_number, u.date_of_birth, u.gender, v.discount_type FROM user u, visitor v where u.USER_ID ='" . $userid . "' and v.user_id = u.user_id";
                if($result = $mysqli->query($sql)){
                    while(($row = $result->fetch_assoc())!= null){
                    echo "<input class= \"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"name\" placeholder=\"" . $row['name'] . "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"email\" placeholder=\"" . $row['email']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"phone\" placeholder=\"" . $row['phone_number']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"date\" placeholder=\"" . $row['date_of_birth']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"gender\" placeholder=\"" . $row['gender']. "\"readonly>";
                    if($row['discount_type'])
                        $discount_string = "Child";
                    else
                        $discount_string = "Adult";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"discount\" placeholder=\"" . $discount_string. "\"readonly>";
                    }
                }
                else{
                    echo '<script type="text/JavaScript">
                    window.alert("Pay Failed!'.mysqli_error($mysqli).'");
                    window.location = "myprofilevisitor.php";
                    </script>';

                }
        ?>
            <p align="middle">
                <form method = "post">
                    <button name="edit" class="btn" style= "width: 25%">  Edit Profile</button>
                </form>
            </p>
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