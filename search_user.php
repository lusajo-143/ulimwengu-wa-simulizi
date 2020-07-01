<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		
		$user = $_POST["user"];
		
		$query = "select * from users where name like '%$user%';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['prof'] = $row[3];
			$phone = $row[2]."";
			$temp['phone'] = $row[2];
			$temp['name'] = $row[1];

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
		
		//getting uploaders
		$query = "select * from pdfuploaders where ;";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			
			//getting name
			$qName = "select * from users where phone='$phone';";
			$rName = mysqli_query($con,$qName);
			$counterNo = 0;
			if($roName = mysqli_fetch_array($rName)){
				$counterNo++;
			}
			
			
			
			array_push($resp,$temp);
			
		}
		
		echo json_encode($resp);
		
	}
}

?>