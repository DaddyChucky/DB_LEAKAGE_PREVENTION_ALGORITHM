<?php

	include 'functions.php';

	testInput(); //INITIATING FUNCTION

	function decryptString($key, $database)
	{
		//SEARCH IF KEY EXISTS WITHIN DATABASE

		$req = $database->prepare('SELECT XXXXX FROM XXXXX WHERE XXXXX=:XXXXX');

		$req->execute(array(
			'XXXXX' => $key
		));
		
		while ($result = $req->fetch())
		{
			if ($result)
			{
				break;
			}
		}

		if (!$result['XXXXX'])
		{
			//THROWS FATAL ERROR AND GIVES AN IP TIMEOUT OF 10 MINS
			$req = $database->prepare('INSERT INTO XXXXX(XXXXX, XXXXX) VALUES(:XXXXX, :XXXXX)');

			$req->execute(array(
				'XXXXX' => $_SESSION['userIPAddr'],
				'XXXXX' => time() + 600 //DEBUG: Use only 1 sec of timeout
			));

			$_SESSION['fatalError'] = 'Invalid key entered. Your access to this site is disabled for ten (10) minutes.';
			echo "<script type='text/javascript'> document.location = 'error'; </script>";
		}

		else if ($result['XXXXX'])
		{
			//IF KEY EXISTS, CONTINUE
			$req = $database->prepare('SELECT XXXXX, XXXXX, XXXXX FROM XXXXX WHERE XXXXX=:XXXXX ORDER BY XXXXX ASC');

			$req->execute(array(
				'XXXXX' => $key
			));

			while ($result = $req->fetch())
			{
				$position = $result['XXXXX'];
				$char = $result['XXXXX'];

				$_SESSION['message'] .= $char[$position - 1];
			}

			$req = $database->prepare('DELETE FROM XXXXX WHERE XXXXX=:XXXXX');
			$req->execute(array(
				'XXXXX' => $key
			));

			//DELETING ALL INPUTS FROM DATABASE AFTER PRINTING SECRET MESSAGE		

		} 
	}

	if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		$secret = testInput($_POST['secret']);
		decryptString($secret, $database);
	}

	if (isset($_SESSION['message']) && $_SESSION['message'] != '') 
	{
		echo $_SESSION['message'];
		$_SESSION['message'] = '';
	}
?>
