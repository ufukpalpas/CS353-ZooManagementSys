<?php
include("config.php");
session_start();
if($_SESSION['login_user'] && $_SESSION['type'] = "coor") 
{
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
			<a href="indexin.html" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="indexin.html">Main Page</a></li>
					<li><a href="animalsin.html">Animals</a></li>
					<li><a href="eventsin.html">Events</a></li>
					<li><a href="aboutin.html">About Zoo</a></li>
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
            <section class="mainsec">
                <h2>Cage Management</h2>
                <h3>Cages that are waiting to be assigned</h3>
				<div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query = 
				"select *
				 from cage c
				 where c.cage_id not in(select cage_id from assigned);";
                $query1 = 
                "select user_id
                 from keeper;";
				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">Cage ID<hr></th>    
						<th class=\"thtitle\">Cage Type<hr></th>    
						<th class=\"thtitle\">Animal Count<hr></th>    
						<th class=\"thtitle\">Location<hr></th>   
                        <th class=\"thtitle\">Keepers<hr></th>   
						<th class=\"thtitle\">Assign<hr></th>   
					</tr>";
				$arr = array();
				if($result = $mysqli->query($query)){
                    if($result2 = $mysqli->query($query1)){
                        $i = 0;
                        while(($row = $result->fetch_assoc())!= null)  {
                            echo "<form method=\"post\"><tr>
                                    <th>". $row['cage_id'] ."<hr></th>    
                                    <th>". $row['cage_type'] ."<hr></th>    
                                    <th>". $row['animal_count'] ."<hr></th>    
                                    <th>". $row['location'] ."<hr></th>    
                                    <th><select name=\"keepers\" id=\"keepers\">";
                            $first = 0;
                            while(($row2 = $result2->fetch_assoc())!= null) {
                                $first++;
                                $knamequery = "select name from user where user_id ='". $row2['user_id'] ."'";
                                $knamearr = mysqli_query($mysqli, $knamequery);
                                $fetchkarr = mysqli_fetch_array($knamearr, MYSQLI_ASSOC);
                                $kname = $fetchkarr['name'];
                                if($first == 1)
                                    echo "<option selected=\"selected\" value=\"".$row2['user_id']."\">".$kname." (".$row2['user_id'].")</option>";
                                else
                                    echo "<option value=\"".$row2['user_id']."\">".$kname." (".$row2['user_id'].")</option>";
                            }          
                            echo "</select><hr></th>  
                                    <th><form method=\"post\"><input type=\"submit\" name=\"".$i."\" class=\"btn3\" value=\"Assign Keeper\"></form><hr></th>  
                                </tr></form>";
                            $arr[$i] = $row['cage_id'];
                            $i = $i + 1;
                        }
                    } else {
                        echo "Error while retrieving keeper table. Error: " . mysqli_error($mysqli);
                    }
				} else {
					echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>"; 
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($k = 0; $k < count($arr); $k++){
						if(isset($_POST[$k])){
                            $selection = $_POST['keepers'];
                            $query2 = "insert into assigned values($selection, $userid," . $arr[$k] . " )";//----------------------------userid yi keeperid gibi gördük bunu düzelt
                            if(!mysqli_query($mysqli, $query2)){
                                echo "Error while inseting into assigned table. Error: " . mysqli_error($mysqli);
                                break;
                            }
                            echo '<script type="text/JavaScript">
                            window.location = "cagemanagement.php";
                            </script>';
							break;
						}
					}
				}
				?>
				</div>
                <h3>Assigned Cages</h3>
                <div style="width:75%; height:fit-content;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px;">
            	<hr style="margin-left: 20px; margin-right: 20px;">
				<?php
				$query3 = 
				"select u.name, k.user_id, c.cage_id, c.cage_type, c.animal_count, c.location
				 from user u, keeper k, assigned a, cage c
				 where k.user_id = u.user_id and k.user_id = a.keep_id and c.cage_id = a.cage_id and a.coor_id = $userid;"; //--------------------------------------------------- düzelt

				echo "<table style=\"width:90%; margin-top: 10px; margin-left: 60px; margin-right: 10px;\">";
				echo "<tr class=\"toptable\">
						<th class=\"thtitle\">Keeper Name<hr></th>    
						<th class=\"thtitle\">Keeper ID (User ID)<hr></th>    
						<th class=\"thtitle\">Cage ID<hr></th>    
						<th class=\"thtitle\">Cage Type<hr></th>   
                        <th class=\"thtitle\">Animal Count<hr></th>   
						<th class=\"thtitle\">Location<hr></th>   
                        <th class=\"thtitle\">Unassign<hr></th>  
					</tr>";
				$arr2 = array();
				if($result3 = $mysqli->query($query3)){    
                    $t = 0;
                    while(($row2 = $result3->fetch_assoc())!= null)  {
                        echo "<form method=\"post\"><tr>
                                <th>". $row2['name'] ."<hr></th>    
                                <th>". $row2['user_id'] ."<hr></th>    
                                <th>". $row2['cage_id'] ."<hr></th>  
                                <th>". $row2['cage_type'] ."<hr></th>   
                                <th>". $row2['animal_count'] ."<hr></th>    
                                <th>". $row2['location'] ."<hr></th> 
                                <th><form method=\"post\"><input type=\"submit\" name=\"".$t."alt\" class=\"btn3\" value=\"Unassign\"></form><hr></th>  
                            </tr></form>";
                        $arr2[$t] = $row2['cage_id'];
                        $t = $t + 1;
                    }
				} else {
					echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
				}
				echo "</table>"; 
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					for($m = 0; $m < count($arr2); $m++){
                        $place = strval($m) . "alt";
						if(isset($_POST[$place])){
                            $query5 = 
                            "delete from assigned 
                            where cage_id = ".$arr2[$m]."";
                            if(!mysqli_query($mysqli, $query5)){
                                echo "Error while deleting from assigned table. Error: " . mysqli_error($mysqli);
                                break;
                            }
                            echo '<script type="text/JavaScript">
                            window.location = "cagemanagement.php";
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
						<li><a href="indexin.html">Main Page</a></li>
						<li><a href="animalsin.html">Animals</a></li>
						<li><a href="eventsin.html">Events</a></li>
						<li><a href="aboutin.html">About Zoo</a></li>
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