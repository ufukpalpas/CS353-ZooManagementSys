<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && ($_SESSION['type'] == "coor"))
{
    $userid = $_SESSION['login_user'];
    $name = $_SESSION['name'];
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

if(isset($_POST['createBtn'])){
    
    $name = $_POST['Full_Name'];
    $ssn = $_POST['ssn'];
    $leave = $_POST['leave'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $date_of_birth = $_POST['date'];
    $shift = $_POST['shift'];
    $salary = $_POST['salary'];
    $e_type = $_POST['e_type'];
    $speciality = $_POST['speciality'];
    $gender = $_POST['check'];
    $address = $_POST['apt'] . ' ' . $_POST['streetnum'] . ' ' . $_POST['streetnam'] . ' ' . $_POST['city'] . ' ' . $_POST['zip'];
    $query = "insert into user values ('default', '$name', '$phone_number', '$email', '$gender', '$date_of_birth', '123456')";
    if($result = $mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        console_log("1");
        $query2 = "insert into employee values ('$last_id', '$ssn', '$address', '$salary', '0', '$leave', '$shift', default, '$userid')";
        if($result = $mysqli->query($query2)) {
            console_log("2");
            if(strcasecmp($e_type, "coordinator") == 0){
                $query3 = "insert into coordinator values ('$last_id', 'Coordinator', 'North')";
            }
            elseif(strcasecmp($e_type, "keeper") == 0){
                $query3 = "insert into keeper values ('$last_id', '$speciality')";
            }
            elseif(strcasecmp($e_type, "veterinarian") == 0){
                $query3 = "insert into veterinerian values ('$last_id', '$specialty', default)";
            }
            elseif(strcasecmp($e_type, "guide") == 0){
                $query3 = "insert into guide values ('$last_id', '$speciality', 30)";
            }
            console_log("3");
            if($result = $mysqli->query($query3)){
                echo '<script type="text/JavaScript">
                window.alert("Employee added successfully!");
                window.location = "createemployee.php";
                </script>';
            } else {
                echo '<script type="text/JavaScript">
                window.alert("Query3 operation failed!'.mysqli_error($mysqli).'");
                window.location = "createemployee.php";
                 </script>';
            }
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "createemployee.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "createemployee.php";
         </script>';
    }
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
            <script>
				function toggleuserPopup(){
                    document.getElementById("coor-popup").classList.toggle("activate");
                }
            </script>
    <!-- CODE HERE -->
    <section class="mainsec">
        <h2>Register New Employee</h2>

        <?php
        
                    echo "<form method= \"post\"><p1>Select Employee Type</p1>
                            <select name=\"e_type\" style=\" margin-left: 3%\" id=\"e_type\">
                            <option value=\"Coordinator\">Coordinator</option>
                            <option value=\"Keeper\">Keeper</option>
                            <option value=\"Veterinarian\">Veterinarian</option>
                            <option value=\"Guide\">Guide</option>
                            </select>
                            <div style=\"text-align: center\">";
                    echo "<input class= \"leftover\" style=\"width: 24%\" type=\"text\"
                            name=\"Full_Name\" value=\"\" placeholder=\"Full Name\" required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"ssn\" value=\"\" placeholder=\"SSN\"required>";
                    echo "<input class=\"leftover\" style=\"width: 24%\" type=\"text\"
                            name=\"leave\" value=\"\" placeholder=\"Leave Days\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"phone\" value=\"\" placeholder=\"Phone Number\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"date\" value=\"\" placeholder=\"Date of Birth\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"shift\" value=\"\" placeholder=\"Shift Hours\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"email\" value=\"\" placeholder=\"Email Address\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"salary\" value=\"\" placeholder=\"Salary\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"speciality\" value=\"\" placeholder=\"Speciality\"required>";
                    
                    echo "<p style=\"margin-right: 52%\"><br></br><input class=\"radioMargin\" type= \"radio\" name=\"check\" id=\"Male\" value=\"Male\" required>";
                    echo "<label for=\"male\"> Male</label>";
                    echo "<input class=\"radio\" type= \"radio\" name=\"check\" id=\"Female\" value=\"Female\" required>";
                    echo "<label for=\"female\" class=\"leftCheck\"> Female</label></p>";
                    
                    echo "<p2 style=\"margin-right: 84%\">Address</p2>";

                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"streetnum\" value=\"\" placeholder=\"Street Numbers\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"apt\" value=\"\" placeholder=\"Apartment Numbers\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"zip\" value=\"\" placeholder=\"Zip Code\"required>";
                    echo "<div style=\"text-align: left\"><input class=\"rightover\" style=\"width: 24%; margin-left:210px; \" type=\"text\"
                            name=\"streetnam\" value=\"\" placeholder=\"Street Name\"required>";
                    echo "<input class=\"rightover\" style=\"width: 24%\" type=\"text\"
                            name=\"city\" value=\"\" placeholder=\"City\"required></div>";

                
                    
                
                echo "<p align=\"middle\">";
                echo "<button name=\"createBtn\" class=\"confirmBtn\" style=\"width: 25%; margin-bottom:5%;\">  Create</button>";
                echo "</form> </p>";

                
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