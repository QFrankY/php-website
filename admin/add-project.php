<?php //include config
require_once('include/'.$_SERVER['CONFIG_FILE']);

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Obsessive Impulsive - Admin Panel">
	<title>Admin - Add Project</title>
	<link rel="stylesheet" type="text/css" href="include/css/admin.css">
</head>
<body>
<div class="container">

	<?php include('menu.php');?>

	<h2>Add Project</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($projectName ==''){
			$error[] = 'Please enter the title.';
		}

		if($projectDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($projectLinks ==''){
			$error[] = 'Please enter the content.';
		}
		
		if($tags ==''){
			$error[] = 'Please enter the content.';
		}
		
		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO projects (projectName, projectDesc, startDate, projectLinks, tags, completed, private) 
					VALUES (:projectName, :projectDesc, :startDate, :projectLinks, :tags, :completed, :private)') ;
				$stmt->execute(array(
					':projectName' => $projectName,
					':projectDesc' => $projectDesc,
					':projectLinks' => $projectLinks,
					':startDate' => date('Y-m-d H:i:s'),
					':tags' => $tags,
					':completed' => $completed,
					':private' => $private,
				));

				//redirect to index page
				header('Location: index.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Project Name</label><br />
		<input type='text' name='projectName' value='<?php if(isset($error)){ echo $_POST['projectName'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='projectDesc' cols='80' rows='8'><?php if(isset($error)){ echo $_POST['projectDesc'];}?></textarea></p>

		<p><label>Project Links</label><br />
		<input type='text' name='projectLinks' value='<?php if(isset($error)){ echo $_POST['projectLinks'];}?>'></p>
		
		<p><label>Tags</label><br />
		<input type='text' name='tags' value='<?php if(isset($error)){ echo $_POST['tags'];}?>'></p>
		
		<p><label>Private</label>
		<select name="private">
			<option value="0"> No </option>
			<option value="1"> Yes </option>
		</select></p>
		
		<p><label>Completed</label>
		<select name="completed">
			<option value="0"> No </option>
			<option value="1"> Yes </option>
		</select></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
