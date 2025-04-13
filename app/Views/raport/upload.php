<?php

if (isset($_POST['submit']) && isset($_FILES['foto'])) {
	echo "<pre>";
	print_r ($_FILES['foto']);
	echo "<pre>";

	$img_name = $_FILES['foto']['name'];
	$img_size = $_FILES['foto']['size'];
	$tmp_name = $_FILES['foto']['tmp_name'];
	$error = $_FILES['foto']['error'];

	if($error === 0) {
		if($img_size > 125000) {
			$em = "Sorry, your file is too large";
		}else{
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg","png","jpeg");
		}
	}else {
		$em = "unknown error occured!";
		header ("Location: editnibro.php?error=$em");
	}
}else {
	
}

?>