<?php

echo '<script>showProjects();</script>';

if (!isset($db)) {
	if (file_exists('include/'.$_SERVER['CONFIG_FILE'])) {
		require('include/'.$_SERVER['CONFIG_FILE']);
	} else {
		require('../include/'.$_SERVER['CONFIG_FILE']);
	}
}

try {
	//Deciding whether or not to show everything
	if (isset($_SESSION['viewall']) && $_SESSION['viewall'] ) {
		$stmt = $db->query('SELECT projectID, projectName, projectDesc, startDate, lastUpdated, projectLinks, tags, completed, private FROM projects ORDER BY projectID DESC');
	} else {
		$stmt = $db->query('SELECT projectID, projectName, projectDesc, startDate, lastUpdated, projectLinks, tags, completed, private FROM projects WHERE private != 1 ORDER BY projectID DESC');
	}
	
	//Latest Post
	if (!isset($_GET['query']) && !isset($query)){ 
		
		$query = NULL;
		
		echo'<div id="Highlights">';
		
		if ($row = $stmt->fetch()){
			echo' <div id="latestProj">
					<div class="title">';
						
						if (file_exists('portfolio/images/'.$row['projectLinks']) || file_exists('images/'.$row['projectLinks'])) {
							echo' <img src="blog/images/'.$row['projectLinks'].'"></img>';
						} else {
							echo' <img src="'.$row['projectLinks'].'"></img>';
						}
						
					echo' <h1 class="projTitle" >'.$row['projectName'].'</h1>
					</div>
					<div class="projInfo">
						<p class="startDate">Started on '.date('M jS Y', strtotime($row['startDate'])).'</p>
						<p class="projDesc"><span>Description: </span>'.$row['projectDesc'].'</p>
						<p class="projTags"><span>Tags: </span>'.$row['tags'].'</p>
					</div>
					<p class="latestUpdate">Latest Update: '.date('M jS Y', strtotime($row['lastUpdated'])).'</p>';
					
					if ($row['completed']) {
						echo '<img class="ribbon" src="portfolio/resources/ribbon.png"></img>';
					}
					
					echo' <div id="project'.$row['projectID'].'">
						<div class="viewUpdates">
							<div class="hoverText">
								<p>'.$row['projectName'].'</p>
								<p> Click to read more</p>
							</div>
						</div>
					</div>';	
						
			echo'</div>';
		}
	
		//Recently updated NOT COMPLETE
		/*
		if (isset($_GET['viewall']) && $_GET['viewall'] == 1) {
			$stmt = $db->query('SELECT projectName, projectDesc, lastUpdated, projectLinks, tags, completed, private FROM projects ORDER BY postID DESC');
		} else {
			$stmt = $db->query('SELECT projectID, projectName, projectDesc, startDate, lastUpdated, projectLinks, tags, completed, private FROM projects WHERE private != 1 ORDER BY postID DESC');
		}*/
		
		echo '
			<div id="recentProj">
				<h1 class="projTitle">Recent Project Updates</h1>
		';
		
			if (isset($_SESSION['viewall']) && $_SESSION['viewall'] ) {
				$stmt2 = $db->query('SELECT updateID, projectID, projectName, updateTitle, postDate, private FROM project_updates ORDER BY postDate DESC');
			} else {
				$stmt2 = $db->query('SELECT updateID, projectID, projectName, updateTitle, postDate, private FROM project_updates WHERE private != 1 ORDER BY postDate DESC');
			}	
			
			for ($x = 0; $x < 5; $x++) {
				if ($row = $stmt2->fetch()) {
					echo '
						<div class="recentUpdate" id="proj'.$row['projectID'].'">
							<h1>'.$row['updateTitle'].'</h1>
							<p> Project: '.$row['projectName'].'</p>
							<p class ="postDate">Posted on '.date('M jS Y', strtotime($row['postDate'])).'</p>
						</div>
					';
				}
			}
		
		
			echo' </div>
		</div>';
		
	} else if (isset($_GET['query'])) {
		$query = $_GET['query'];
	}
	
	//All Posts
	$counter = 1;
	
	while ($row = $stmt->fetch()){
		$tags = ", ".$row['tags'].",";
		
		if($query == NULL || strpos($tags, " ".$query.",") ) {
			if ($counter % 3 == 2 ) {
				echo' <div class="projectPost middle" id="project'.$row['projectID'].'">';
			} else {
				echo' <div class="projectPost" id="project'.$row['projectID'].'">';
			}
			
				if (!$row['private']) {
					echo '<h1 class="projTitle">'.$row['projectName'].'</h1>';		
				} else {
					echo '<h1 class="projTitle">PRIVATE: '.$row['projectName'].'</h1>';		
				}
				
				if (file_exists('portfolio/images/'.$row['projectLinks']) || file_exists('images/'.$row['projectLinks'])) {
					echo' <img class = "projPic" src="blog/images/'.$row['projectLinks'].'"></img>';
				} else {
					echo' <img class = "projPic"  src="'.$row['projectLinks'].'"></img>';
				}
				
				echo'	<div class="projInfo">
						<p class="startDate">Started on '.date('M jS Y', strtotime($row['startDate'])).'</p>
						<p class="projDesc"><span>Description: </span>'.$row['projectDesc'].'</p>
						<p class="projTags"><span>Tags: </span>'.$row['tags'].'</p>
					</div>
					<p class="latestUpdate">Latest Update: '.date('M jS Y', strtotime($row['lastUpdated'])).'</p>';
					
					if ($row['completed']) {
						echo '<img class="ribbon" src="portfolio/resources/ribbon.png"></img>';
					}
					
					echo' <div class="viewUpdates">
						<div class="hoverText">
							<p>'.$row['projectName'].'</p>
							<p> Click to read more</p>
						</div>
					</div>';
			echo'</div>';
			
			$counter++;
		}
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

?>