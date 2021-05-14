<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && ($_SESSION['type'] != "visitor"))
{
    $userid = $_SESSION['login_user'];
	$name = $_SESSION['name'];
    $usertype = $_SESSION['type'];
} else {
    header("location: index.php");
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: index.php");
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

			<div class="user-popup" id="guide-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">My Tours</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>

			<div class="user-popup" id="vet-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <form method = "post">
                        <button class="btn">View Profile</button>
                        <button class="btn">Edit Profile</button>
                        <button class="btn">Treatments</button>
						<button class="btn">Invitations</button>
                        <button name="logout" class="btn">Logout</button>
                    </form>
                </div>
            </div>
            <?php
                if($usertype == "keeper") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"keep-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "vet") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"vet-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "coor") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"coor-popup\").classList.toggle(\"activate\");
					}
					</script>";
				} else if($usertype == "guide") {
					echo "<script>
					function toggleuserPopup(){
						document.getElementById(\"guide-popup\").classList.toggle(\"activate\");
					}
					</script>";
				}
			?>
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
                echo "<button name=\"confirmBtn\" class=\"confirmBtn\" style=\"width: 25%; margin-bottom:20%;\">  Confirm</button>";
                echo "<button name=\"cancelBtn\" class=\"cancelBtn\" style=\"width: 25%; margin-bottom:20%;\">  Cancel</button>";
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