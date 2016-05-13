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
	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	<script>
          tinymce.init({
              selector: "textarea",
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

	<h2>Edit Post</h2>


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
				$stmt = $db->prepare('UPDATE blog_posts SET postTitle = :postTitle, postDesc = :postDesc, postCont = :postCont, linkType = :linkType, postLink = :postLink, tags = :tags WHERE postID = :postID') ;
				$stmt->execute(array(
					':postID' => $postID,
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':linkType' => $linkType,
					':postLink' => $postLink,
					':tags' => $tags
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

			$stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont, postLink, linkType, tags FROM blog_posts WHERE postID = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='postID' value='<?php echo $row['postID'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php echo $row['postTitle'];?>'></p>

		<p><label>Description</label><br />
		<input name='postDesc' cols='60' rows='10' value='<?php echo $row['postDesc'];?>'></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont'];?></textarea></p>
		
		<p><label>Link Type</label><br />
		<select name="linkType">
			<option value ="<?php echo $row['linkType'];?>">Default</option>
			<option value = "picture">picture</option>
			<option value = "video">video</option>
		</select></p>
		
		<p><label>Link</label><br />
		<input type='text' name='postLink' value='<?php echo $row['postLink'];?>'></p>
		
		<p><label>Tags</label><br />
		<input type='text' name='tags' value='<?php echo $row['tags'];?>'></p>
		
		<p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
</html>	
