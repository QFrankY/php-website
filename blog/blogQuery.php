<?php

function echoPost ($row){
			if ($row['linkType'] != NULL) {
				echo '<div class="blogPost long" id="post'.$row['postID'].'">
						<div class="postDate">
							<h1 class="dateMonth"> '.date('M', strtotime($row['postDate'])).' </h1>
							<h1> '.date('jS', strtotime($row['postDate'])).' </h1>
						</div>
						<div class ="postBody">
							<h1>'.$row['postTitle'].'</h1>';
							
							if ($row['linkType']=="picture") {
								if (file_exists('blog/images/'.$row['postLink']) || file_exists('images/'.$row['postLink'])) {
									echo' <img src="blog/images/'.$row['postLink'].'"></img>';
								} else {
									echo' <img src="'.$row['postLink'].'"></img>';
								}
							} else if ($row['linkType']=="video") {
								echo $row['postLink'];
							}
							
							echo'
							<div class="blogText">
								<p class="desc"><span>Description: </span>'.$row['postDesc'].'</p>	
								<div class="cont">'.$row['postCont'].'</div>
								<p class="tags"><span>Tags: </span>'.$row['tags'].'</p>
								<a class="close"></a>
								<p class="exactPostDate">Posted On: '.date('M jS Y', strtotime($row['postDate'])).'</p>
							</div>
							<a class ="button">Read More</a>
						</div>			
					</div>';		
			} else {
				echo '<div class="blogPost short" id="post'.$row['postID'].'">
						<div class="postDate">
							<h1 class="dateMonth"> '.date('M', strtotime($row['postDate'])).' </h1>
							<h1> '.date('jS', strtotime($row['postDate'])).' </h1>
						</div>
						<div class ="postBody">
							<h1>'.$row['postTitle'].'</h1>
							<div class="blogText">
								'.$row['postCont'].'
								<p class="tags"><span>Tags: </span>';
								if ($row['tags'] == NULL) {
									echo 'none';
								} else {
									echo $row['tags'].'</p>';
								}
							echo' <p class="exactPostDate">Posted On: '.date('M jS Y', strtotime($row['postDate'])).'</p>	
							</div>			
						</div>	
					</div>';
			}	
}

if (!isset($db)) {
	if (file_exists('include/'.$_SERVER['CONFIG_FILE'])) {
		require('include/'.$_SERVER['CONFIG_FILE']);
	} else {
		require('../include/'.$_SERVER['CONFIG_FILE']);
	}
}

echo '<script src="blog/resources/js/blog.js?'.time().'"></script>';

if(isset($_GET['tag'])){
	$tag = $_GET['tag'].",";
} else if (!isset($tag)) {
	$tag = NULL;
}

try {
	
	if (isset($postID)) {
		echo'<div id=selectedPost>';
		
		$stmt = $db->query("SELECT postID, postTitle, postDesc, postDate, postCont, postLink, linkType, tags FROM blog_posts WHERE postID ='$postID'");
		if ($row = $stmt->fetch()){
			echoPost($row);
		}
		echo'<h3><span>Other Posts: </span></h3>';
		echo'</div>';
		
		$stmt = $db->query("SELECT postID, postTitle, postDesc, postDate, postCont, postLink, linkType, tags FROM blog_posts WHERE postID !='$postID' ORDER BY postID DESC");
	} else {
		$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate, postCont, postLink, linkType, tags FROM blog_posts ORDER BY postID DESC');
	}
	while($row = $stmt->fetch()){
		if($tag==NULL || strpos(" ".$row['tags'].",", $tag) ) { //|| strpos(" " + $row['tags'] + ","," " + $tag + ",") !== false){
			echoPost($row);
		}
	}//end while
	
	echo '<script>optimizeYouTubeEmbeds()</script>';
	
} catch(PDOException $e) {
	echo $e->getMessage();
}
?>