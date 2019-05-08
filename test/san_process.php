<?php
	$name = $_POST['cName'];
	$sanitized_name=filter_var($name, FILTER_SANITIZE_EMAIL);
	if(filter_var($sanitized_name, FILTER_VALIDATE_EMAIL))
	{
		echo "original: ";
		echo $name;
		echo "valid email: ";
		echo $sanitized_name;
	}
?>