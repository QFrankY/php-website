<?php
//include config
require_once('include/'.$_SERVER['CONFIG_FILE']);

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

if(isset($_GET['delproject'])){ 

	$stmt = $db->prepare('DELETE FROM projects WHERE projectID = :projectID') ;
	$stmt->execute(array(':projectID' => $_GET['delproject']));

	header('Location: index.php?action=deleted');
	exit;
} 

if(isset($_GET['delupdate'])){ 

	$stmt = $db->prepare('DELETE FROM project_updates WHERE updateID = :updateID') ;
	$stmt->execute(array(':updateID' => $_GET['delupdate']));

	header('Location: index.php?action=deleted');
	exit;
} 

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

?>
<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
	<meta name="description" content="Obsessive Impulsive - Admin Panel">
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="include/css/admin.css?<?php echo time(); ?>">
	<script language="JavaScript" type="text/javascript">
	function delpost(id, title)
	{
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
		window.location.href = 'index.php?delpost=' + id;
	  }
	}
	
	function delproject(id, title)
	{
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
		window.location.href = 'index.php?delproject=' + id;
	  }
	}
	
	function delupdate(id, title)
	{
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
		window.location.href = 'index.php?delupdate=' + id;
	  }
	}
	</script>
</head>
<body>
	<div class="container">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>
	<div id="Content">
		<h1>Blog Posts</h1>
		<table>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php
			try {

				$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<tr>';
					echo '<td>'.$row['postTitle'].'</td>';
					echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
					?>

					<td>
						<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> | 
						<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
					</td>
					
					<?php 
					echo '</tr>';

				}

			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		?>
		</table>
		
		<h1>Projects</h1>
		<table>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php
			try {

				$stmt = $db->query('SELECT projectID, projectName, startDate FROM projects ORDER BY projectID DESC');
				while($row = $stmt->fetch()){
					
					echo '<tr>';
					echo '<td>'.$row['projectName'].'</td>';
					echo '<td>'.date('jS M Y', strtotime($row['startDate'])).'</td>';
					?>

					<td>
						<a href="edit-project.php?id=<?php echo $row['projectID'];?>">Edit</a> | 
						<a href="javascript:delproject('<?php echo $row['projectID'];?>','<?php echo $row['projectName'];?>')">Delete</a>
					</td>
					
					<?php 
					echo '</tr>';

				}

			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		?>
		</table>
		
		<h1>Project Updates</h1>
		<table>
		<tr>
			<th>Title</th>
			<th>Project Name </th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php
			try {

				$stmt = $db->query('SELECT updateID, projectName, updateTitle, postDate FROM project_updates ORDER BY updateID DESC');
				while($row = $stmt->fetch()){
					
					echo '<tr>';
					echo '<td>'.$row['updateTitle'].'</td>';
					echo '<td>'.$row['projectName'].'</td>';
					echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
					?>

					<td>
						<a href="edit-update.php?id=<?php echo $row['updateID'];?>">Edit</a> | 
						<a href="javascript:delupdate('<?php echo $row['updateID'];?>','<?php echo $row['updateTitle'];?>')">Delete</a>
					</td>
					
					<?php 
					echo '</tr>';

				}

			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		?>
		</table>

		<p><a href='add-post.php'>Add Post</a></p>
		<p><a href='add-project.php'>Add Project</a></p>
		<p><a href='add-update.php'>Add Update</a></p>
	</div>
</div>

</body>
</html>
