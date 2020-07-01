<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		//calculating page
		$page = $_POST["page"];
		
		
		//get total number of users uploaded pdfs
		$queryTotal = "select * from pdfuploaders;";
		$resultTotal = mysqli_query($con,$queryTotal);
		
		$totalUsers = 0;
		while($rowtotal = mysqli_fetch_array($resultTotal)){
			$totalUsers++;
		}
		
		$itemsPerPage = 10;
		$wanted = $page * $itemsPerPage;
		$unwanted = $totalUsers - $wanted;
		$fromId = $unwanted + 1;
		$toId = $unwanted + $itemsPerPage;
		
		
		//getting uploaders
		$query = "select * from pdfuploaders where id >= $fromId and id <=$toId;";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['prof'] = $row[2];
			$phone = $row[1]."";
			$temp['phone'] = $phone;
			
			//getting name
			$qName = "select * from users where phone='$phone';";
			$rName = mysqli_query($con,$qName);
			$counterNo = 0;
			if($roName = mysqli_fetch_array($rName)){
				$temp['name'] = $roName[1];
				$counterNo++;
			}
			
			
			//getting number of pdfs
			$qnumber = "select * from pdfs where user='$phone';";
			$rnumber = mysqli_query($con,$qnumber);
			$counterNo = 0;
			while ($roName = mysqli_fetch_array($rnumber)){
				$counterNo++;
			}
			
		
			$temp['no'] = $counterNo."";
			
			array_push($resp,$temp);
			
		}
		
		echo json_encode($resp);
		
	}
}

?>