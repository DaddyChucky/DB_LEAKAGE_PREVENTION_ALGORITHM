<?php
	
	//SQL INJECTION FUNCTION
	function testInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

?>