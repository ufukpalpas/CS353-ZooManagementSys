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

if(isset($_POST['feedbtn'])){
	$famount = $_POST['famount'];
	$feedtime = $_POST['feedtime'];
	$feeddate = $_POST['feeddate'];
	$barcode = $_POST['barcode'];
	$checkquery = "select stock from food where barcode = $barcode;";
	//if($result = $mysqli->query($checkquery)) {
		$cheackarr = mysqli_query($mysqli, $checkquery);
		$fetchcheckarr = mysqli_fetch_array($cheackarr, MYSQLI_ASSOC);
		$stock = $fetchcheckarr['stock'];
		if($stock >= $famount){
			$query = "insert into regularize_food values($cageid, $barcode, \"$feeddate $feedtime\", $famount, $userid);"; 
			$query2 = "update cage set feed_time = \"$feedtime\", last_care_date = \"$feeddate\" where cage_id = $cageid;";
			$query3 = "update food set stock = stock - $famount where barcode = $barcode;";
			if($result = $mysqli->query($query)) {
				if($result2 = $mysqli->query($query2)){
					if($result3 = $mysqli->query($query3)){
						echo '<script type="text/JavaScript">
						window.alert("Cage successfully feeded!");
						window.location = "mycagesin.php";
						</script>';
					} else {
						echo '<script type="text/JavaScript">
						window.alert("Query3 operation failed!'.mysqli_error($mysqli).'");
						window.location = "mycagesin.php";
						</script>';
					}
				} else {
					echo '<script type="text/JavaScript">
					window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
					window.location = "mycagesin.php";
					</script>';
				}
			} else {
				echo '<script type="text/JavaScript">
				window.alert("Query operation failed!'.mysqli_error($mysqli).'");
				window.location = "mycagesin.php";
				</script>';
			}
		} else {
			echo '<script type="text/JavaScript">
			window.alert("Not enough stock!");g
			window.location = "mycagesin.php";
			</script>';
		}
	/*} else {
		echo '<script type="text/JavaScript">
		window.alert("Stock Check Query operation failed!'.mysqli_error($mysqli).'");
		window.location = "mycagesin.php";
		</script>';
	}*/
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
					<p class="h2pop">Regularize Food</p>
					<form method = "post">
						<input name="feeddate" class="tff" type="text" onfocus="(this.type='date')" placeholder="Feed Date" required="required">
						<input name="feedtime" class="tff" type="text" placeholder="Feed Time (hh:mm)" required="required">
						<input name="barcode" class="tff" type="text" placeholder="Barcode" required="required">
						<input name="famount" class="tff" type="text" placeholder="Food Amount" required="required">
						<button name="feedbtn" class="btn">Regularize Food</button>
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
                <h2>My Cages</h2>
				<div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select *
				 from cage c, assigned a
				 where a.keep_id = \"". $userid ."\" and c.cage_id = a.cage_id;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">Cage ID<hr></th>    
						<th class=\"thtitle\">Cage Type<hr></th>    
						<th class=\"thtitle\">Animal Count<hr></th>    
						<th class=\"thtitle\">Last Care Date<hr></th>   
						<th class=\"thtitle\">Feed Time<hr></th>  
						<th class=\"thtitle\">Location<hr></th>  
						<th class=\"thtitle\">Food<hr></th>   
						<th class=\"thtitle\">Select for any operation<hr></th>   
					</tr>";
				$arr = array();
				if($result = $mysqli->query($query)){
					$i = 0;
					while(($row = $result->fetch_assoc())!= null)  {
						echo "<tr>
								<th>". $row['cage_id'] ."<hr></th>    
								<th>". $row['cage_type'] ."<hr></th>    
								<th>". $row['animal_count'] ."<hr></th>    
								<th>". $row['last_care_date'] ."<hr></th>    
								<th>". $row['feed_time'] ."<hr></th>    
								<th>". $row['location'] ."<hr></th> 
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."reg\" class=\"btn3\" value=\"Regularize Food\"></form><hr></th>  
								<th><form method=\"post\"><input type=\"submit\" name=\"".$i."select\" class=\"btn3\" value=\"Select\"></form><hr></th>  
							</tr>";
						$arr[$i] = $row['cage_id'];
						$i = $i + 1;
					}
				} else {
					echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						$place = strval($k) . "select";
						$place2 = strval($k) . "reg";
						if(isset($_POST[$place])){
							$_SESSION['cageid'] = $arr[$k];
							echo '<script type="text/JavaScript">
								window.location.href = "animalsincage.php";
							</script>';
							//header("location: animalsincage.php");
							break;
						}
						if(isset($_POST[$place2])){
							$cageid = $arr[$k];
							$_SESSION['cageid'] = $arr[$k];
							echo '<script type="text/JavaScript">
							toggleTRPopup();
							</script>';
							break;
						}
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