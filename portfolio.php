<?php require('include/'.$_SERVER['CONFIG_FILE']); 
	if (isset($_GET['endSession']) && $_GET['endSession'] == "true" ) {
		$_SESSION['viewall'] = false;
	}
?>

<!DOCTYPE html>
<!-- Coded and styled by Frank Yu-->
<html>
	<head>
<meta charset="utf-8">
		<meta name="description" content="Personal Portfolio of Frank Yu">
		<title>Frank Yu - Portfolio and Project Archive</title>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700,900,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="include/css/general.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="include/css/shortheader.css?<?php echo time(); ?>">
		<link rel="stylesheet" type="text/css" href="include/css/portfolio.css?<?php echo time(); ?>">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="include/js/general.js"?<?php echo time(); ?>></script>
		<script src="portfolio/resources/js/portfolio.js?<?php echo time(); ?>"></script>
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
						<h1 id="SiteTite">Portfolio and Project Archive</h1>
						<p>
							Here are the fruits of my labour and the things I am working on. If you are interested in the things I code, visit my 
							visit my Github profile. I also have a Youtube channel to showcase the things that I build. 
						</p>
						<a href="https://github.com/QFrankY" target="_blank"><img class ="logo"  src="portfolio/resources/github.png"></img>My GitHub</a>
						<a href="https://www.youtube.com/c/FrankYuCan" target="_blank"><img class ="logo" src="portfolio/resources/youtube.png"></img>My Youtube</a>
					</div>
				</div>
			</header>
			<div id="Content">
				<div class="container">
					<div id="SideBar">
						<?php include 'portfolio/sidebar.php'?>
					</div>
					<div id="MainContent">
						<?php
							if (isset($_GET['tag'])){
								$query = $_GET['tag'];
								include 'portfolio/viewProjects.php';
								
							} else if (isset($_GET['project'])){
								$projectID = $_GET['project'];
								include 'portfolio/viewUpdates.php';
								
							} else {
								include 'portfolio/viewProjects.php';
							}
							echo '<script>showProjects();</script>';
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>