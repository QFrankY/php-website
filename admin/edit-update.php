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

	<h2>Edit Update</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE project_updates SET updateTitle = :updateTitle, projectID = :projectID, updateCont = :updateCont, updateLink = :updateLink, updateType =:updateType WHERE updateID = :updateID') ;
				$stmt->execute(array(
					':updateID' => $updateID,
					':updateTitle' => $updateTitle,
					':projectID' => $projectID,
					':updateCont' => $updateCont,
					':updateType' => $updateType,
					':updateLink' => $updateLink
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

			$stmt = $db->prepare('SELECT updateID, projectID, projectName, updateTitle, updateCont, updateType, updateLink FROM project_updates WHERE updateID = :updateID') ;
			$stmt->execute(array(':updateID' => $_GET['id']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}


	?>

	<form action='' method='post'>
		<input type='hidden' name='updateID' value='<?php echo $row['updateID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='updateTitle' value='<?php echo $row['updateTitle'];?>'></p>

		<p><label>Project</label><br />
			<select name="projectID">
			<?php
				echo '<option value="'.$row['projectID'].'">'.$row['projectName'].'</option>';

				$stmt2 = $db->query('SELECT projectID, projectName FROM projects ORDER BY projectID DESC');
				while ($row2 = $stmt2->fetch()) {
					echo '<option value="'.$row2['projectID'].'">'.$row2['projectName'].'</option>';
				}
			?>
			</select>
		</p>

		<p><label>Content</label><br />
		<textarea class='editor' name='updateCont' cols='80' rows='15'><?php echo $row['updateCont'];?></textarea></p>

		<p><label>Link Type</label><br />
		<input type='text' name='updateType' value="<?php echo $row['updateType'];?>"></p>

		<p><label>Link</label><br />
		<input type='text' name='updateLink' value='<?php echo $row['updateLink'];?>'></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>

</body>
</html>
