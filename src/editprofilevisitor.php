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
    $name = $_POST['Full_Name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $date_of_birth = $_POST['date'];
    $gender = $_POST['check'];
    $discount_type = $_POST['check1'];
    $new_password = $_POST['password'];
    if(empty($new_password)){
    $query = "update user set name ='" . $name . "',email ='" . $email . "',phone_number ='" . $phone_number . "',date_of_birth ='" . $date_of_birth . "', gender ='" . $gender . "' where user_id=" . "'" . $userid . "'";
    }
    else{
        $query = "update user set name ='" . $name . "',email ='" . $email . "',phone_number ='" . $phone_number . "',date_of_birth ='" . $date_of_birth . "', gender ='" . $gender . "', password = '" . $new_password . "' where user_id=" . "'" . $userid . "'";
    }
    if($result = $mysqli->query($query)) {
        $query2 = "update visitor set discount_type =" . $discount_type . " where user_id=" . "'" . $userid . "'";
        if($result = $mysqli->query($query2)) {
            echo '<script type="text/JavaScript">
            window.alert("Visitor updated successfully!");
            window.location = "editprofilevisitor.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "editprofilevisitor.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "editprofilevisitor.php";
         </script>';
    }
    header("location: myprofilevisitor.php");
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
    <link rel="stylesheet" href="ege.css">

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
                $sql = "select u.name, u.email, u.phone_number, u.date_of_birth, u.gender, v.discount_type FROM user u, visitor v where u.USER_ID ='" . $userid . "' and v.user_id = u.user_id";
                if($result = $mysqli->query($sql)){
                    while(($row = $result->fetch_assoc())!= null){
                    echo "<form method = \"post\"> <input class= \"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"Full_Name\" value=\"" . $row['name'] . "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"email\" value=\"" . $row['email']. "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"phone\" value=\"" . $row['phone_number']. "\">";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"date\" value=\"" . $row['date_of_birth']. "\">";
                    echo "<p><input id= \"password\"class=\"leftover\" style=\"width: 40%\" type=\"password\"
                            name=\"password\" value=\"\" placeholder= \" New Password\" onkeyup = 'checkpass();'>";
                    echo "<input id= \"confirm_password\"class=\"leftover\" style=\"width: 40%\" type=\"password\"
                            name=\"confirm_password\" value=\"\" placeholder= \" Confirm Password\" onkeyup = 'checkpass();'>";
                    
                            $gender_type = "Male";
                    if(strcasecmp($row['gender'], $gender_type)){
                        echo "<p><input class=\"radioMargin\" type= \"radio\" name=\"check\" id=\"Male\" value=\"Male\">";
                        echo "<label for=\"male\"> Male</label>";
                        echo "<input class=\"radio\" type= \"radio\" name=\"check\" id=\"Female\" value=\"Female\" checked>";
                        echo "<label for=\"female\" class=\"leftCheck\"> Female</label>";
                    }
                    else{
                        echo "<p><input class=\"radioMargin\" type= \"radio\" name=\"check\" id=\"Male\" value=\"Male\" checked>";
                        echo "<label for=\"male\"> Male</label>";
                        echo "<input class=\"radio\" type= \"radio\" name=\"check\" id=\"Female\" value=\"Female\">";
                        echo "<label for=\"female\" class=\"leftCheck\"> Female</label>";
                    }

                    if($row['discount_type']){
                        echo "<input class=\"radioMinusMargin\" type= \"radio\" name=\"check1\" id=\"Adult\" value=\"0\" >";
                        echo "<label for=\"adult\"> Adult</label>";
                        echo "<input class=\"radio\" type= \"radio\" name=\"check1\" id=\"Child\" value=\"1\" checked>";
                        echo "<label for=\"child\" class=\"rightCheck\"> Child</label></p>";
                    }
                    else{
                        echo "<input class=\"radioMinusMargin\" type= \"radio\" name=\"check1\" id=\"Adult\" value=\"0\" checked>";
                        echo "<label for=\"adult\"> Adult</label>";
                        echo "<input class=\"radio\" type= \"radio\" name=\"check1\" id=\"Child\" value=\"1\">";
                        echo "<label for=\"child\" class=\"rightCheck\"> Child</label></p>";
                    }
                    
                }

                echo "<p align=\"middle\">";
                echo "<button name=\"confirmBtn\" class=\"confirmBtn\" style=\"width: 25%\">  Confirm</button>";
                echo "<button name=\"cancelBtn\" class=\"cancelBtn\" style=\"width: 25%\">  Cancel</button>";
                echo "</form> </p>";

                }
        ?>

        <!--
            <input class="leftover" style= "width: 40%" type="text" name="name" placeholder="Full Name">
            <input class="rightover" style= "width: 40%" type="text" name="email" placeholder="Email">
            <input class="leftover" style= "width: 40%" type="text" name="phone" placeholder="Phone Number">
            <input class="rightover" style= "width: 40%" type="text" name="date" placeholder="Date of Birth (dd.mm.yy)">
            <p>
                <input class="radioMargin" type="radio" name="check" id="male" value="Male">
                <label for="male">Male</label>
                <input class="radio" type="radio" name="check" id="female" value="Female">
                <label for="female" class="leftCheck">Female</label>
                <input class="radioMinusMargin" type="radio" name="check" id="Adult" value="0">
                <label for="adult" >Adult</label>
                <input class="radio" type="radio" name="check" id="Child" value="1">
                <label for="child" class="rightCheck">Child</label>
            </p>
            
            <p align="middle">
            <form method = "post">
                <button name="confirmBtn" class="confirmBtn" style= "width: 25%">  Confirm</button>
                <button name="cancelBtn" class="cancelBtn" style= "width: 25% ">  Cancel</button>
            </form>
            
            </p>
            -->
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