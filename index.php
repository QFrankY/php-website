<?php require('include/'.$_SERVER['CONFIG_FILE']); ?>
<!DOCTYPE html>
<!-- Coded and styled by Frank Yu-->
<html>
	
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Personal Website of Frank Yu">
		<title>Frank Yu - Welcome!</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700,900,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="include/css/general.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="include/css/mainpage.css?<?php echo time(); ?>">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="include/js/general.js?<?php echo time(); ?>"></script>
		<script src="include/js/mainpage.js?<?php echo time(); ?>"></script>
		
		<!--I did not write the following script. Source: http://www.skipser.com/test/googlecode/gplus-youtubeembed/test.html-->
		<script src="include/js/replaceVideo.js?<?php echo time(); ?>"></script>
	</head>
	
	<body>
	
		<div id="container">
			<header>
				<div id="NavigationBar">
					<nav class="container">
						<a href="index.php">HOME</a>
						<a href="blog.php">BLOG</a>
						<a href="portfolio.php">PORTFOLIO</a>
					</nav>
				</div>
				<div id="HeaderBody" class="container">
					<div id="Featured">
						<h2 id="Title"> A Personal Professional Website </h2>
						<p id="Introduction">
							Welcome! My name is Frank and I am a Mechatronics Engineering student at the
							University of Waterloo. I am a technology enthusiast. My main interests are 
							web development and computer hardware. I developed this website as a personal
							portfolio and to track the various projects we do in engineering. I am also a
							huge esports enthusiast and will be providing my own insight.
						</p>
						<p id="Byline">
							If you are looking to hire, make sure to check out my LinkedIn Page!
						</p>
						<a id="linkedIn" class="button" href="http://www.linkedin.com/in/qfranky" target="_blank"> 
							My LinkedIn Profile
						</a>
					</div>
				</div>
			</header>
			
			<div id="Content">

				<div id="Blog" class="section">
					<div class="container">
						<h1><a href="blog.php" >Blog Updates</a></h1>
						<div id="RecentPosts">
							<h2>Latest Posts: </h2>			
							<?php
								try {
									$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
									for($x = 0; $x < 3; $x++){
										if ($row = $stmt->fetch()){
											echo '
											<div class="blogPost" id="post'.$row['postID'].'">
												<div class ="info">
													<h3><a href="blog.php?viewPost='.$row['postID'].'">'.$row['postTitle'].'</a></h3>
													<p class="time">Posted on '.date('M jS Y', strtotime($row['postDate'])).'</p>
													<p class="desc"><span>Description: </span>'.$row['postDesc'].'</p>
												</div>
											</div>';
										}
									}// end for

								} catch(PDOException $e) {
									echo $e->getMessage();
								}
							?>
						</div>
						<div id="RecentLinks">
							<h2>Recently Linked: </h2>	
							<?php
								try {
									$stmt = $db->query('SELECT postID, linkType, postLink FROM blog_posts WHERE postLink != "" ORDER BY postID DESC');
									for($x = 0; $x < 6; $x++){
										if ($row = $stmt->fetch()){
											echo '<div class="postLink">';
											if ($row['linkType']=="picture") {
												if (file_exists('blog/images/'.$row['postLink'])) {
													echo' <img src="blog/images/'.$row['postLink'].'"></img>';
												} else {
													echo' <img src="'.$row['postLink'].'"></img>';
												}
											} else if ($row['linkType']=="video") {
												echo $row['postLink'];
											}
											
												echo  '<a class = "viewPost" href="blog.php?viewPost='.$row['postID'].'"><p>View Post</p></a>
											</div>';
										}
									}// end for

								} catch(PDOException $e) {
									echo $e->getMessage();
								}
							?>
						</div>
					</div>
					<div id="blogCategory">
						<h4> Categories:</h4>
						<?php 
						try {
							$stmt = $db->query('SELECT tagName, numPosts FROM blog_tags ORDER BY tagName');
							if ($row = $stmt->fetch()) {
								echo '<a class="tags" href="blog.php?tag='.$row['tagName'].'">'.$row['tagName'].'</a>';	
							}
							
							while($row = $stmt->fetch()){
								echo '<a>, </a><a class="tags" href="blog.php?tag='.$row['tagName'].'">'.$row['tagName'].'</a>';		
							}
						} catch(PDOException $e) {
									echo $e->getMessage();
						}?>
					</div>
				</div>
				
				<div id="Project" class="section">
					<div  class="container">
						<h1 id="projectUpdates"><a href="portfolio.php">Portfolio and Project Archive</a></h1>
						<?php
							try {
								if (isset($_SESSION['viewall']) && $_SESSION['viewall'] ) {
									$stmt = $db->query('SELECT projectID, projectName, projectDesc, startDate, lastUpdated, projectLinks, tags, completed, private FROM projects ORDER BY projectID DESC');
								} else {
									$stmt = $db->query('SELECT projectID, projectName, projectDesc, startDate, lastUpdated, projectLinks, tags, completed, private FROM projects WHERE private != 1 ORDER BY projectID DESC');
								}
								
								for ($x = 0; $x < 3; $x++) {
									if ($row = $stmt->fetch()){
										echo' <div class="projectPost" id="project'.$row['projectID'].'">
											<h1 class="projTitle">'.$row['projectName'].'</h1>';
											
											if (file_exists('portfolio/images/'.$row['projectLinks']) || file_exists('images/'.$row['projectLinks'])) {
												echo' <img class = "projPic" src="blog/images/'.$row['projectLinks'].'"></img>';
											} else {
												echo' <img class = "projPic" src="'.$row['projectLinks'].'"></img>';
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
											
											echo' <a class="viewUpdates" href="portfolio.php?project='.$row['projectID'].'">
												<div class="hoverText">
													<p>'.$row['projectName'].'</p>
													<p> Click to read more</p>
												</div>
											</a>
										</div>'; 		
									}
								}// end while
								
								echo '<div id="recentProj">
									<h1 class="projTitle">Recent Project Updates</h1> ';
								if (isset($_SESSION['viewall']) && $_SESSION['viewall'] ) {
									$stmt2 = $db->query('SELECT updateID, projectID, projectName, updateTitle, postDate, private FROM project_updates ORDER BY postDate DESC');
								} else {
									$stmt2 = $db->query('SELECT updateID, projectID, projectName, updateTitle, postDate, private FROM project_updates WHERE private != 1 ORDER BY postDate DESC');
								}
								
								for ($x = 0; $x < 5; $x++) {
									if ($row = $stmt2->fetch()) {
										echo '
											<a class="recentUpdate" id="proj'.$row['projectID'].'" href="portfolio.php?project='.$row['projectID'].'">
												<h1>'.$row['updateTitle'].'</h1>
												<p><span>Project: </span>'.$row['projectName'].'</p>
												<p class ="postDate">Posted on '.date('M jS Y', strtotime($row['postDate'])).'</p>
											</a>
										';
									}
								}
				
								echo '</div>';
							} catch(PDOException $e) {
									echo $e->getMessage();
							}?>
					</div>
					<div id="projCategory">
						<h4> Categories:</h4>
						<?php 
						try {
							$stmt = $db->query('SELECT tagName, numPosts FROM project_tags ORDER BY tagName');
							if ($row = $stmt->fetch()) {
								echo '<a class="tags" href="portfolio.php?tag='.$row['tagName'].'">'.$row['tagName'].'</a>';	
							}
							
							while($row = $stmt->fetch()){
								echo '<a>, </a><a class="tags" href="portfolio.php?tag='.$row['tagName'].'">'.$row['tagName'].'</a>';		
							}
						} catch(PDOException $e) {
									echo $e->getMessage();
						}?>
						
					</div>
				</div>
				
			</div>
		</div>
		
		<footer>
			<div id="FooterBody" class="container">
				<?php include 'include/footer.php'?>
			</div>
		</footer>
		<script>optimizeYouTubeEmbeds()</script>
	</body>
</html>