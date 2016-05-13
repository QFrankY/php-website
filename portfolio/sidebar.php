<?php

	echo' <div id="viewPrivate">
		<h2>Enter code to view private projects: </h2>
		<form action="" method=POST>
			<input type="text" name="passcode" size="10" value="">
			<input type="submit" name="submit" value="Submit">
		</form>';

		if(isset($_POST['submit'])) {
			if ($_POST['passcode'] == $_SERVER['PASSCODE']) {
				$_SESSION['viewall'] = true;
				echo '<script>accessGranted();</script>';
			} else if ($_POST['passcode'] != "") {
				echo '<script>wrongPassword();</script>';
			}
		}

		if (isset($_SESSION['viewall']) && $_SESSION['viewall']) {
			echo '<script>accessGranted();</script>';
		}

	echo '</div>';

	try {
		echo '<h1>Categories: </h1>';

		$stmt = $db->query('SELECT tagName, numPosts, numPublicPosts FROM project_tags ORDER BY tagName');
		while($row = $stmt->fetch()){
			echo '<p class="tags">'.$row['tagName'].' [ ';

			if (isset($_SESSION['viewall']) && $_SESSION['viewall']) {
				echo $row['numPosts'];
			} else {
				echo $row['numPublicPosts'];
			}

			echo ' ]</p>';
		}

		echo '<p id="viewall">View all posts</p>';

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>