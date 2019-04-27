<?php

	include 'functions.php';

	testInput(); //INITIATING FUNCTION

	function encryptString($difficulty, $messageToEncrypt, $database) {

		//SETS MAX STRING LENGTH
		switch ($difficulty)
		{
			case 0: //LOW
				$maxStrLength = 20;
				break;

			case 1: //MEDIUM
				$maxStrLength = 50;
				break;

			case 2: //HIGH
				$maxStrLength = 100;
				break;

			case 3: //EXTREME
				$maxStrLength = 200;
				break;

			default:
				$maxStrLength = 20;
				break;
		}

		//GENERATES ONE CUSTOM KEY FOR THE ENTIRE MESSAGE TO ENCRYPT
		function generateKey($length)
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomKey = '';

			for ($i = 0; $i < $length; $i++)
			{
				$randomKey .= $characters[rand(0, $charactersLength - 1)];
			}

			return $randomKey;
		}

		$key = generateKey($maxStrLength);

		//GENERATES FIRST STRING
		function generateStrings($position)
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$string = '';

			for ($i = 0; $i < $position - 1; $i++)
			{
				$string .= $characters[rand(0, $charactersLength - 1)];
			}

			return $string;
		}

		//ENCRYPT ONE CHAR AT A TIME
		for ($i = 0 ; $i < strlen($messageToEncrypt) ; $i++)
		{
			$char = $messageToEncrypt[$i];

			//RANDOMIZE A POSITION TO STOCK IT IN THE DATABASE
			$position = rand(1, $maxStrLength - 1);

			//RANDOMIZE FIRST STRING 
			$firstString = generateStrings($position);

			//COUNT REMAINING STRING LENGTH UNTIL DIFFICULTY MAX STR LENGTH IS REACHED
			$remainingSpaces = $maxStrLength - $position;

			//RANDOMIZE COMPLEMENTARY STRING
			$complementaryString = generateStrings($remainingSpaces + 1);

			//ADDS KEY, POS AND "HASHED" CHAR INTO DATABASE
			$req = $database->prepare('INSERT INTO XXXXX(XXXXX, XXXXX, XXXXX) VALUES(:XXXXX, :XXXXX, :XXXXX)');

			$req->execute(array(
				'XXXXX' => $key,
				'XXXXX' => $position,
				'XXXXX' => $firstString . $char . $complementaryString
			));

		}

		//SAVES KEY INTO SESSION VAR
		$_SESSION['key'] = $key;
	}

	if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		$difficulty = testInput($_POST['difficulty']);
		$message = testInput($_POST['message']);

		//CHECKS THE LENGTH OF THE MESSAGE
		if (strlen($message) >= XXXXX)
		{
			//THROWS FATAL ERROR AND GIVES AN IP TIMEOUT OF 10 MINS
			$req = $database->prepare('INSERT INTO XXXXX(XXXXX, XXXXX) VALUES(:XXXXX, :XXXXX)');

			$req->execute(array(
				'XXXXX' => $_SESSION['userIPAddr'],
				'XXXXX' => time() + 600 //DEBUG: Use only 1 sec of timeout
			));

			$_SESSION['fatalError'] = 'Message entered is too long. Your access to this site is disabled for ten (10) minutes.';
			header('Location: ../error');
		}

		else
		{
			encryptString($difficulty, $message, $database);
		}

	}

	if (isset($_SESSION['key']) && $_SESSION['key'] != '')
	{
		echo $_SESSION['key'];
		$_SESSION['key'] = '';
	}

?>

