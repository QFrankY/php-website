<?php
//include config
require_once('include/'.$_SERVER['CONFIG_FILE']);

//Updating Blog Tags
try {
	$stmt = $db->query('TRUNCATE TABLE blog_tags');
	
	$stmt = $db->query('SELECT postID, tags FROM blog_posts ORDER BY postID DESC');
	
	while($row = $stmt->fetch()){
		$tags = explode(", ",$row['tags']);
		
		$numTags = count($tags);
		
		for ($x = 0; $x < $numTags; $x++) {
			
			if ($tags[$x] != NULL) {
				$stmt2 = $db->prepare("SELECT tagName FROM blog_tags WHERE tagName = :tagName LIMIT 1");
				$stmt2->bindValue(':tagName', $tags[$x]);
				$stmt2->execute();

				if ($stmt2->rowCount() > 0){
					$check = $stmt2->fetch(PDO::FETCH_ASSOC);
					$row = $check['tagName'];
					$stmt3 = $db->prepare("UPDATE blog_tags SET numPosts = numPosts + 1 WHERE tagName = '$tags[$x]'");
					$stmt3 ->execute();
				} else {
					$stmt3 = $db->prepare('INSERT INTO blog_tags (tagName,numPosts) 
						VALUES (:tagName, :numPosts)') ;
					$stmt3 ->execute(array(
						':tagName' => $tags[$x],
						':numPosts' => 1
					));
				}
			}
		}
			
	}// end while
		

} catch(PDOException $e) {
	echo $e->getMessage();
}

//Updating Project Tags
try {
	$stmt = $db->query('TRUNCATE TABLE project_tags');
	
	$stmt = $db->query('SELECT projectID, tags, private FROM projects ORDER BY projectID DESC');
	
	while($row = $stmt->fetch()){
		$tags = explode(", ",$row['tags']);
		
		$numTags = count($tags);
		
		$private = $row['private'];
		
		for ($x = 0; $x < $numTags; $x++) {
			
			if ($tags[$x] != NULL) {
				$stmt2 = $db->prepare("SELECT tagName FROM project_tags WHERE tagName = :tagName LIMIT 1");
				$stmt2->bindValue(':tagName', $tags[$x]);
				$stmt2->execute();

				if ($stmt2->rowCount() > 0){
					$check = $stmt2->fetch(PDO::FETCH_ASSOC);
					$row2 = $check['tagName'];
					$stmt3 = $db->prepare("UPDATE project_tags SET numPosts = numPosts + 1 WHERE tagName = '$tags[$x]'");
					$stmt3 ->execute();
					
					if (!$private) {
						$stmt4 = $db->prepare("UPDATE project_tags SET numPublicPosts = numPublicPosts + 1 WHERE tagName = '$tags[$x]'");
						$stmt4 ->execute();
					}
					
				} else {
					$stmt3 = $db->prepare('INSERT INTO project_tags (tagName,numPosts,numPublicPosts) 
						VALUES (:tagName, :numPosts, :numPublicPosts)') ;
					$stmt3 ->execute(array(
						':tagName' => $tags[$x],
						':numPosts' => 1,
						':numPublicPosts' => 1
					));
				}
			}
			
		}// end while
		
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

//Filling in information for project_updates
try {
	$stmt = $db->query('SELECT updateID, projectID, projectName, private FROM project_updates ORDER BY updateID');
	
	while($row = $stmt->fetch()){ 
		$updateID = $row['updateID'];
		$projectID = $row['projectID'];
	
		$stmt2 = $db->query("SELECT projectID, projectName, private FROM projects WHERE projectID = '$projectID'");
		if ($row = $stmt2->fetch()) {
			$projectName = $row['projectName']; 
			$private = $row['private'];
			
			$stmt3 = $db->prepare("UPDATE project_updates SET private = '$private', projectName = '$projectName' WHERE updateID = '$updateID'");
			$stmt3 ->execute();
		}
		
	}
	
} catch(PDOException $e) {
	echo $e->getMessage();
}

//Filling in information for projects
try {
	$stmt = $db->query("SELECT projectID, updateID, postDate FROM project_updates ORDER BY postDate");
	
	while($row = $stmt->fetch()){ 
		$projectID = $row['projectID'];
		$postDate = $row['postDate'];
		
		$stmt2 = $db->prepare("UPDATE projects SET lastUpdated = '$postDate' WHERE projectID = '$projectID'");
		$stmt2 ->execute();
		
	}
	
} catch(PDOException $e) {
	echo $e->getMessage();
}

//log user out
$user->logout();
header('Location: index.php'); 

?>