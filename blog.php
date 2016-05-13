<?php require('include/'.$_SERVER['CONFIG_FILE']); ?>
<!DOCTYPE html>
<!-- Coded and styled by Frank Yu-->
<html>
	<head>
<meta charset="utf-8">
		<meta name="description" content="Personal Portfolio of Frank Yu">
		<title>Obsessive Impulsive - A Space for Thoughts</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700,900,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="include/css/general.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="include/css/shortheader.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="include/css/blog.css?<?php echo time(); ?>">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="include/js/general.js?<?php echo time(); ?>"></script>
		<script src="blog/resources/js/blog.js?<?php echo time(); ?>"></script>

		<!--I did not write the following script. Source: http://www.skipser.com/test/googlecode/gplus-youtubeembed/test.html-->
		<script src="include/js/videoload.js?<?php echo time(); ?>"></script>
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
						<h1 id="SiteTite">A Space for Thoughts</h1>
						<h2 id="ByLine">Welcome to my blog. I don't post often.</h2>
						<p>
							I made this blog as a more of a coding exercise. I will try to update it as often as I can.
						</p>
					</div>
					<div id="ProfilePic">
						<img src="include/css/resources/profile.jpg" alt="Profile Picture">
					</div>
				</div>
			</header>
			<div id="Content">
				<div class="container">
					<div id="MainContent">
						<?php
							if(isset($_GET['tag'])){
								$tag = $_GET['tag'].",";
							} else if (isset($_GET['viewPost'])) {
								$postID = $_GET['viewPost'];
							}
							include 'blog/blogQuery.php';
						?>
					</div>

					<div id="SideBar">
						<?php include 'blog/blogSideBar.php'?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>