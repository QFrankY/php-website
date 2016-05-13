<?php
//$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate, imgSource FROM blog_posts WHERE postID = :postID');
//$stmt->execute(array(':postID' => $_GET['id']));
//$row = $stmt->fetch();

	try {
		$stmt = $db->query('SELECT postID, postTitle, postCont, postDate FROM blog_posts ORDER BY postID DESC');
		
		//Recent Posts
		echo'<div class="card"> <h1>Recent Posts: </h1>';
		for ($x=0; $x < 3; $x++){
			if ($row = $stmt->fetch()) {
				echo'
					<div class="summary">
						<p class= "blogTitle"><a href="blog.php#post'.$row['postID'].'">'.$row['postTitle'].'</a></p>
						<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).' at '.date('H:i', strtotime($row['postDate'])).'</p>
					</div>
				';
			}
		}
		echo'</div>';
		
		echo'<div class="card">';
			echo '<h1>Categories: </h1>';
		
			$stmt = $db->query('SELECT tagName, numPosts FROM blog_tags ORDER BY tagName');
			while($row = $stmt->fetch()){
				echo '
					<p class="tags">'.$row['tagName'].' [ '.$row['numPosts'].' ]</p>
				';		
			}
			
			echo '<p id="viewall">View all posts</p>';
		
		echo'</div>';

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
//p class="tags"><span>'.$row['tagName'].'</span> ('.$row['numPosts'].')</p> 
?>