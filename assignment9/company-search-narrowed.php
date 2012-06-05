#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Company Search
		</title>
		<link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css"> 
	</head>

	 
	<body>
		<div id="container">
			<div id="header">
				<h2>Narrow down your search</h2>
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
					Choose what you'd like to search.
				</p>
				
				<form id="company-search" name="company-search" method="post" action="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search-results.php">
					<?php
						/* ================================= GLOBALS =============================== */
						$searchChoice = $_POST['searchChoices'];
						
						
						/* ======================= CONNECTING/SELECTION DB ========================= */
						$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
						mysql_select_db("idef") or die("Could not select database");
						
						
						/* ================================= OUTPUT ================================ */	
						if ( $searchChoice == "name" ) // START COMPANY NAME 
						{							
							echo "<p>
							<label>Name:
							<input type=\"text\" name=\"name\" maxlength=\"40\" value=\"\" />
							</label>
							</p>\n\n";
						} // END COMPANY NAME
						else if ( $searchChoice == "type" ) // START COMPANY TYPE
						{
							echo "\t<p>
							<label>Type:</label>
							Developer
							<input type=\"checkbox\" name=\"types\" value=\"developer\" />
							
							Publisher
							<input type=\"checkbox\" name=\"types\" value=\"publisher\" />
							</p>\n\n";
						} // END COMPANY TYPE
						else if ( $searchChoice == "city" ) // START HQ_CITY 
						{
							// querying
							$query = 
								"SELECT DISTINCT hq_city
								FROM companies
								ORDER BY hq_city";
							$result = mysql_query($query) or die("Query failed : " . mysql_error());
							
							// start drop-down
							echo "\t<p>
							<label>Headquarters location (city):
							<select name=\"hq_city\">\n";
								
							// data from DB	
							while( $line = mysql_fetch_array($result, MYSQL_NUM) )
							{
								echo "\t\t<option value=\"$line[0]\">$line[0]</option>\n";
							}
							
							// end drop-down
							echo "\t\t</select>
							</label>
							</p>\n\n";
						} // END HQ_CITY
						else if ( $searchChoice == "country" ) // START HQ_COUNTRY
						{
							// querying
							$query = 
								"SELECT DISTINCT hq_country
								FROM companies
								ORDER BY hq_country";
							$result = mysql_query($query) or die("Query failed : " . mysql_error());
							
							// start drop-down
							echo "\t<p>
							<label>Headquarters location (country):
							<select name=\"hq_country\">\n";
								
							// data from DB	
							while( $line = mysql_fetch_array($result, MYSQL_NUM) )
							{
								echo "\t\t<option value=\"$line[0]\">$line[0]</option>\n";
							}
							
							// end drop-down
							echo "\t\t</select>
							</label>
							</p>\n\n";
						} // END HQ_COUNTRY
						else
						{
							echo "\t<p>ERROR: Please hit the back button in your browser and choose a field to search by.</p>";
						}
						
						
						/* ========================== CLOSING DB CONNECTION ======================== */
						if ( !empty($result) )
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