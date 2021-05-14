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
                <h2>Make Donation to Conservation Organizations</h2>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; ">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select c.event_id, e.start_date, c.name, c.fundings, e.user_id
				 from conservation_organization c, event e 
                 where e.event_id = c.event_id;";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>    
						<th class=\"thtitle\">Conservational Organization Name<hr></th>    
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Fundings<hr></th>   
                        <th class=\"thtitle\">Amount<hr></th>   
						<th class=\"thtitle\">Donate<hr></th>   
					</tr>";
				$arr = array();
                $arr2 = array();
				if($result = $mysqli->query($query)){
					$i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row['event_id'] ."<hr></th>    
								<th>". $row['name'] ."<hr></th>    
								<th>". $row['start_date'] ."<hr></th>    
								<th>". $row['fundings'] ."<hr></th>";
						if($usertype == "visitor")
							echo		"<th><input name=\"mamount\" class=\"left\" type=\"text\" placeholder=\"Donation Amount\" required=\"required\"><hr></th>  
									<th><form method=\"post\"><input type=\"submit\" name=\"".$i."\" class=\"btn3\" value=\"Select\"></form><hr></th>  
								</tr></form>";
						else
							echo		"</tr>";
						$arr[$i] = $row['event_id'];
                        $arr2[$i] = $row['user_id'];
						$i = $i + 1;
					}
				} else {
					echo "Error while retrieving conservation_organization table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						if(isset($_POST[$k])){
                            $amount = $_POST['mamount'];
                            $donatequery = "insert into donation values(\"$userid\", \"".$arr[$k]."\", \"".$arr2[$k]."\",\"$amount\");";
                            $upconservequery = "update conservation_organization set fundings = fundings + $amount where event_id = ".$arr[$k];
							$moneyquery = "update visitor set money = money - $amount where user_id = $userid;";
                            if($amount <= $money){
                                if($dresult = $mysqli->query($donatequery)){
                                    if($ddresult = $mysqli->query($upconservequery)){
                                        $mysqli->query($moneyquery);
                                        echo '<script type="text/JavaScript">
                                        window.alert("Donated Successfully!");
                                        window.location = "makedonation.php";
                                        </script>';
                                    } else {
                                        echo '<script type="text/JavaScript">
                                        window.alert("Update Failed!'.mysqli_error($mysqli).'");
                                        window.location = "makedonation.php";
                                        </script>';
                                    }
                                } else {
                                    echo '<script type="text/JavaScript">
                                    window.alert("Donation Failed!'.mysqli_error($mysqli).'");
                                    window.location = "makedonation.php";
                                    </script>';
                                }
                            } else {
                                echo '<script type="text/JavaScript">
                                window.alert("You do not have enough money!");
                                window.location = "makedonation.php";
                                </script>';
                            }
                            break;
						}
					}
				}
				?>
				</div>
                <h2>My Past Donations</h2>
				<div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$queryshow = 
				"select d.event_id, d.amount, c.name, c.fundings, e.start_date
				 from conservation_organization c, event e, donation d
                 where d.user_id = $userid and e.event_id = c.event_id and c.event_id = d.event_id;";

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">No<hr></th>    
						<th class=\"thtitle\">Conservational Organization Name<hr></th>    
						<th class=\"thtitle\">Start Date<hr></th>    
						<th class=\"thtitle\">Fundings<hr></th>   
                        <th class=\"thtitle\">Amount<hr></th>   
					</tr>";
				if($result5 = $mysqli->query($queryshow)){
					while(($row2 = $result5->fetch_assoc())!= null)  {
						echo "<form method=\"post\"><tr>
								<th>". $row2['event_id'] ."<hr></th>    
								<th>". $row2['name'] ."<hr></th>    
								<th>". $row2['start_date'] ."<hr></th>    
								<th>". $row2['fundings'] ."<hr></th>    
                                <th>". $row2['amount'] ."<hr></th>     
							</tr></form>";
					}
				} else {
					echo "Error while retrieving doantion table. Error: " . mysqli_error($mysqli);
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