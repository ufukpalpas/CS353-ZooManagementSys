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

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: birthday.php");
    exit;
}

if(isset($_POST['confirmBtn'])){
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $bank_details = $_POST['bank_details'];
    $address = $_POST['address'];
    $new_password = $_POST['password'];
    if(empty($new_password)){
        $query = "update user set email ='" . $email . "',phone_number ='" . $phone_number . "' where user_id=" . "'" . $userid . "'";
    }
    else{
        $query = "update user set email ='" . $email . "',phone_number ='" . $phone_number . "', password='" . $new_password ."' where user_id=" . "'" . $userid . "'";
    }
    if($result = $mysqli->query($query)) {
        $query2 = "update employee set bank_details ='" . $bank_details . "', address ='" . $address . "' where user_id=" . "'" . $userid . "'";
        if($result = $mysqli->query($query2)) {
            echo '<script type="text/JavaScript">
            window.alert("Visitor updated successfully!");
            window.location = "editprofileemployee.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "editprofileemployee.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "editprofileemployee.php";
         </script>';
    }
    header("location: myprofileemployee.php");
}

if(isset($_POST['cancelBtn'])){
    header("location: myprofilevisitor.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title> KasaloZoo </title>
    <meta charset = "UTF-8">
    <link rel="stylesheet" href="style2.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <button class="btn">View Profile</button>
            <button class="btn">Edit Profile</button>
            <button class="btn">Deposit Money</button>
            <button class="btn">Make Donation</button>
            <button class="btn">Create Complaint Form</button>
            <button class="btn">My Events</button>
            <button class="btn">Join a Group Tour</button>
            <button class="btn">Join a Endangered Birthday</button>
            <button class="btn">Logout</button>
        </div>
    </div>
    <script>
				function toggleuserPopup(){
                    document.getElementById("user-popup").classList.toggle("activate");
                }
            </script>
    <!-- CODE HERE -->
    <section class="mainsec">
        <h2>Edit Profile</h2>
        <div style="text-align: center">

        <script type = "text/javascript" src="confirmpassword.js"></script>
        <?php
                $sql = "select u.email, u.phone_number, e.address, e.bank_details FROM user u, employee e where u.USER_ID ='" . $userid . "' and e.user_id = u.user_id";
                if($result = $mysqli->query($sql)){
                    while(($row = $result->fetch_assoc())!= null){
                    echo "<form method = \"post\"> <input class= \"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"email\" value=\"" . $row['email'] . "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"phone\" value=\"" . $row['phone_number']. "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"address\" value=\"" . $row['address']. "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"bank_details\" value=\"" . $row['bank_details']. "\">";
                    echo "<p><input id= \"password\"class=\"leftover\" style=\"width: 40%\" type=\"password\"
                            name=\"password\" value=\"\" placeholder= \" New Password\" onkeyup = 'checkpass();'>";
                    echo "<input id= \"confirm_password\"class=\"leftover\" style=\"width: 40%\" type=\"password\"
                            name=\"confirm_password\" value=\"\" placeholder= \" Confirm Password\" onkeyup = 'checkpass();'>";

                    }
                }

                echo "<p align=\"middle\">";
                echo "<button name=\"confirmBtn\" class=\"confirmBtn\" style=\"width: 25%\">  Confirm</button>";
                echo "<button name=\"cancelBtn\" class=\"cancelBtn\" style=\"width: 25%\">  Cancel</button>";
                echo "</form> </p>";
                    
        ?>    
        
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