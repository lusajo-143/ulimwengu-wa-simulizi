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
		
		//getting pdfs
		$query = "select * from pdfs where id >= $fromId and id <= $toId and status='public';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['phone'] = $row[1];
			$temp['cover'] = $row[5];
			$temp['title'] = $row[3];
			$temp['ep'] = $row[4];
			$temp['pdfUrl'] = $row[6];
			$pdfUrl = $row[6];
			$phone = $row[1];
			
			//getting no of pdfs
			$queryPdfs = "select * from pdfs where user='$phone' and status='public';";
			$resultPdfs = mysqli_query($con,$queryPdfs);
			$counterPdfs = 0;
			while($rowPdfs = mysqli_fetch_array($resultPdfs)){
				$counterPdfs++;
			}
			$temp['no_pdf'] = $counterPdfs."";
			
			//getting username and profile
			
			$phone = $row[1];
			$queryUser = "select * from users where phone='$phone';";
			$resultUser = mysqli_query($con,$queryUser);
			if($rowUser = mysqli_fetch_array($resultUser)){
				$temp['username'] = $rowUser[1];
				$temp['prof'] = $rowUser[3];
			}
			
			//getting views
			$queryViews = "select * from pdfviews where pdfUrl='$pdfUrl';";
			$resultViews = mysqli_query($con,$queryViews);
			$counterViews = 0;
			while ($rowViews = mysqli_fetch_array($resultViews)){
				$counterViews++;
			}
			$temp['views'] = $counterViews."";
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
	}
}

?>