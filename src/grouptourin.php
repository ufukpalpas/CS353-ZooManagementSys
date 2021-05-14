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
		
		$typequery = "select discount_type from visitor where user_id ='". $userid ."'"; 
        $typearr = mysqli_query($mysqli, $typequery);
        $fetcharr = mysqli_fetch_array($typearr, MYSQLI_ASSOC);
        $type = $fetcharr['discount_type'];
    }
} else {
    header("location: grouptour.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: grouptour.php");
    exit;
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
				if($usertype == "visitor"){
					echo "<script>
						function toggleuserPopup(){
							document.getElementById(\"user-popup\").classList.toggle(\"activate\");
						}
					</script>";
				} else if($usertype == "keeper") {
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
            <section class="mainsec">
                <h2>Group Tours</h2>
				<div class="picdiv">
					<img class="mainpic" src="image/zootour.jpg" alt="zoo tour foto">
				</div>
                <article>
                    <h3>Don't you want to join our guided group tours!</h3>
                    <p>
                        You can join our guided group tours. You can enjoy and learn by paying reasonable prices. <br>
                        Learn about their life... <br>
                    </p>
                </article>
				
				<h2>Current Group Tours</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; border-radius: 20px; ">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select g.event_id, e.start_date, g.capacity, g.participant_count, e.duration, e.user_id
				 from group_tour g, event e
                 where e.event_id = g.event_id and g.event_id not in (select event_id from pay where user_id = $userid);";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>    
						<th class=\"thtitle\">Duration<hr></th>    
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Capacity<hr></th>   
                        <th class=\"thtitle\">Participant Count<hr></th>   
						<th class=\"thtitle\">Amount<hr></th>   
						<th class=\"thtitle\">Join<hr></th>   
					</tr>";
				$arr = array();
				$arr2 = array();
				if($result = $mysqli->query($query)){
					$i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row['event_id'] ."<hr></th>    
								<th>". $row['duration'] ."<hr></th>    
								<th>". $row['start_date'] ."<hr></th>    
								<th>". $row['capacity'] ."<hr></th>    
								<th>". $row['participant_count'] ."<hr></th>";   
						if ($usertype == "visitor") {
							if($type == 1){
								echo "<th>$5<hr></th>";
							} else {
								echo "<th>$10<hr></th>";
							}
							echo "<th><form method=\"post\"><input type=\"submit\" name=\"".$i."\" class=\"btn3\" value=\"Join\"></form><hr></th>  
								</tr></form>";
						}
						$arr[$i] = $row['event_id'];
						$arr2[$i] = $row['user_id'];
						$i = $i + 1;
					}
				} else {
					echo "Error while retrieving group_tour table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						if(isset($_POST[$k])){
							$amount = 10;
							if($type == 1)
								$amount = 5;
                            $payquery = "insert into pay(coor_id, event_id, user_id, requested_amount) values(\"".$arr2[$k]."\", \"".$arr[$k]."\", \"$userid\",\"$amount\");";
                            $checkgtquery = "select participant_count, capacity from group_tour where event_id = ".$arr[$k];
							$upgtquery = "update group_tour set participant_count = participant_count + 1 where event_id = ".$arr[$k];
							$moneyquery = "update visitor set money = money - $amount where user_id = $userid;";
                            if($amount <= $money){
								if($cresult = $mysqli->query($checkgtquery)){
									$fetcharr = mysqli_fetch_array($cresult, MYSQLI_ASSOC);
									$gt = $fetcharr['participant_count'];
									$capa = $fetcharr['capacity'];
									if($gt == $capa){
										echo '<script type="text/JavaScript">
										window.alert("There is no enough Capacity!");
										window.location = "makedonation.php";
										</script>';
									} else {
										if($dresult = $mysqli->query($payquery)){
											if($ddresult = $mysqli->query($upgtquery)){
												if($mysqli->query($moneyquery)){
													echo '<script type="text/JavaScript">
													window.alert("Joined Successfully!");
													window.location = "grouptourin.php";
													</script>';
												} else{
													echo '<script type="text/JavaScript">
													window.alert("Money query failed!'.mysqli_error($mysqli).'");
													window.location = "grouptourin.php";
													</script>';
												}
											} else {
												echo '<script type="text/JavaScript">
												window.alert("Update Failed!'.mysqli_error($mysqli).'");
												window.location = "grouptourin.php";
												</script>';
											}
										} else {
											echo '<script type="text/JavaScript">
											window.alert("Pay Failed!'.mysqli_error($mysqli).'");
											window.location = "grouptourin.php";
											</script>';
										}
									}
								} else {
									echo '<script type="text/JavaScript">
									window.alert("participant_count check failed!");
									window.location = "grouptourin.php";
									</script>';
								}
                            } else {
                                echo '<script type="text/JavaScript">
                                window.alert("You do not have enough money!");
                                window.location = "grouptourin.php";
                                </script>';
                            }
                            break;
						}
					}
				}
				?>
				</div>

				<h2>Joined Group Tours</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$queryshow = 
				"select p.event_id, e.duration, e.start_date, g.capacity, g.participant_count, p.requested_amount
				 from pay p, group_tour g, event e
                 where p.user_id = $userid and e.event_id = p.event_id and e.event_id = g.event_id;";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>    
						<th class=\"thtitle\">Duration<hr></th>    
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Capacity<hr></th>   
                        <th class=\"thtitle\">Participant Count<hr></th>   
						<th class=\"thtitle\">Paid Amount<hr></th>  
					</tr>";
				if($result5 = $mysqli->query($queryshow)){
					while(($row2 = $result5->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row2['event_id'] ."<hr></th>    
								<th>". $row2['duration'] ."<hr></th>    
								<th>". $row2['start_date'] ."<hr></th>    
								<th>". $row2['capacity'] ."<hr></th>    
                                <th>". $row2['participant_count'] ."<hr></th>     
								<th>$". $row2['requested_amount'] ."<hr></th>   
							</tr></form>";
					}
				} else {
					echo "Error while retrieving pay table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";
				?>
				</div>
			</section>
		</main>
		<div class="wrapper"> 
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