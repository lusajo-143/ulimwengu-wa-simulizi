<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		//calculating page
		$page = $_POST["page"];
		
		//get total number of uploaded pdfs
		$queryTotal = "select * from pdfs;";
		$resultTotal = mysqli_query($con,$queryTotal);
		
		$totalUsers = 0;
		while($rowtotal = mysqli_fetch_array($resultTotal)){
			$totalUsers++;
		}
		
		$itemsPerPage = 5;
		$wanted = $page * $itemsPerPage;
		$unwanted = $totalUsers - $wanted;
		$fromId = $unwanted + 1;
		$toId = $unwanted + $itemsPerPage;
		
		//getting recent pdfs
		$resp = array();
		$query = "select * from pdfs where id >= $fromId and id <= $toId and status='public';";
		$result = mysqli_query($con,$query);
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['cover'] = $row[5];
			$temp['title'] = $row[3];
			$temp['ep'] = $row[4];
			$temp['pdfUrl'] = $row[6];
			
			$phone = $row[1];
			$temp['phone'] = $phone;
			
			$mypdf = $row[6];
			
			$counter = 0;
			
			$queryViews = "select * from pdfviews where user = '$phone' and pdfUrl='$mypdf';";
			$resultViews = mysqli_query($con,$queryViews);
			while ($rowViews = mysqli_fetch_array($resultViews)){
				$counter++;
			}
			
			$temp['views'] = $counter."";  
			
			//getting profile
			$qprofile = "select * from users where phone='$phone';";
			$rprofile = mysqli_query($con,$qprofile);
			if ($roprofile = mysqli_fetch_array($rprofile)){
				$temp['prof'] = $roprofile[3];
			}
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
		
	}
}

?>