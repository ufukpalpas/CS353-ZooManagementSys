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

if(isset($_POST['deposit'])){
    $damount = $_POST['amount'];
    $depositquery = "update visitor set money = money + $damount where user_id = $userid;";
    if($dresult = $mysqli->query($depositquery)){
        echo '<script type="text/JavaScript">
        window.alert("Money Deposited Successfully!");
        window.location = "depositmoney.php";
        </script>';
    }
    else {
        echo '<script type="text/JavaScript">
        window.alert("Deposit Failed!'.mysqli_error($mysqli).'");
        window.location = "depositmoney.php";
        </script>';
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
            <section class="mainsec">
                <h2>Deposit Money</h2>
                <h3>Credit or Debit Card</h3>
                <form method = "post">
				<input class="ini" name="cardno"  type="text" name="cardno" placeholder="Card Number" required="required">
                <input class="ini" name="nameoncard"  type="text" name="nameoncard" placeholder="Name On Card" required="required">
                <input class="ini" name="expdate"  type="text" name="expdate" placeholder="Expiration Date (mm/yy)" required="required">
                <input class="ini" name="cvc"  type="text" name="expdate" placeholder="CVC Code" required="required">
                <input class="ini" name="amount"  type="text" name="amount" placeholder="Deposit Amount" required="required">
                <button name="deposit" class="btndepo">Deposit Now</button>
                </form>
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