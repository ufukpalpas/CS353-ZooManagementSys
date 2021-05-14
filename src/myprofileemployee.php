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

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

if(isset($_POST['edit'])){
    header("location: editprofileemployee.php");
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

/* Coordinator */
if(isset($_POST['viewpemp'])) // common for all emp
	header("location: myprofileemployee.php");
if(isset($_POST['editpemp'])) // common for all emp
	header("location: editprofileemployee.php");
if(isset($_POST['cagem']))
	header("location: cagemanagement.php");
if(isset($_POST['cevent']))
	header("location: createevents.php");
if(isset($_POST['rescomp']))
	header("location: answercomplaint.php");
if(isset($_POST['regnew']))
	header("location: createemployee.php");

/*Keeper*/
if(isset($_POST['mycage']))
	header("location: mycagesin.php");
if(isset($_POST['foodm']))
	header("location: food.php");

/*Guide*/
if(isset($_POST['mytours']))
	header("location: guidepage.php");

/*Vet*/
if(isset($_POST['treatbtn']))
	header("location: index.php"); //-----------------------------------------
if(isset($_POST['invbtn']))
	header("location: index.php"); //-----------------------------------------
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
                        <button name="viewpemp" class="btn">View Profile</button>
                        <button name="editpemp" class="btn">Edit Profile</button>
                        <button name="cagem" class="btn">Cage Management</button>
                        <button name="cevent" class="btn">Create Event</button>
                        <button name="rescomp" class="btn">Respond to Complaint Forms</button>
                        <button name="regnew" class="btn">Register a New Employee</button>
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
                        <button name="viewpemp" class="btn">View Profile</button>
                        <button name="editpemp" class="btn">Edit Profile</button>
                        <button name="mycage" class="btn">My Cages</button>
						<button name="foodm" class="btn">Food Stock Management</button>
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
                        <button name="viewpemp" class="btn">View Profile</button>
                        <button name="editpemp" class="btn">Edit Profile</button>
                        <button name="mytours" class="btn">My Tours</button>
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
                        <button name="viewpemp" class="btn">View Profile</button>
                        <button name="editpemp" class="btn">Edit Profile</button>
                        <button name="treatbtn" class="btn">Treatments</button>
						<button name="invbtn" class="btn">Invitations</button>
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
        <h2>My Profile</h2>
        <div style="text-align: center">

        <?php
                $sql = "select u.name, u.email, u.phone_number, u.date_of_birth, u.gender, e.ssn, e.address, e.salary, e.years_worked, e.shift_hours, e.bank_details, e.leave_days FROM user u, employee e where u.USER_ID ='" . $userid . "' and e.user_id = u.user_id";
                if($result = $mysqli->query($sql)){
                    while(($row = $result->fetch_assoc())!= null){
                    echo "<input class= \"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"name\" placeholder=\"" . $row['name'] . "\"readonly>";
                    echo "<input class=\"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"ssn\" placeholder=\"" . $row['ssn']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"email\" placeholder=\"" . $row['email']. "\"readonly>";
                    echo "<input class=\"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"phone\" placeholder=\"" . $row['phone_number']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"date\" placeholder=\"" . $row['date_of_birth']. "\"readonly>";
                    echo "<input class= \"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"gender\" placeholder=\"" . $row['gender'] . "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"address\" placeholder=\"" . $row['address']. "\"readonly>";
                    echo "<input class=\"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"bank_details\" placeholder=\"" . $row['bank_details']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"salary\" placeholder=\"" . $row['salary']. "\"readonly>";
                    echo "<input class=\"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"years_worked\" placeholder=\"" . $row['years_worked']. "\"readonly>";
                    echo "<input class=\"leftover\" style=\"width: 40%\" type=\"text\"
                            name=\"shift_hours\" placeholder=\"" . $row['shift_hours']. "\"readonly>";
                    echo "<input class=\"rightover\" style=\"width: 40%\" type=\"text\"
                            name=\"leave_days\" placeholder=\"" . $row['leave_days']. "\"readonly>";
                    }
                }
                else{
                    echo '<script type="text/JavaScript">
                    window.alert("Pay Failed!'.mysqli_error($mysqli).'");
                    window.location = "myprofilevisitor.php";
                    </script>';

                }
        ?>
            <!--
            <input class="leftover" style= "width: 40%" type="text" name="name" placeholder="Full Name" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="ssn" placeholder="Social Security Number" readonly>
            <input class="leftover" style= "width: 40%" type="text" name="email" placeholder="Email" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="phone" placeholder="Phone Number" readonly>
            <input class="leftover" style= "width: 40%" type="text" name="date" placeholder="Date of Birth (dd.mm.yy)" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="gender" placeholder="Male/Female" readonly>
            <input class="leftover" style= "width: 40%" type="text" name="address" placeholder="Address" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="bank_details" placeholder="Bank Details" readonly>
            <input class="leftover" style= "width: 40%" type="text" name="salary" placeholder="Salary" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="years_worked" placeholder="Years Worked" readonly>
            <input class="leftover" style= "width: 40%" type="text" name="shift_hours" placeholder="Shift Hours" readonly>
            <input class="rightover" style= "width: 40%" type="text" name="leave_days" placeholder="Leave Days" readonly>

            -->
            <p align="middle">
            <form method = "post">
                <button name = "edit" class="btn" style= "width: 25%; margin-bottom:20%;">  Edit Profile</button>
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