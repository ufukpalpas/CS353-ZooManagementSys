<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && ($_SESSION['type'] == "keeper")) 
{
    $cageid = $_SESSION['cageid'];
    $animalid = $_SESSION['animalid'];
    $userid = $_SESSION['login_user']; 
	$name = $_SESSION['name'];

    $anamequery = "select name from animal where animal_id ='". $animalid ."'"; 
    $anamearr = mysqli_query($mysqli, $anamequery);
    $fetchaarr = mysqli_fetch_array($anamearr, MYSQLI_ASSOC);
    $aname = $fetchaarr['name'];
} else {
    header("location: index.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: index.php");
    exit;
}

/*Keeper*/
if(isset($_POST['mycage']))
	header("location: mycagesin.php");
if(isset($_POST['foodm']))
	header("location: food.php");
if(isset($_POST['viewpemp'])) // common for all emp
	header("location: myprofileemployee.php");
if(isset($_POST['editpemp'])) // common for all emp
	header("location: editprofileemployee.php");
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
                    ?>
				</ul>
			</nav>
		</header>
		<main>
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
            <script>
				function toggleuserPopup(){
                    document.getElementById("keep-popup").classList.toggle("activate");
                }
            </script>
            <section class="mainsec">
                <?php
                echo "<h2>Cage #$cageid / Animal #$animalid / $aname</h2>
				<div style=\"width:87%; height:87%; background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px;\">
            	<hr style=\"margin-left: 20px; margin-right: 20px;\">";
				
				$query = 
				"select *
				 from training
				 where animal_id = $animalid and trainer_id = $userid;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\"> 
						<th class=\"thtitle\">Training Topic<hr></th>    
						<th class=\"thtitle\">Training Date<hr></th>    
                        <th class=\"thtitle\">Remove<hr></th> 
                        <th class=\"thtitle\">New Date<hr></th> 
						<th class=\"thtitle\">Update<hr></th>  
				</tr>";
                $arr = array();
				if($result = $mysqli->query($query)){
                    $i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<tr>
								<th>". $row['training_topic'] ."<hr></th>    
								<th>". $row['training_date'] ."<hr></th>    
                                <th><form method=\"post\"><input type=\"submit\" name=\"".$i."remove\" class=\"btn3\" value=\"Remove\"></form><hr></th> 
                                <form method = \"post\"><th><input name=\"".$i."newdate\" id=\"".$i."newdate\" class=\"right\" type=\"date\" placeholder=\"Enter New Date\" required=\"required\"><hr></th> 
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."update\" class=\"btn3\" value=\"Update\"></form><hr></th></form>  
							</tr>";
                            $arr[$i] = $row['training_id'];
                            $i = $i + 1;
					}
				} else {
					echo "Error while retrieving training table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";
                
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						$place = strval($k) . "remove";
						$place2 = strval($k) . "update";
						if(isset($_POST[$place])){ //remove
                            $queryrem = "delete from training where training_id =".$arr[$k]; 
							if($result2 = $mysqli->query($queryrem)){
								echo '<script type="text/JavaScript">
								window.alert("Removed Successfully!");
								window.location = "traininginfo.php";
								 </script>';
							} else {
								echo "Error while deleting from training table. Error: " . mysqli_error($mysqli);
							}
							break;
						}
						if(isset($_POST[$place2])){//update
							$str = $k."newdate";
							$newdate = $_POST[$str];
							$queryupdate = "update training set training_date = \"$newdate\" where training_id =".$arr[$k].";";
							if($result3 = $mysqli->query($queryupdate)){
								echo '<script type="text/JavaScript">
								window.alert("Training Updated Successfully!");
								window.location = "traininginfo.php";
								 </script>';
							} else {
								echo "Error while updating training table. Error: " . mysqli_error($mysqli);
							}
							break;
						}
					}
				}

				if(isset($_POST['addtra'])){
					$tt = $_POST['tt'];
					$tdate = $_POST['tdate'];
					$queryadd = "insert into training(animal_id, trainer_id, training_date, training_topic) values($animalid, $userid, \"$tdate\", \"$tt\");";
					if($result4 = $mysqli->query($queryadd)){
						echo '<script type="text/JavaScript">
						window.alert("Training Added Successfully!");
						window.location = "traininginfo.php";
						 </script>';
					} else {
						echo "Error while adding training. Error: " . mysqli_error($mysqli);
					}
				}
				?>
				</div>
					
				<div>
					<hr>
					<form method = "post" style="margin-top:5%">
						<input id="tt" class="tf" type="id" name="tt" placeholder="Training Topic" required="required">
						<input id="tdate" class="tf" onfocus="(this.type='date')" type="id" name="tdate" placeholder="Training Date" required="required">
						<button class="btntra" name="addtra">Add Training</button>
					</form>
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