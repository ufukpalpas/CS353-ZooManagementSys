<?php
include("config.php"); 
session_start();

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

if(isset($_POST['comment_form'])) {                
    $date = date('Y-m-d');
    $comment = $_POST['comment'];
    $rate = 0;

    if($_POST['rate5']){ 
        $rate = 5;
    }
    elseif($_POST['rate4']){
        $rate = 4;
    }
    elseif($_POST['rate3']){
        $rate = 3;
    }
    elseif($_POST['rate2']){
        $rate = 2;
    }
    elseif($_POST['rate1']){
        $rate = 1;
    }

    $event_option = $_POST['option'];

    $user_id_query = "SELECT user_id FROM group_tour WHERE event_id =" .$event_option;
    $user_i = $mysqli -> query($user_id_query);
    $user_i = mysqli_fetch_row($user_i)[0];
    $check_query = "SELECT event_id FROM comment WHERE event_id =". $event_option;
    $check_query = $mysqli -> query($check_query);
    console_log(mysqli_fetch_row($check_query)[0]);
    if(mysqli_fetch_row($check_query)[0] != NULL){
        echo "<script type='text/javascript'>
         alert('You already made a comment !! ');
        </script>";
    }
    else{
        $insert_query = "INSERT INTO comment VALUES(default,\"" .$comment. "\",\"" .$date. "\",1," .$rate. "," .$user_i. ",16," .$event_option. ")";
        if($mysqli -> query($insert_query)){
            echo "<script type='text/javascript'>
            alert('Added');
        </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
        <style type="text/css">
        .image{
            width : 20px;
            height : 20px;
        }
        .table{
            border-collapse: collapse;
            border : 0.5px solid gray; 
            font: 18px helvetica;
            text-align: center;
            width : 100%;

        }
        .tabl{
            border-collapse: collapse;
            border-top : 0.5px solid gray; 
            border-bottom : 0.5px solid gray; 
            font: 18px helvetica;
            text-align: center;
            width : 25%;
            height : 30px;
        } 
        .title{
            font: 40px helvetica;
            margin-bottom: 10px;
        }
        .comment_btn{
            margin-left: 80%;
            margin-top: -10%;
            width : 20%;
            height : 190px;
            background-color : #3db7cc;
            cursor: pointer;
            font: 18px helvetica;
            border-radius: 20px;
        }
        .comment_txt{ 
            width : 70%;
            height : 40px;
            border-radius: 5px;
            border : 1px solid gray;
        }
        .text_field{
            padding-top : 25px;
        }
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
            margin-left: 81%;
            margin-top: -20%;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #3db7cc;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #3db7cc;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #3db7cc;
        }
        .select_event{
            border-radius: 5px;
        }



        </style>

		<title> KasaloZoo </title>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="loginstyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">
	</head>

	<body>
		<header>
			<a href="index.html" class="header-brand">KasaloZoo</a>
			<img class="logo" src="image/balina.png" alt="kasalot logo">
			<nav>
				<ul>
					<li><a href="index.html">Main Page</a></li>
					<li><a href="animals.html">Animals</a></li>
					<li><a href="events.html">Events</a></li>
					<li><a href="about.html">About Zoo</a></li>
                    <li>
                        <a href="#" onclick="toggleuserPopup()">Hello "username" ("user_id")
                        <img class="down" src="image/user.png" alt="user logo">
                        </a>
                    </li>
                    <li><a href="#">"money"</a></li>
                    <img class="dollar" src="image/dollar.png" alt="dollar logo">
				</ul>
			</nav>
		</header>
		<main>
            <div class="user-popup" id="user-popup">
                <div class="overlay"></div>
                <div class="content">
                	<div class="close" onclick="toggleuserPopup()">×</div>
                    <h2 class="h2pop">Operations</h2>
                    <button class="btn">View Profile</button>
                    <button class="btn">Edit Profile</button>
                    <button class="btn">Deposit Money</button>
                    <button class="btn">Make Donation</button>
                    <button class="btn">Create Complaint Form</button>
                    <button class="btn">My Events</button>
                    <button class="btn">Join a Group Tour</button>
                    <button class="btn">Join a Endangered Birthday</button>
                    <button class="btn">Logout</button>
                </div>
            </div>
            <script>
				function toggleuserPopup(){
                    document.getElementById("user-popup").classList.toggle("activate");
                }
            </script>
			<!-- CODE HERE -->
        <div style="width:75%; height:75%;  background-color:white; margin-left: 12.5%; margin-top: 20px; border-radius: 20px; margin-bottom:20%;">
                <h1 class="title"> Write a Comment</h1>
                <?php   
                $userid = 16;
                $query = "SELECT * FROM comment WHERE vis_id=".$userid;
                $result = $mysqli -> query($query);
                $events_query = "SELECT event_id FROM pay WHERE user_id = $userid";
                $events = $mysqli -> query($events_query);
                echo "<table class='table' >"; 
                echo "<tr>";    
                echo  "<td class='tabl' style='color: #3db7cc;'><b>No</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Date</b></td>";
                echo  "<td class='tabl' style='color: #3db7cc;'><b>Anonymity</b></td>";
                echo "</tr>";
                while ($row = $result -> fetch_row()) {
                    echo "<tr>";
                    echo  "<td class='tabl'>".$row[0]."</td>";
                    echo  "<td class='tabl'>".$row[2]."</td>";
                    if($row[3]== 1){
                        echo  "<td class='tabl'>"."<i>anonymous</i>"."</td>";
                    }
                    else{
                        echo  "<td class='tabl'>"."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table> 
                    <div class='text_field'>
                    <form method='post' name='comment_form'>
                        <div>
                            <select class='select_event' name='option'>
                            <option value='' disabled selected>Choose Group Tour</option>";
                
                            while ($row = $events -> fetch_row()) {
                                echo "<option value=".$row[0].">Group Tour ".$row[0]."</option>";
                            }
                echo "    </select>
                            <div style='padding-top: 20px;'>
                            <input type='text' style='height:200px;'class='comment_txt' name='comment' placeholder='Enter your comment here...'>
                            <input style='height: 60px;' type='submit' name='comment_form' class='comment_btn' value='SUBMIT' > 
                           
                            </div>
                        </div>  
                        <div class='rate'>
                            <input type='radio' id='star5' name='rate5' value='5' />
                            <label for='star5' title='text'>5 stars</label>
                            <input type='radio' id='star4' name='rate4' value='4' />
                            <label for='star4' title='text'>4 stars</label>
                            <input type='radio' id='star3' name='rate3' value='3' />
                            <label for='star3' title='text'>3 stars</label>
                            <input type='radio' id='star2' name='rate2' value='2' />
                            <label for='star2' title='text'>2 stars</label>
                            <input type='radio' id='star1' name='rate1' value='1' />      
                            <label for='star1' title='text'>1 stars</label>
                        </div>
                    </form>
                </div>";
         ?>
        </div>









			

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
						<li><a href="index.html">Main Page</a></li>
						<li><a href="animals.html">Animals</a></li>
						<li><a href="events.html">Events</a></li>
						<li><a href="about.html">About Zoo</a></li>
					</ul>
				</div>
				<div class="partner-list">
					<h5>PARTNERS</h5>
					<p>Bilkent University</p>
				</div>
				</div>
			</footer>
		</div>
		<script src="owlcarousel/jquery.min.js"></script>
		<script src="owlcarousel/owl.carousel.js"></script>
		<script>
			$('.owl-carousel').owlCarousel({
				loop:true,
				margin:20,
				nav:false,
				responsive:{
					0:{
						items:1
					},
					600:{
						items:1
					},
					1000:{
						items:1
					}
				}
			})
		</script>
	</body>
</html>