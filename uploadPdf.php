<?php

require_once'myvalues.php';

$con = mysqli_connect($host,$user,$pass,$db);
if ($con){
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		if (isset($_POST['title']) && isset($_POST['status']) && isset($_POST['episode']) && isset($_POST['author']) && isset($_POST['user']) 
			&& isset($_FILES['pdf']['name']) && isset($_FILES['cover']['name'])) {
				$titles = $_POST['title'];
				$episodes = $_POST['episode'];
				$authors = $_POST['author'];
				$users = $_POST['user'];
				$status = $_POST['status'];
				
				$folder = "uws/pdf/".$title.".pdf";
				
				move_uploaded_file($_FILES['pdf']['tmp_name'],"pdf/".$users."_".$titles."_".$episodes.".pdf");
				move_uploaded_file($_FILES['cover']['tmp_name'],"cover/".$titles." by ".$authors."_".$episodes.".jpg");
				
				//creating cover and pdf urls
				$coverUrl = "http://192.168.43.43/uws/cover/".$titles." by ".$authors."_".$episodes.".jpg";
				$pdfUrl = "http://192.168.43.43/uws/pdf/".$users."_".$titles."_".$episodes.".pdf";
				
				

				
				//inserting to database
				$query = "insert into pdfs values (null,'$users','$authors','$titles','$episodes',
					'$coverUrl','$pdfUrl','$status');";
				
				if (mysqli_query($con,$query)){
					
					//check if present in uploaders
					$queryup = "select * from pdfuploaders where user='$users';";
					$resultup = mysqli_query($con,$queryup);
					if ($rowup = mysqli_fetch_array($resultup)){
						//present in uploaders : do nothing
					}else {
						
						//get profiles
						$queryProfile = "select * from users where phone='$users';";
						$resultProfile = mysqli_query($con,$queryProfile);
						
						if($rowProfile = mysqli_fetch_array($resultProfile)){
							$profUrl = $rowProfile[3];
							
							//not present in uploaders: insert
							$queryIns = "insert into pdfuploaders values (null,'$users','$profUrl');";
							if(mysqli_query($con,$queryIns)){
								
							}
							
						}
						
						
					}
					
				}
				
			}
	}
}

?>