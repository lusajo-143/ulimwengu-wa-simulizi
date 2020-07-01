<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$title = $_POST["pdf"];
		
		
		
		//getting pdfs
		$resp = array();
		$query = "select * from pdfs where title like '%$title%' and status='public';";
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