#!/usr/local/bin/php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Interactive Fiction</title>
    <link href="http://schoolwebserver.edu/idef/V22.0061.001.FA10/asg8_Susana_Delgadillo.css" rel="stylesheet" type="text/css"> 
</head>

 
<body>
<div id="content">
<?php
	/* 	GLOBAL VARIABLES */	
	# Narrative components vars
	$lastName = $_POST['lastName'];
	$adj1 = $_POST['adj1'];
	$adj2 = $_POST['adj2'];
	$bodyPart = $_POST['bodyPart'];
	$time = $_POST['time']; /* still need to implement this */
	$continent = $_POST['continent'];
	$dialogue = $_POST['dialogue'];
	
	
	/* NARRATIVE OUTPUT */
	echo "A Voyage to Arcturus by David Lindsay\n";
	
	echo "\t<p>
	On a march evening, at eight o'clock, $lastName, the medium--a fast-rising star in the psychic world--was ushered 
	into the study at Prolands, the Hampstead residence of Montague Faull. The room was illuminated only by the light of a 
	blazing fire. The host, eying him with indolent curiosity, got up, and the usual conventional greetings were exchanged. 
	Having indicated an easy chair before the fire to his guest, the $continent merchant sank back again into his own. 
	The electric light was switched on. Faull's prominent, clear-cut features, metallic-looking $bodyPart, and general air of 
	bored impassiveness, did not seem greatly to impress the medium, who was accustomed to regard men from a special angle. 
	$lastName, on the contrary, was a novelty to the merchant. As he tranquilly studied him through half closed lids and 
	the smoke of a cigar, he wondered how this $adj1, $adj2 person with the pointed beard contrived to remain so fresh 
	and sane in appearance, in view of the morbid nature of his occupation.
	</p>\n\n";

	echo "\t<p>
	\"Do you smoke?\" drawled Faull, by way of starting the Conversation. \"No? Then will you take a drink?\" 
	</p>\n\n";

	echo "\t<p>
	\"$dialogue.\"
	</p>\n\n";

	echo "\t<p>
	A pause.
	</p>\n\n";

	echo "\t<p>
	\"Everything is satisfactory? The materialisation will take place?\"
	</p>\n\n";

	echo "\t<p>
	\"I see no reason to doubt it.\"
	</p>\n\n";

	echo "\t<p>
	\"That's good, for I would not like my guests to be disappointed. I have your check written out in my pocket.\"
	</p>\n\n";

	echo "\t<p>
	\"Afterward will do quite well.\"
	</p>\n\n";

	echo "\t<p>
	\"Nine o'clock was the time specified, I believe?\"
	</p>\n\n";

	echo "\t<p>
	\"I fancy so.\"
	</p>\n\n";

?>
</div>
</body> 
</html>