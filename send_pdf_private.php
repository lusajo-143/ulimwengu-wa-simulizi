<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$sender = $_POST['sender']."";
		$receiver = $_POST['receiver']."";
		$message = $_POST['message'];
		$pdfUrl = $_POST['pdf'];
		$title = $_POST['title'];
		$ep = $_POST['ep'];
		
		$query = "insert into messages values (null,'$sender','$receiver','$message','$pdfUrl',now(),'false','$title','$ep');";
		
		if(mysqli_query($con,$query)){
			$resp = array("response" => "sent");
			
			echo json_encode($resp);
			
			//checking if present in chatprofiles
			$queryC = "select * from chatprofiles where (sender='$sender' and receiver='$receiver') or (sender='$receiver' and receiver='$sender');";
			$resultC = mysqli_query($con,$queryC);
			if($rowC = mysqli_fetch_array($resultC)){
				
			}else {
				
				//getting url for profile picture
				$querySenderProf = "select * from users where phone='$sender';";
				$resultSenderProf = mysqli_query($con,$querySenderProf);
				$senderUrl = "";
				if($rowSenderProf = mysqli_fetch_array($resultSenderProf)){
					$senderUrl = $rowSenderProf[3];
				}
							
				$queryReceiverProf = "select * from users where phone='$receiver';";
				$resultReceiverProf = mysqli_query($con,$queryReceiverProf);
				$ReceiverUrl = "";
				if($rowReceiverProf = mysqli_fetch_array($resultReceiverProf)){
					$ReceiverUrl = $rowReceiverProf[3];
				}
				
				$queryIn = "insert into chatprofiles values (null,'$sender','$receiver','$senderUrl','$ReceiverUrl');";
				if (mysqli_query($con,$queryIn)){
					
				}
				
				
			}
		}
		
	}
}
?>