<?php
include("config.php");
session_start();
if($_SESSION['login_user']) 
{
    $userid = $_SESSION['login_user']; 
    $name = $_SESSION['name'];
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
            <section class="mainsec">
                <h2>Animal Birthdays</h2>
				<div class="picdiv">
					<img class="mainpic" src="image/birthdaymain.jpg" alt="birthday foto">
				</div>
                <article>
                    <h3>Don't you want to see our new babies!</h3>
                    <p style=" margin-bottom:5% ">
                        You can join our endangered animal birthdays in return for small amounts of donations. <br>
                        You have a chance to see new born monkeys, crocodiles and more.... <br>
                        To join animal birthday you need to make donation to any conservation organization.<br>
						Site will automatically direct you to doantion page if you do not have any donation.<br>
						To join animal birthday there is 20$ lower limit for adults and 10$ lower limit for students<br>
						The donation need to be done in one go. Help them to see their babies.....
                    </p>
                </article>

				<div class="picdiv">
					<img class="mainpic" src="image/birthsoftuz.png" alt="birthday animal foto">
				</div>

				<h2>Coming Animal Birthdays</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; border-radius: 20px; ">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select e.event_id, e.start_date, e.duration, b.party_type, b.number_of_birthday_animals, e.user_id
				 from endangered_animal_birthday b, event e
                 where e.event_id = b.event_id and b.event_id not in (select a.event_id from attending a where a.user_id = $userid);";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>      
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Duration<hr></th>   
                        <th class=\"thtitle\">Party Type<hr></th>   
						<th class=\"thtitle\">Number of Birthday Animals<hr></th>   
						<th class=\"thtitle\">Join<hr></th>   
					</tr>";
				$arr = array();
				$arr2 = array();
				if($result = $mysqli->query($query)){
					$i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row['event_id'] ."<hr></th> 
								<th>". $row['start_date'] ."<hr></th>    
								<th>". $row['duration'] ."<hr></th>    
								<th>". $row['party_type'] ."<hr></th>    
								<th>". $row['number_of_birthday_animals'] ."<hr></th>    
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."\" class=\"btn3\" value=\"Join\"></form><hr></th>  
							</tr></form>";
						$arr[$i] = $row['event_id'];
						$arr2[$i] = $row['user_id'];
						$i = $i + 1;
					}
				} else {
					echo "Error while retrieving endangered_animal_birthday table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						if(isset($_POST[$k])){
							$checkdonquery = "select amount from donation where user_id = $userid";
							if($cresult = $mysqli->query($checkdonquery)){
								$check = 0;
								$amount = 20;
								if($type = 1)
									$amount = 10;
								while(($row2 = $cresult->fetch_assoc())!= null) {
									if($row2['amount'] >= $amount){
										$check = 1;
										break;
									}
								}
								$cresult = $mysqli->query($checkdonquery);
								if(($row2 = $cresult->fetch_assoc())== null){
									echo '<script type="text/JavaScript">
									window.alert("You do not have enough donation! \nAt least $10 for student $20 for aduls is needed in one go! \nYou are directed to donation page now!");
									window.location = "makedonation.php";
									</script>';
								}
								if($check == 1){
									$attendquery = "insert into attending(coor_id, event_id, user_id) values(\"".$arr2[$k]."\", \"".$arr[$k]."\", \"$userid\");";
									if($dresult = $mysqli->query($attendquery)){
										echo '<script type="text/JavaScript">
										window.alert("Joined Successfully!");
										window.location = "birthdayin.php";
										</script>';
									}else{
										echo '<script type="text/JavaScript">
										window.alert("error while insert into attending table");
										window.location = "birthdayin.php";
										</script>';
									}
								} else {
									echo '<script type="text/JavaScript">
									window.alert("You do not have enough donation! \nAt least $10 for student $20 for aduls is needed in one go! \nYou are directed to donation page now!");
									window.location = "makedonation.php";
									</script>';
								}
							} else {
								echo '<script type="text/JavaScript">
								window.alert("donation table check error");
								window.location = "makedonation.php";
								</script>';
							}
						}
						break;
					}
				}
				?>
				</div>

				<h2>Attended Annimal Birthdays</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$queryshow = 
				"select a.event_id, e.duration, e.start_date, en.party_type, en.number_of_birthday_animals
				 from attending a, endangered_animal_birthday en, event e
                 where a.user_id = $userid and e.event_id = a.event_id and e.event_id = en.event_id;";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>      
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Duration<hr></th>   
						<th class=\"thtitle\">Party Type<hr></th>   
						<th class=\"thtitle\">Number of Birthday Animals<hr></th>  
					</tr>";
				if($result5 = $mysqli->query($queryshow)){
					while(($row3 = $result5->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row3['event_id'] ."<hr></th>    
								<th>". $row3['start_date'] ."<hr></th>    
								<th>". $row3['duration'] ."<hr></th>    
								<th>". $row3['party_type'] ."<hr></th>    
                                <th>". $row3['number_of_birthday_animals'] ."<hr></th>     
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