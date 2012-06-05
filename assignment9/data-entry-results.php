#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
		Video Game Data Entry Results
	</title>
    <link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css" /> 
</head>

 
<body>
<div id="dataEntryTable">
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
	
	<div id="dataEntryTable">
<?php
	/* =============================== GLOBALS ================================= */
	// video_games table
	$ID         = $_POST['ID'];
	$title      = $_POST['title'];
	$series     = $_POST['series'];
	$series_num = $_POST['series_num'];
	$developer  = $_POST['developer'];
	$publisher  = $_POST['publisher'];
	$exp_or_dlc = $_POST['exp_or_dlc'];
	$website    = $_POST['website'];
	$cover      = $_POST['cover'];

	
	/* ======================= CONNECTING/SELECTION DB ========================= */
	$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
	mysql_select_db("idef") or die("Could not select database");
	
	
	/* ================================ QUERYING =============================== */	
	// If the series is NOT a standalone (aka NULL series value), add quotation marks to create a string.
	if ( $series != "NULL" )
		$series = "\"$series\"";
	// If series num is 0, then this game does not belong to a series.
	if ( $series_num == 0 )
		$series_num = "NULL";
	$query = "INSERT INTO video_games 
		VALUES( \"$ID\", \"$title\", $series, $series_num, \"$developer\", \"$publisher\", $exp_or_dlc, \"$website\", \"$cover\")";
	$result = mysql_query($query) or die("Query failed : " . mysql_error());

	$query = "SELECT *
		FROM video_games
		ORDER BY title";
	$result = mysql_query($query) or die("Query failed : " . mysql_error());
	
	/* ================================= OUTPUT ================================ */	
	echo "\t\t<table>\n
	\t<tr>
	\t\t<th>ID</th>
	\t\t<th>title</th>
	\t\t<th>series</th>
	\t\t<th>series_num</th>
	\t\t<th>developer</th>
	\t\t<th>publisher</th>
	\t\t<th>exp_or_dlc</th>
	\t\t<th>website</th>
	\t\t<th>cover</th>
	\t</tr>\n";
	while( $line = mysql_fetch_array($result, MYSQL_NUM) )
	{
		echo "\t\t<tr>\n";
		foreach ($line as $col_value)
		{
			echo "\t\t\t<td>$col_value</td>\n";
		}
		echo "\t\t</tr>\n";
	}
	echo "\t\t</table>\n";
	
	
/* ========================== CLOSING DB CONNECTION ======================== */
	mysql_free_result($result);
	mysql_close($link);
?>
	</div>
</div>
</body> 
</html>