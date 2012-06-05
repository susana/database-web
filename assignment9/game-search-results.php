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
<div id="tableContainer">
	<div id="header">
		<h2>Game Search Results</h2>
	</div>
	
	<div id="nav"> 
		<a href="http://schoolwebserver.edu/idef/db/asg9/welcome.html">Home</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search.php">Search for a company</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search.php">Search for a game</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry.php">Data entry for video game table</a> - 
		<a href="http://schoolwebserver.edu/idef/db/asg9/future.html">Coming Soon</a>
	</div>
	
	<div id="tableContent">
<?php
	/* =========================== SUPER GLOBALS =============================== */
	$title          = $_POST['title'];
	$series         = $_POST['series'];
	$exp_or_dlc     = $_POST['exp_or_dlc'];
	$game_genre     = $_POST['game_genre'];
	$game_mode      = $_POST['game_mode'];
	$game_language  = $_POST['game_language'];
	$game_platform  = $_POST['game_platform'];
	$sort           = $_POST['sort'];
	$colCount       = 0;
	$displayedQuery = "";
	$numRows        = 0;

	
	/* ======================= CONNECTING/SELECTION DB ========================= */
	$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
	mysql_select_db("idef") or die("Could not select database");
	
	
	/* =============================== QUERYING ================================ */
	if ( empty($sort) )
		$sort = "video_games.title";
	if ( !empty( $title ) ) // TITLE
	{
		if( strlen($title) < 3 )
			die( "Please enter 3 or more characters." );
		else
		{
			$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
			FROM video_games
			LEFT JOIN series ON video_games.series = series.ID
			INNER JOIN companies AS d ON video_games.developer = d.ID
			INNER JOIN companies AS p ON video_games.publisher = p.ID
			WHERE video_games.title REGEXP \"$title\"
			ORDER BY $sort";
			
			$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website <br />
			\tFROM video_games
			\tLEFT JOIN series ON video_games.series = series.ID <br />
			\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
			\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
			\tWHERE video_games.title REGEXP \"$title\" <br />
			\tORDER BY $sort";
		}
	}
	else if ( !empty( $series ) && ( $series != "default" ) ) // SERIES
	{
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		INNER JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		WHERE series.ID = \"$series\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website <br />
		\tFROM video_games
		\tINNER JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tWHERE series.ID = \"$series\" <br />
		\tORDER BY $sort";
	}
	else if ( !empty( $exp_or_dlc ) && $exp_or_dlc != "default" ) // EXP_OR_DLC
	{
		if ( $exp_or_dlc == "-1" )
			$exp_or_dlc = "0";
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		LEFT JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		WHERE video_games.exp_or_dlc = \"$exp_or_dlc\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		\tFROM video_games <br />
		\tLEFT JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tWHERE video_games.exp_or_dlc = \"$exp_or_dlc\" <br />
		\tORDER BY $sort";
	}
	else if ( !empty( $game_genre ) && ( $game_genre != "default" ) ) // GAME_GENRES
	{
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		LEFT JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		INNER JOIN game_genres ON video_games.ID = game_genres.game
		WHERE game_genres.genre = \"$game_genre\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		\tFROM video_games <br />
		\tLEFT JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tINNER JOIN game_genres ON video_games.ID = game_genres.game <br />
		\tWHERE game_genres.genre = \"$game_genre\" <br />
		\tORDER BY $sort";
	}
	else if ( !empty( $game_mode ) && ( $game_mode != "default" ) ) // GAME_MODES
	{			
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		LEFT JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		INNER JOIN game_modes ON video_games.ID = game_modes.game
		WHERE game_modes.game_mode = \"$game_mode\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		\tFROM video_games <br />
		\tLEFT JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tINNER JOIN game_modes ON video_games.ID = game_modes.game <br />
		\tWHERE game_modes.game_mode = \"$game_mode\" <br />
		\tORDER BY $sort";
	}
	else if ( !empty( $game_language ) && ( $game_language != "default" ) ) // GAME_LANGUAGES
	{
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		LEFT JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		INNER JOIN game_languages ON video_games.ID = game_languages.game
		WHERE game_languages.lang = \"$game_language\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		\tFROM video_games <br />
		\tLEFT JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tINNER JOIN game_languages ON video_games.ID = game_languages.game <br />
		\tWHERE game_languages.lang = \"$game_language\" <br />
		\tORDER BY $sort";
	}
	else if ( !empty( $game_platform ) && ( $game_platform != "default" ) ) // GAME_PLATFORMS
	{	
		$query = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		FROM video_games
		LEFT JOIN series ON video_games.series = series.ID
		INNER JOIN companies AS d ON video_games.developer = d.ID
		INNER JOIN companies AS p ON video_games.publisher = p.ID
		INNER JOIN game_platforms ON video_games.ID = game_platforms.game
		INNER JOIN platforms ON game_platforms.platform = platforms.ID
		WHERE game_platforms.platform = \"$game_platform\"
		ORDER BY $sort";
		
		$displayedQuery = "SELECT video_games.ID, video_games.title, video_games.cover, CONCAT(series.title, \" (\", video_games.series_num, \" of \", series.volume, \")\") AS series_info, d.name AS dev, p.name AS pub, video_games.exp_or_dlc, video_games.website
		\tFROM video_games <br />
		\tLEFT JOIN series ON video_games.series = series.ID <br />
		\tINNER JOIN companies AS d ON video_games.developer = d.ID <br />
		\tINNER JOIN companies AS p ON video_games.publisher = p.ID <br />
		\tINNER JOIN game_platforms ON video_games.ID = game_platforms.game <br />
		\tINNER JOIN platforms ON game_platforms.platform = platforms.ID <br />
		\tWHERE game_platforms.platform = \"$game_platform\" <br />
		\tORDER BY $sort";
	}
	else
	{
		echo "Please click the back button in your browser and make a selection.\n";
	}
	
	$result  = mysql_query($query) or die("Query failed : " . mysql_error());
	$numRows = mysql_num_rows($result);
	
	/* ================================= OUTPUT ================================ */	
	echo "\t\t<div id=\"query\">
	\t\t<p>
	\t\t<h3>Your query:</h3><br />
	\t\t$displayedQuery
	\t\t</p>		
	\t</div>
		
	\t<div id=\"results\">
	\t\t<p>
	\t\t$numRows records match your query.
	\t\t</p>
	\t</div>\n\n";
	
	echo "\t\t<table>
	\t<tr>
	\t\t<th>Title</th>	
	\t\t<th>Cover</th>
	\t\t<th>Series Info</th>
	\t\t<th>Developer</th>
	\t\t<th>Publisher</th>
	\t\t<th>Game Type</th>
	\t\t<th>Website</th>
	\t\t<th>Genres</th>
	\t\t<th>Modes</th>
	\t\t<th>Languages</th>
	\t\t<th>Platforms</th>
	\t</tr>\n";
	while( $line = mysql_fetch_array($result, MYSQL_NUM) )
	{
		echo "\t\t<tr>\n";
		foreach ($line as $col_value)
		{	
			if ( $colCount == 0 ) // ID
				;
			else if ( $colCount == 6 ) // exp or dlc?
			{
				if ( $col_value == 0 )
					echo "\t\t\t<td>Sequel/ Standalone</td>\n";
				else
					echo "\t\t\t<td>Expansion/DLC</td>\n";
			}
			else if ( substr( $col_value, -4, strlen($col_value) ) == ".jpg" ) // cover
				echo "\t\t\t<td><img src=\"$col_value\" width=\"110\" height=\"150\" /></td>\n";
			else if ( substr( $col_value, 0, 4 ) == "http" ) // website
				echo "\t\t\t<td><a href=\"$col_value\">Official Site</a></td>\n";
			else
				echo "\t\t\t<td>$col_value</td>\n";
			$colCount++;
		}
		/* ============================== genres ================================ */
		$query2 = "SELECT genres.genre
		FROM game_genres
		INNER JOIN genres ON game_genres.genre = genres.ID				
		WHERE game_genres.game = \"$line[0]\"";
		$result2 = mysql_query($query2) or die("Query failed : " . mysql_error());
		echo "\t\t\t<td>\n";
		while( $line2 = mysql_fetch_array($result2, MYSQL_NUM) )
		{
			echo "\t\t\t\t<ul type=\"square\">\n";
			echo "\t\t\t\t<li>$line2[0] <br />\n";
			echo "\t\t\t\t</ul>\n";
		}
		echo "\t\t\t</td>\n";
		
		/* ============================== modes ================================ */
		$query3 = "SELECT modes.game_mode
		FROM game_modes
		INNER JOIN modes ON game_modes.game_mode = modes.ID
		WHERE game_modes.game = \"$line[0]\"";
		$result3 = mysql_query($query3) or die("Query failed : " . mysql_error());
		echo "\t\t\t<td>\n";
		while( $line3 = mysql_fetch_array($result3, MYSQL_NUM) )
		{
			echo "\t\t\t\t<ul type=\"square\">\n";
			echo "\t\t\t\t<li>$line3[0] <br />\n";
			echo "\t\t\t\t</ul>\n";
		}
		echo "\t\t\t</td>\n";
		
		/* ============================= languages ============================== */
		$query4 = "SELECT languages.lang
		FROM game_languages
		INNER JOIN languages ON game_languages.lang = languages.ID				
		WHERE game_languages.game = \"$line[0]\"";
		$result4 = mysql_query($query4) or die("Query failed : " . mysql_error());
		echo "\t\t\t<td>\n";
		while( $line4 = mysql_fetch_array($result4, MYSQL_NUM) )
		{
			echo "\t\t\t\t<ul type=\"square\">\n";
			echo "\t\t\t\t<li>$line4[0] <br />\n";
			echo "\t\t\t\t</ul>\n";
		}
		echo "\t\t\t</td>\n";
				
		/* ============================= platforms ============================== */
		$query5 = "SELECT CONCAT(platforms.platform, \"(\", game_platforms.month_released, \" \", game_platforms.year_released, \")\") AS platform_info
		FROM game_platforms
		INNER JOIN platforms ON game_platforms.platform = platforms.ID				
		WHERE game_platforms.game = \"$line[0]\"";
		$result5 = mysql_query($query5) or die("Query failed : " . mysql_error());
		echo "\t\t\t<td>\n";
		while( $line5 = mysql_fetch_array($result5, MYSQL_NUM) )
		{
			echo "\t\t\t\t<ul type=\"square\">\n";
			echo "\t\t\t\t<li>$line5[0] <br />\n";
			echo "\t\t\t\t</ul>\n";
		}
		echo "\t\t\t</td>\n";
		
		
		echo "\t\t</tr>\n";
		$colCount = 0;
	}
	echo "\t\t</table>\n";
	
	
	/* ========================== CLOSING DB CONNECTION ======================== */
	mysql_free_result($result);
	if ( !empty($result2) )
		mysql_free_result($result2);
	if ( !empty($result3) )
		mysql_free_result($result3);
	if ( !empty($result4) )
		mysql_free_result($result4);
	if ( !empty($result5) )
		mysql_free_result($result5);
	mysql_close($link);
	
	
	
?>
	</div>
</div>
</body> 
</html>