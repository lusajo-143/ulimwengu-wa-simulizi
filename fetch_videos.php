<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$page = $_POST['page'];
		
		//get total number of uploaded videos
		$queryTotal = "select * from videos;";
		$resultTotal = mysqli_query($con,$queryTotal);
		
		$totalvid = 0;
		while($rowtotal = mysqli_fetch_array($resultTotal)){
			$totalvid++;
		}
		
		$itemsPerPage = 3;
		$wanted = $page * $itemsPerPage;
		$unwanted = $totalvid - $wanted;
		$fromId = $unwanted + 1;
		$toId = $unwanted + $itemsPerPage;
		
		$query = "select * from videos where id>='$fromId' and id <='$toId';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['id'] = $row[2];
			$temp['phone'] = $row[1];
			$temp['title'] = $row[3];
			$phone = $row[1];
			//getting profile picture
			$queryprof = "select * from users where phone='$phone';";
			$resultprof = mysqli_query($con,$queryprof);
			if ($rowprof = mysqli_fetch_array($resultprof)){
				$temp['prof'] = $rowprof[3];
			}
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
	}
	
}


?>