<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['phone'];
		$sender = $_POST['phone'];
		
		
		//check at senders column
		$querys = "select * from chatprofiles where sender='$phone';";
		$results = mysqli_query($con,$querys);
		$resp = array();
		while ($rows = mysqli_fetch_array($results)){
			$temp = array();
			$temp['prof'] = $rows[4];
			$temp['phone'] = $rows[2];
			$receiver = $rows[2];
			
			//getting no of messages
			$querynos = "select * from messages where (sender='$sender' and receiver='$receiver') or 
						(sender='$receiver' and receiver='$sender');";
			$counternos = 0;
			$resultnos = mysqli_query($con,$querynos);
			while ($rownos = mysqli_fetch_array($resultnos)){
				$counternos++;
			}
			$temp['no'] = $counternos."";
			
			//getting status
			$status = "true";
			$querystas = "select * from messages where sender='$receiver' and receiver='$sender' and status='false';";
			$resultstas = mysqli_query($con,$querystas);
			if($rowstas = mysqli_fetch_array($resultstas)){
				$status = "false";
			}
			
			$temp['status'] = $status;
			
			//getting username
			$queryuser = "select * from users where phone='$receiver';";
			$resultuser = mysqli_query($con,$queryuser);
			$username = "";
			if($rowuser = mysqli_fetch_array($resultuser)){
				$username = $rowuser[1];
			}
			$temp['username'] = $username;
			
			array_push($resp,$temp);
		}
		
		
		//check at receivers column
		$queryr = "select * from chatprofiles where receiver='$phone';";
		$resultr = mysqli_query($con,$queryr);
		while ($rowr = mysqli_fetch_array($resultr)){
			$temp = array();
			$temp['prof'] = $rowr[3];
			$temp['phone'] = $rowr[1];
			$receiver = $rowr[1];
			
			//getting no of messages
			$querynor = "select * from messages where (sender='$sender' and receiver='$receiver') or 
						(sender='$receiver' and receiver='$sender');";
			$counternor = 0;
			$resultnor = mysqli_query($con,$querynor);
			while ($rownor = mysqli_fetch_array($resultnor)){
				$counternor++;
			}
			$temp['no'] = $counternor."";
			
			//getting status
			$status = "true";
			$querystar = "select * from messages where sender='$receiver' and receiver='$sender' and status='false';";
			$resultstar = mysqli_query($con,$querystar);
			if($rowstar = mysqli_fetch_array($resultstar)){
				$status = "false";
			}
			
			$temp['status'] = $status;
			
			//getting username
			$queryuser = "select * from users where phone='$receiver';";
			$resultuser = mysqli_query($con,$queryuser);
			$username = "";
			if($rowuser = mysqli_fetch_array($resultuser)){
				$username = $rowuser[1];
			}
			$temp['username'] = $username;
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
		
	}
}

?>