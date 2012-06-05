#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
		Video Game Data Entry
	</title>
    <link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css" /> 
</head>

 
<body>
<div id="container">
	<div id="header">
		<h2>Video Game Data Entry</h2>
	</div>
	
	<div id="nav"> 
		<a href="http://schoolwebserver.edu/idef/db/asg9/welcome.html">Home</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search.php">Search for a company</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search.php">Search for a game</a> - 
		<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry.php">Data entry for video game table</a> - 
		<a href="http://schoolwebserver.edu/idef/db/asg9/future.html">Coming Soon</a>
	</div>
	
	<div id="content">
		<form id="dataEntry" name="dataEntry" method="post" action="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry-results.php">
		<?php

			/* ======================= CONNECTING/SELECTION DB ========================= */
			$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
			mysql_select_db("idef") or die("Could not select database");
			
			
			/* ================================= OUTPUT ================================ */	
			/* ========== START ID ========== */
			echo "\t<p>
			\t<label>Game ID
			\t<input type=\"text\" name=\"ID\" value=\"\" />
			\t</label>
			\t</p>\n";
			/* =========== END ID =========== */
			
			
			/* ======== START TITLE ========= */
			echo "\t\t\t<p>
			\t<label>Title
			\t<input type=\"text\" name=\"title\" maxlength=\"40\" value=\"\" />
			\t</label>
			\t</p>\n";
			/* ========= END TITLE ========== */

			
			/* ======== START SERIES ======== */
			// querying
			$query = 
				"SELECT ID, title
				FROM series
				ORDER BY title";
			$result = mysql_query($query) or die("Query failed : " . mysql_error());
			
			// start drop-down
			echo "\t\t\t<p>
			\t<label>Series
			\t<select name=\"series\">\n";
			
			// add option for standalone games
			echo "\t\t\t\t\t<option value=\"NULL\">None/Standalone game</option>\n";
				
			// data from DB	
			while( $line = mysql_fetch_array($result, MYSQL_NUM) )
			{
				echo "\t\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
			}
			
			// end drop-down
			echo "\t\t\t\t</select>
			\t</label>
			</p>\n";
			/* ========= END SERIES ========= */
			
			/* ====== START SERIES NUM ====== */
			echo "\t\t\t<p>
			\t<label>Installment Number
			\t\t<br />(e.g. Enter 2 if the game is the 2nd installment of a trilogy. Enter 0 if the game is not part of a series.)
			\t\t<input type=\"text\" name=\"series_num\" maxlength=\"2\" value=\"0\" />
			\t</label>
			</p>\n";
			/* ======= END SERIES NUM ======= */
			
			/* ========= START DEV ========== */
			//querying
			$query = 
				"SELECT ID, name
				FROM companies
				WHERE is_developer = \"1\"
				ORDER BY name";
			$result = mysql_query($query) or die("Query failed : " . mysql_error());
			
			// start drop-down
			echo "\t\t\t<p>
			\t<label>Developer
			\t\t<select name=\"developer\">\n";
				
			// data from DB	
			while( $line = mysql_fetch_array($result, MYSQL_NUM) )
			{
				echo "\t\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
			}
			
			// end drop-down
			echo "\t\t\t\t</select>
			\t</label>
			</p>\n";
			/* ========== END DEV =========== */
			
			
			/* ========= START PUB ========== */
			//querying
			$query = 
				"SELECT ID, name
				FROM companies
				WHERE is_publisher = \"1\"
				ORDER BY name";
			$result = mysql_query($query) or die("Query failed : " . mysql_error());
			
			// start drop-down
			echo "\t\t\t<p>
			\t<label>Publisher
			\t\t<select name=\"publisher\">\n";
				
			// data from DB	
			while( $line = mysql_fetch_array($result, MYSQL_NUM) )
			{
				echo "\t\t\t\t\t<option value=\"$line[0]\">$line[1]</option>\n";
			}
			
			// end drop-down
			echo "\t\t\t\t</select>
			\t</label>
			</p>\n";
			/* =========== END PUB ========== */
			
			
			/* ====== START EXP_OR_DLC ====== */
			echo "\t\t\t<p>\n
			\t<label>Is the game an expansion or downloadable content?
			\t\t<select name=\"exp_or_dlc\">
			\t\t\t<option value=\"1\">Yes</option>
			\t\t\t<option value=\"0\">No</optiopn>
			\t\t</select>
			\t</label>
			</p>\n";
			/* ====== END EXP_OR_DLC ======== */
			
			
			/* ======= START WEBSITE ======== */
			echo "\t\t\t<p>
			\t<label>Website
			\t\t<input type=\"text\" name=\"website\" value=\"\" />
			\t</label>
			</p>\n";
			/* ======== END WEBSITE ========= */
			
			
			/* ======== START COVER ========= */
			echo "\t\t\t<p>
			\t<label>Cover Image URL
			\t\t<input type=\"text\" name=\"cover\" value=\"\" />
			\t</label>
			</p>\n";
			/* ========= END COVER ========== */
			
			
			/* ========================== CLOSING DB CONNECTION ======================== */
			mysql_free_result($result);
			mysql_close($link);
		?>
			<p>
			<input type="submit" value="Submit" name="submit"/>
			<input type="reset" value="Reset fields" />
			</p>
		</form>
	</div>
</div>
</body> 
</html>