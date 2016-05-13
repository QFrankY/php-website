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
	<title>Obsessive Impulsive - Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="include/css/admin.css">
	<script type="text/javascript" src="include/tinymce/tinymce.min.js"></script>
	<script>
          tinymce.init({
              selector: ".editor",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>
<?php include '../include/adminMenu.php'?>
<div class="container">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Edit Project</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE projects SET  projectName = :projectName, projectDesc = :projectDesc, projectLinks = :projectLinks, private = :private, completed = :completed, tags = :tags WHERE projectID = :projectID') ;
				$stmt->execute(array(
					':projectID' => $projectID,
					':projectName' => $projectName,
					':projectDesc' => $projectDesc,
					':projectLinks' => $projectLinks,
					':tags' => $tags,
					':private' => $private,
					':completed' => $completed
				));

				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT projectID, projectName, projectDesc, projectLinks, tags, completed, private FROM projects WHERE projectID = :projectID') ;
			$stmt->execute(array(':projectID' => $_GET['id']));
			$row = $stmt->fetch(); 
			
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
		

	?>

	<form action='' method='post'>
		<input type='hidden' name='projectID' value='<?php echo $row['projectID'];?>'>
		
		<p><label>Project Name</label><br />
		<input type='text' name='projectName' value='<?php echo $row['projectName']?>'></p>

		<p><label>Description</label><br />
		<textarea name='projectDesc' cols='80' rows='8'><?php echo $row['projectDesc']?></textarea></p>

		<p><label>Project Links</label><br />
		<input type='text' name='projectLinks' value='<?php echo $row['projectLinks']?>'></p>
		
		<p><label>Tags</label><br />
		<input type='text' name='tags' value='<?php echo $row['tags']?>'></p>
		
		<p><label>Private</label>
		<select name="private">
			<option value="<?php echo $row['private']?>">Default<option>
			<option value="0"> No </option>
			<option value="1"> Yes </option>
		</select></p>
		
		<p><label>Completed</label>
		<select name="completed">
			<option value="<?php echo $row['completed']?>">Default<option>
			<option value="0"> No </option>
			<option value="1"> Yes </option>
		</select></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>

</body>
</html>	
