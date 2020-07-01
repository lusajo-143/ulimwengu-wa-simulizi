<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if(isset($_POST['sender']) && isset($_POST['receiver']) && isset($_FILES['pdf']['name']) &&
			isset($_POST['message']) && isset($_POST['title']) && isset($_POST['ep'])){
				$sender = $_POST['sender'];
				$receiver = $_POST['receiver'];
				$message = $_POST['message'];
				$title = $_POST['title'];
				$ep = $_POST['ep'];
				
				//get id from messages
				$queryid = "select * from messages;";
				$resultid = mysqli_query($con,$queryid);
				$counterid = 1;
				while ($rowid = mysqli_fetch_array($resultid)){
					$counterid++;
				}
				
				$folder = "chatpdf/".$sender."_To_".$receiver."_".$counterid.".pdf";
				$pdfUrl = "http://192.168.43.43/uws/".$folder;
				
				
				if(move_uploaded_file($_FILES['pdf'][tmp_name],$folder)){
					
					$query = "insert into messages values (null,'$sender','$receiver','$message',
							'$pdfUrl',now(),'false','$title','$ep');";
					
					if(mysqli_query($con,$query)){
						
						//adding profile to chatprofiles
						//checking if already present
						$queryC = "select * from chatprofiles where (sender='$sender' and receiver='$receiver') or
									(sender='$receiver' and receiver='$sender');";
						
						$resultC = mysqli_query($con,$queryC);
						if($row = mysqli_fetch_array($resultC)){
							
						}else{
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
							
							//now inserting to chatprofiles
							$queryChatp = "insert into chatprofiles values (null,'$sender','$receiver',
										'$senderUrl','$ReceiverUrl');";
							
							if (mysqli_query($con,$queryChatp)){
								
							}
						}
						
					}
				}
				
				
			}
	}
}

?>