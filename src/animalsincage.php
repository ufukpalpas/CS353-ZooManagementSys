<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && ($_SESSION['type'] == "keeper")) 
{
    $cageid = $_SESSION['cageid'];
    $userid = $_SESSION['login_user']; 
	$name = $_SESSION['name'];
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

            <div class="treatment-popup" id="treatment-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleTRPopup()">×</div>
					<p class="h2pop">Request Treatment</p>
					<form method = "post">
						<input name="findings" class="tff" type="text" placeholder="Findings" required="required">
						<select name="vets" id="vets" class="tf3" >
						<?php
							$queryvet = "select v.user_id, u.name from veterinarian v, user u where u.user_id = v.user_id;";
							if($result = $mysqli->query($queryvet)){
								$first = 0;
								while(($row = $result->fetch_assoc())!= null)  {
									$first++;
									if($first == 1)
										echo "<option selected=\"selected\" value=\"".$row['user_id']."\">".$row['name']." (".$row['user_id'].")</option>";   
									else
										echo "<option value=\"".$row['user_id']."\">".$row['name']." (".$row['user_id'].")</option>";   
								}
							} else {
								echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
							}
						?>
                		</select>				
						<button name="treatbtn" class="btn">Request Treatment</button>
					</form>
                </div>
            </div>

            <script>
				function toggleuserPopup(){
                    document.getElementById("keep-popup").classList.toggle("activate");
                }

				function toggleTRPopup(){
                    document.getElementById("treatment-popup").classList.toggle("activate");
                }
            </script>
            <section class="mainsec">
                <?php
                echo "<h2>Animals in Cage #$cageid</h2>
				<div style=\"width:95%; height:95%; background-color:white; margin-left: 3.5%; margin-top: 20px; border-radius: 20px; margin-bottom: 20%;\">
            	<hr style=\"margin-left: 20px; margin-right: 20px;\">";
				
				$query = 
				"select *
				 from animal
				 where cage_id = $cageid;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">Animal ID<hr></th>    
						<th class=\"thtitle\">Name<hr></th>    
						<th class=\"thtitle\">Species<hr></th>    
						<th class=\"thtitle\">Birth Date<hr></th>   
						<th class=\"thtitle\">Gender<hr></th>  
						<th class=\"thtitle\">Weight<hr></th>  
						<th class=\"thtitle\">Height<hr></th>   
                        <th class=\"thtitle\">Origin<hr></th> 
                        <th class=\"thtitle\">Endangered<hr></th> 
                        <th class=\"thtitle\">Habitat<hr></th> 
                        <th class=\"thtitle\">Diet<hr></th> 
                        <th class=\"thtitle\">Status<hr></th> 
                        <th class=\"thtitle\">Last Health Check<hr></th> 
                        <th class=\"thtitle\">Treatment<hr></th> 
						<th class=\"thtitle\">Training<hr></th>  
				</tr>";
                $arr = array();
				if($result = $mysqli->query($query)){
                    $i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<tr>
								<th>". $row['animal_id'] ."<hr></th>    
								<th>". $row['name'] ."<hr></th>    
								<th>". $row['species'] ."<hr></th>    
								<th>". $row['date_of_birth'] ."<hr></th>    
								<th>". $row['gender'] ."<hr></th>    
								<th>". $row['weight'] ."<hr></th> 
                                <th>". $row['height'] ."<hr></th> 
                                <th>". $row['origin'] ."<hr></th> 
                                <th>". $row['isEndangered'] ."<hr></th> 
                                <th>". $row['habitat'] ."<hr></th> 
                                <th>". $row['diet'] ."<hr></th> 
                                <th>". $row['status'] ."<hr></th> 
                                <th>". $row['last_health_check'] ."<hr></th> 
                                <th><form method=\"post\"><input type=\"submit\" name=\"".$i."req\" class=\"btn3\" value=\"Request Treatment\"></form><hr></th>  
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."tra\" class=\"btn3\" value=\"Training Information\"></form><hr></th>  
							</tr>";
                            $arr[$i] = $row['animal_id'];
                            $i = $i + 1;
					}
				} else {
					echo "Error while retrieving animal table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";
                
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						$place = strval($k) . "req";
						$place2 = strval($k) . "tra";
						if(isset($_POST[$place])){ //Request Treatment
							$_SESSION['animalid'] = $arr[$k];
							echo '<script type="text/JavaScript">
								toggleTRPopup();
								</script>';
							break;
						}
						if(isset($_POST[$place2])){//Training Information
                            $_SESSION['animalid'] = $arr[$k];
							echo '<script type="text/javascript">location.href = "traininginfo.php";</script>';
							break;
						}
					}
				}

				if(isset($_POST['treatbtn'])){
					$animalid= $_SESSION['animalid'];
					$findings = $_POST['findings'];
					$vets = $_POST['vets'];
					$querytr = "insert into treatment_request(vet_id, findings) values($vets, \"$findings\");";
					if($resulttr = $mysqli->query($querytr)) {
						$last_id = $mysqli->insert_id;
						$queryreq = "insert into request(animal_id, request_id, user_id) values($animalid, $last_id, $userid);";
						if($resultreq = $mysqli->query($queryreq)) {
							echo '<script type="text/JavaScript">
							window.alert("Treatment request has sent to the veterinerian!");
							 </script>';
						} else {
							echo '<script type="text/JavaScript">
							window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
							window.location = "mycagesin.php";
							 </script>';
						}
					}else{
						echo '<script type="text/JavaScript">
						window.alert("Query operation failed!'.mysqli_error($mysqli).'");
						window.location = "mycagesin.php";
						 </script>';
					}
				}
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