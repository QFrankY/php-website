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
	<title>Admin - Add Post</title>
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

	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle, postDesc, postCont, postDate, linkType, postLink, tags) 
					VALUES (:postTitle, :postDesc, :postCont, :postDate, :linkType, :postLink, :tags)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s'),
					':linkType' => $linkType,
					':postLink' => $postLink,
					':tags' => $tags
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
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='80' rows='8'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea class='editor' name='postCont' cols='80' rows='15'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		
		<p><label>Link Type</label><br />
		<select name="linkType">
			<option></option>
			<option value = "picture">picture</option>
			<option value = "video">video</option>
		</select></p>
		
		<p><label>Link</label><br />
		<input type='text' name='postLink'></p>
		
		<p><label>Tags</label><br />
		<input type='text' name='tags'></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
