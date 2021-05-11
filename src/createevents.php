<?php
include("config.php");
session_start();
if($_SESSION['login_user']) // değişecek
{
    $userid = $_SESSION['login_user']; // değişecek
    $namequery = "select name from user where user_id ='". $userid ."'"; //session name e kadarlık kısım indexin.html e alınacak buraya sessiondan çekme gelecek
    $namearr = mysqli_query($mysqli, $namequery);
    $fetcharr = mysqli_fetch_array($namearr, MYSQLI_ASSOC);
    $name = $fetcharr['name'];
    $_SESSION['name'] = $name;

    $moneyquery = "select money from visitor where user_id ='". $userid ."'"; //session name e kadarlık kısım indexin.html e alınacak buraya sessiondan çekme gelecek
    $moneyarr = mysqli_query($mysqli, $moneyquery);// yanlızca visitor
    $fetchmarr = mysqli_fetch_array($moneyarr, MYSQLI_ASSOC);
    $money = $fetchmarr['money'];
    $_SESSION['money'] = $money;
} else {
    header("location: index.php");
}

if(isset($_POST['logout'])){
    session_unset(); 
    session_destroy(); 
    header("location: index.php");
    exit;
}

if(isset($_POST['create'])){
    $startdate = $_POST['startdate'];
    $duration = $_POST['duration'];
    $eventcapacity = $_POST['eventcapacity'];
    $selection = $_POST['guides'];
    $query = "insert into event(user_id, start_date, duration) values($userid, \"$startdate\", $duration);";
    if($result = $mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        $query2 = "insert into group_tour(user_id, event_id, guide_id, capacity) values($userid, $last_id, $selection, $eventcapacity);";
        if($result = $mysqli->query($query2)) {
            echo '<script type="text/JavaScript">
            window.alert("Group tour added successfully!");
            window.location = "createevents.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "createevents.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "createevents.php";
         </script>';
    }
}

if(isset($_POST['create2'])){
    $startdate2 = $_POST['startdate2'];
    $duration2 = $_POST['duration2'];
    $topic = $_POST['topic'];
    $place = $_POST['place'];
    $query = "insert into event(user_id, start_date, duration) values($userid, \"$startdate2\", $duration2);";
    if($result = $mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        $query2 = "insert into educational_program(user_id, event_id, place, topic) values($userid, $last_id, \"$place\", \"$topic\");";
        if($result2 = $mysqli->query($query2)) {
            if(!empty($_POST['check_list'])){
                foreach($_POST['check_list'] as $checked){
                    $query3 = "insert into invitation(vet_id, coor_id, event_id) values($checked, $userid, $last_id);";
                    if(!$result3 = $mysqli->query($query3)) {
                        echo '<script type="text/JavaScript">
                        window.alert("Query3 operation failed!'.mysqli_error($mysqli).'");
                        window.location = "createevents.php";
                         </script>';
                    }
                }
            }
            echo '<script type="text/JavaScript">
            window.alert("Educational Program added successfully!");
            window.location = "createevents.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "createevents.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "createevents.php";
         </script>';
    }
}

if(isset($_POST['create3'])){
    $startdate3 = $_POST['startdate3'];
    $duration3 = $_POST['duration3'];
    $orgname = $_POST['orgname'];
    $query = "insert into event(user_id, start_date, duration) values($userid, \"$startdate3\", $duration3);";
    if($result = $mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        $query2 = "insert into conservation_organization(user_id, event_id, name) values($userid, $last_id, \"$orgname\");";
        if($result = $mysqli->query($query2)) {
            echo '<script type="text/JavaScript">
            window.alert("Conservation Organization added successfully!");
            window.location = "createevents.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "createevents.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "createevents.php";
         </script>';
    }
}

if(isset($_POST['create4'])){
    $startdate4 = $_POST['startdate4'];
    $duration4 = $_POST['duration4'];
    $partytype = $_POST['partytype'];
    $numofani = $_POST['numofani'];
    $animalids = $_POST['animalids'];
    $query = "insert into event(user_id, start_date, duration) values($userid, \"$startdate4\", $duration4);";
    if($result = $mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        $query2 = "insert into endangered_animal_birthday(user_id, event_id, party_type, number_of_birthday_animals) values($userid, $last_id, \"$partytype\", $numofani);";
        if($result2 = $mysqli->query($query2)) {
            $arr = explode(" ", $animalids);
            for($i = 0; $i < count($arr); $i++){
                $query3 = "insert into is_bday(animal_id, coor_id, event_id) values(".$arr[$i].", $userid, $last_id);";
                if(!$result3 = $mysqli->query($query3)){
                    echo '<script type="text/JavaScript">
                    window.alert("Query3 operation failed!'.mysqli_error($mysqli).'");
                    window.location = "createevents.php";
                     </script>';
                }
            }
            echo '<script type="text/JavaScript">
            window.alert("Endangered Animal Birthday added successfully!");
            window.location = "createevents.php";
             </script>';
        } else {
            echo '<script type="text/JavaScript">
            window.alert("Query2 operation failed!'.mysqli_error($mysqli).'");
            window.location = "createevents.php";
             </script>';
        }
    } else {
        echo '<script type="text/JavaScript">
        window.alert("Query operation failed!'.mysqli_error($mysqli).'");
        window.location = "createevents.php";
         </script>';
    }
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
                <h2>Create a New Event</h2>
                <h3>Create Group Tour</h3>
                <form method = "post">
                <input name="startdate" class="tf" type="text" placeholder="Start Date" required="required">
                <input name="duration" class="tf" type="text" placeholder="Duration" required="required">
                <input name="eventcapacity" class="tf" type="text" placeholder="Event Capacity" required="required">
                <select name="guides" id="guides" class="tf">
                    <?php
                        $query = "select g.user_id, u.name from guide g, user u where u.user_id = g.user_id;";
                        if($result = $mysqli->query($query)){
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
                <button name="create" class="btncreate">Create</button>
                </form>

                <h3>Create Educational Program</h3>
                <form method = "post">
                    <div>
                        <input name="startdate2" class="tf" type="text" placeholder="Start Date" required="required">
                        <input name="duration2" class="tf" type="text" placeholder="Duration" required="required">
                        <input name="topic" class="tf" type="text" placeholder="Topic" required="required">
                        <input name="place" class="tf" type="text" placeholder="Place" required="required">
                    </div>
                <div>
                    <p class="contp">Invite veterinarians from list:</p>
                        <?php
                            $query = "select v.user_id, u.name from veterinarian v, user u where u.user_id = v.user_id;";
                            if($result = $mysqli->query($query)){
                                while(($row2 = $result->fetch_assoc())!= null)  {
                                    $first++;
                                    echo "<label class=\"container\"> ". $row2['name'] ." (".$row2['user_id'].")
                                        <input type=\"checkbox\" name=\"check_list[]\" value=\"".$row2['user_id']."\">
                                        <span class=\"checkmark\"></span>
                                        </label>";
                                }
                            } else {
                                echo "Error while retrieving cage table. Error: " . mysqli_error($mysqli);
                            }
                        ?>
                </div>
                <button name="create2" class="btncreate2">Create</button>
                </form>

                <h3>Create Conservation Organization</h3>
                <form method = "post">
                    <input name="startdate3" class="tf" type="text" placeholder="Start Date" required="required">
                    <input name="duration3" class="tf" type="text" placeholder="Duration" required="required">
                    <input name="orgname" class="tf" type="text" placeholder="Organization Name" required="required">
                    <button name="create3" class="btncreate">Create</button>
                </form>

                <h3>Create Endangered Animal Birthday</h3>
                <form method = "post">
                    <input name="startdate4" class="tf" type="text" placeholder="Start Date" required="required">
                    <input name="duration4" class="tf" type="text" placeholder="Duration" required="required">
                    <input name="partytype" class="tf" type="text" placeholder="Party type" required="required">
                    <input name="numofani" class="tf" type="text" placeholder="Number of Birthday Animals" required="required">
                    <input name="animalids" class="tf" type="text" placeholder="List Birth Animal IDs (space btw ids)" required="required">
                    <button name="create4" class="btncreate">Create</button>
                </form>
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