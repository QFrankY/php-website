<?php
if (!isset($db)) {
	if (file_exists('include/'.$_SERVER['CONFIG_FILE'])) {
		require('include/'.$_SERVER['CONFIG_FILE']);
	} else {
		require('../include/'.$_SERVER['CONFIG_FILE']);
	}
}

try {
	//Deciding whether or not to show everything
	if (isset($_GET['project'])) {
		$projectID = $_GET['project'];
	}
	
	$stmt = $db->query("SELECT projectID, updateID, updateTitle, updateCont, postDate, updateType, updateLink, private FROM project_updates WHERE projectID = '$projectID' ORDER BY postDate");
	$row = $stmt->fetch();
	
	if ((isset($_SESSION['viewall']) && $_SESSION['viewall']) || !$row['private']) {

		echo'<div id="updates">';
		
		//Fetching Updates
		do {

			echo' <div class="updatePost" id="update'.$row['updateID'].'">
					<h1 class="updateTitle">'.$row['updateTitle'].'</h1>'; 
					
					if ($row['updateType']=="picture") {
						if (file_exists('portfolio/images/'.$row['updateLink'])) {
							echo' <img class="updatePic" src="portfolio/images/'.$row['updateLink'].'"></img>';
						} else {
							echo' <img class="updatePic" src="'.$row['updateLink'].'"></img>';	
						}
					} else if ($row['updateType']=="video") {
						echo $row['updateLink'];
					}
					
					echo '<div class="projInfo">
						<p class="postDate">Posted on '.date('M jS', strtotime($row['postDate'])).'</p>
						<div class="projCont">'.$row['updateCont'].'</div>
					</div>
				</div>';
		} while ($row = $stmt->fetch());
		
		echo '</div>';
		
		//Creating Project Summary Information side bar
		$stmt2 = $db->query("SELECT projectID, projectName, startDate, projectLinks FROM projects WHERE projectID = '$projectID'");
		echo '<div id="infobar">';
			
			if ($row = $stmt2->fetch()){
				echo' <div class="card" id="projectSummary">
					<h1>'.$row['projectName'].'</h1>';
					if (file_exists('portfolio/images/'.$row['projectLinks']) || file_exists('images/'.$row['projectLinks'])) {
						echo' <img class = "projPic" src="blog/images/'.$row['projectLinks'].'"></img>';
					} else {
						echo' <img class = "projPic"  src="'.$row['projectLinks'].'"></img>';
					}
				echo' <p> Started on '.date('M jS', strtotime($row['startDate'])).'</p>
				</div>';
			} 
			
			$stmt = $db->query("SELECT projectID, updateID, updateTitle, postDate FROM project_updates WHERE projectID = '$projectID' ORDER BY postDate");
			echo' <div class="card" id="tableOfContents">
				<h1>Table of Contents </h1>';
				
				while ($row = $stmt->fetch()){
					echo'<a href="#update'.$row['updateID'].'">
						<h2>'.$row['updateTitle'].'</h2>
						<p>Posted on '.date('M jS', strtotime($row['postDate'])).'</p>
					</a>';
				}
			echo '</div>';
		
		echo '</div>';
	}// end if
	else {
		header('Location: portfolio.php');
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

echo '<script>showUpdates();</script>';

?>