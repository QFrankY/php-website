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
	<title>Admin - Add Update</title>
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
<div class="container">

	<?php include('menu.php');?>

	<h2>Add Update</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO project_updates (updateTitle, projectID, updateCont, postDate, updateType, updateLink) 
					VALUES (:updateTitle, :projectID, :updateCont, :postDate, :updateType, :updateLink)') ;
				$stmt->execute(array(
					':updateTitle' => $updateTitle,
					':projectID' => $projectID,
					':updateCont' => $updateCont,
					':postDate' => date('Y-m-d H:i:s'),
					':updateType' => $updateType,
					':updateLink' => $updateLink,
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

		<p><label>Title</label><br />
		<input type='text' name='updateTitle' value='<?php if(isset($error)){ echo $_POST['updateTitle'];}?>'></p>

		<p><label>Project</label><br />
			<select name="projectID">
			<?php  
				$stmt2 = $db->query('SELECT projectID, projectName FROM projects ORDER BY projectID DESC');
				while ($row = $stmt2->fetch()) {
					echo '<option value="'.$row['projectID'].'">'.$row['projectName'].'</option>';
				}
			?>
			</select>
		</p>

		<p><label>Content</label><br />
		<textarea class='editor' name='updateCont' cols='80' rows='15'><?php if(isset($error)){ echo $_POST['updateCont'];}?></textarea></p>
		
		<p><label>Link Type</label><br />
		<input type='text' name='updateType'></p>
		
		<p><label>Link</label><br />
		<input type='text' name='updateLink'></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
