#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
		Video Game Search
	</title>
    <link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css" /> 
</head>

 
<body>
<div id="container">
	<div id="header">
		<h2>Narrow Down Your Search</h2>
	</div>
	
	<div id="nav"> 
		<a href="http://schoolwebserver.edu/idef/db/asg9/welcome.html">Home</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search.php">Search for a company</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search.php">Search for a game</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry.php">Data entry for video game table</a> - 
		<a href="http://schoolwebserver.edu/idef/db/asg9/future.html">Coming Soon</a>
	</div>
	
	<div id="content">
		<p>
			Choose what you'd like to search for and how you'd like to sort the results.
		</p>
		<form id="game-search" name="game-search" method="post" action="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search-results.php">
<?php
	/* ================================= GLOBALS =============================== */
	$searchChoice = $_POST['searchChoices'];
	
	/* ======================= CONNECTING/SELECTION DB ========================= */
	$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
	mysql_select_db("idef") or die("Could not select database");
	
	
	/* ================================= OUTPUT ================================ */
	if ( $searchChoice == "title" )
	{
		echo "<p>
		<label>
			Search for a title
			<input type=\"text\" name=\"title\" value=\"\" />
		</label>
		</p>\n";	
	}
	else if ( $searchChoice == "series" ) // START SERIES
	{
		// querying
		$query = 
			"SELECT ID, title
			FROM series
			ORDER BY title";
		$result = mysql_query($query) or die("Query failed : " . mysql_error());
		
		// start drop-down
		echo "\t\t<p>
		<label>Series
			<select name=\"series\">\n";
		
		echo "\t\t\t\t<option value=\"default\">Choose one</option>\n";
			
		// data from DB	
		while( $line = mysql_fetch_array($result, MYSQL_NUM) )
		{
			echo "\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
		}
		
		// end drop-down
		echo "\t\t\t</select>
		</label>
		</p>\n";
	} // END SERIES
	
	else if ( $searchChoice == "exp_or_dlc" ) // START EXP_OR_DLC
	{
		echo "\t\t<p>
			<label>Game Type
				<select name=\"exp_or_dlc\">
					<option value=\"default\">Choose one</option>
					<option value=\"1\">Expansion or DLC</option>
					<option value=\"-1\">Standard/Full length game</optiopn>
				</select>
			</label>
		</p>\n";
	} // END EXP_OR_DLC
	
	else if ( $searchChoice == "genres" ) // START GAME_GENRES
	{
		// querying
		$query = 
			"SELECT ID, genre
			FROM genres
			ORDER BY genre";
		$result = mysql_query($query) or die("Query failed : " . mysql_error());
		
		// start drop-down
		echo "\t\t<p>
			<label>Genres
				<select name=\"game_genre\">\n";
			
		echo "\t\t\t\t<option value=\"default\">Choose one</option>\n";
		
		// data from DB	
		while( $line = mysql_fetch_array($result, MYSQL_NUM) )
		{
			echo "\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
		}
		
		// end drop-down
		echo "\t\t\t\t</select>
			</label>
		</p>\n";
	} // END GAME_GENRES
	
	else if ( $searchChoice == "modes" )// START GAME_MODES
	{
		// querying
		$query = 
			"SELECT ID, game_mode
			FROM modes
			ORDER BY game_mode";
		$result = mysql_query($query) or die("Query failed : " . mysql_error());
		
		// start drop-down
		echo "\t\t<p>
			<label>Modes
				<select name=\"game_mode\">
					<option value=\"default\">Choose one</option>\n";
			
		// data from DB	
		while( $line = mysql_fetch_array($result, MYSQL_NUM) )
		{
			echo "\t\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
		}
		
		// end drop-down
		echo "\t\t\t\t</select>
			</label>
		</p>\n";
	} // END GAME_MODES
	
	else if ( $searchChoice == "languages" ) // GAME_LANGUAGES
	{
		// querying
		$query = 
			"SELECT ID, lang
			FROM languages
			ORDER BY lang";
		$result = mysql_query($query) or die("Query failed : " . mysql_error());
		
		// start drop-down
		echo "\t\t<p>
		<label>Languages
			<select name=\"game_language\">
				<option value=\"default\">Choose one</option>\n";
			
		// data from DB	
		while( $line = mysql_fetch_array($result, MYSQL_NUM) )
		{
			echo "\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
		}
		
		// end drop-down
		echo "\t\t\t</select>
		</label>
		</p>\n";
	} // END GAME_LANGUAGES
	
	else if ( $searchChoice == "platforms" )// START PLATFORMS
	{
		// querying
		$query = 
			"SELECT ID, platform
			FROM platforms
			ORDER BY platform";
		$result = mysql_query($query) or die("Query failed : " . mysql_error());
		
		// start drop-down
		echo "\t\t<p>
		<label>Platforms
			<select name=\"game_platform\">
				<option value=\"default\">Choose one</option>\n";
			
		// data from DB	
		while( $line = mysql_fetch_array($result, MYSQL_NUM) )
		{
			echo "\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
		}
		
		// end drop-down
		echo "\t\t\t</select>
		</label>
		</p>\n";
	} // END PLATFORMS
	else
	{
		die("\t<p>ERROR: Please hit the back button in your browser and choose a field to search by.</p>");
	}
	
	
	/* ========================== CLOSING DB CONNECTION ======================== */
	if ( $result != 0 )
		mysql_free_result($result);	
	mysql_close($link);
	
	echo"\t\t<label>Sort results by
		<select name=\"sort\">
			<option value=\"video_games.title\">Title</option>
			<option value=\"dev\">Developer</optiopn>
			<option value=\"pub\">Publisher</option>
			<option value=\"video_games.exp_or_dlc\">Game Type</option>
		</select>
	</label>";
	
	echo "\t\t<p>
	\t<input type=\"submit\" value=\"Submit\" name=\"submit\"/>
	\t<input type=\"reset\" value=\"Reset fields\" />
	</p>\n";
	
?>

		</form>
	</div>
</div>
</body> 
</html>