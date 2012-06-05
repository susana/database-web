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
		<div id="tableContainer">	
			<div id="header">
				<h2>Company Search Results</h2>
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
				// company search criteria
				$name 		   = $_POST['name'];
				$types 		   = $_POST['types'];
				$hq_city 	   = $_POST['hq_city'];
				$hq_country    = $_POST['hq_country'];
				$whereClause   = "";
				$colCount      = 0;
				$displayQuery  = "";
				$numRows       = 0;

				
				/* ======================= CONNECTING/SELECTION DB ========================= */
				$link = mysql_connect("", 'idef', 'idef') or die("Could not connect : " . mysql_error());
				mysql_select_db("idef") or die("Could not select database");
				
				
				/* =============================== QUERYING ================================ */
				// $criteria = array();
				// COMPANY NAME
				if ( !empty( $name ) ) // COMPANY NAME
				{
					if ( strlen( $name ) < 3 )
						echo "Please enter 3 or more characters.";
					else
						$whereClause = "companies.name REGEXP \"$name\"";
				}
				else if ( count( $types ) != 0 ) // COMPANY TYPE OR TYPES
				{
					$dev = false;
					$pub = false;
					foreach ( $types as $type )
					{
						if ( $type == "developer" )
							$dev = true;
						if ( $type == "publisher" )
							$pub = true;
					}
					if ( $dev == true && $pub == false )
						$whereClause = "is_developer = 1 AND is_publisher = 0";
					else if ( $dev == false && $pub == true )
						$whereClause = "is_developer = 0 AND is_publisher = 1";
					else if ( $dev == true && $pub == true )
						$whereClause = "is_developer = 1 AND is_publisher = 1";
				}
				else if ( !empty( $hq_city ) ) // COMPANY CITY
				{
					$whereClause = "hq_city = \"$hq_city\"";
				}
				else if ( !empty( $hq_country ) ) // COMPANY COUNTRY
				{
					$whereClause = "hq_country = \"$hq_country\"";
				}
				else
				{
					die( "Please click the back button in your browser and make a selection.\n" );
				}
				
				// QUERY
				$query = "SELECT companies.name, CONCAT(companies.is_developer, \",\", companies.is_publisher) AS type,
					companies.year_founded, CONCAT(companies.hq_city, \", \", companies.hq_country),
					companies.employee_count, companies.website
					FROM companies
					WHERE $whereClause";
				$result = mysql_query($query) or die("Query failed : " . mysql_error());
				$numRows = mysql_num_rows($result);
				
				$displayedQuery = "SELECT companies.name, CONCAT(companies.is_developer, \",\", companies.is_publisher) AS type, companies.year_founded, CONCAT(companies.hq_city, \", \", companies.hq_country), companies.employee_count, companies.website <br />
				\t\tFROM companies <br />
				\t\tWHERE $whereClause";	
				
				
				/* ================================= OUTPUT ================================ */
				echo "\t<div id=\"query\">
					<p>
						<h3>Your query:</h3><br />
						$displayedQuery
					</p>		
				</div>
					
				<div id=\"results\">
					<p>
						$numRows records match your query.
					</p>
				</div>\n\n";
				
				echo "\t\t\t\t<table>
				<tr>
				\t<th>Company Name</th>
				\t<th>Company Type(s)</th>
				\t<th>Year founded</th>
				\t<th>Headquarters Location</th>
				\t<th>Number of Employees</th>
				\t<th>Website</th>
				</tr>\n";
				while( $line = mysql_fetch_array($result, MYSQL_NUM) )
				{
					echo "\t\t\t\t\t<tr>\n";
					foreach ($line as $col_value)
					{
						if ( $colCount == 1 )
						{
							if ( $col_value == "1,0" )
								echo "\t\t\t\t\t\t<td>Developer</td>\n";
							else if ( $col_value == "0,1" )
								echo "\t\t\t\t\t\t<td>Publisher</td>\n";
							else if ( $col_value == "1,1" )
								echo "\t\t\t\t\t\t<td>Developer, Publisher</td>\n";
							else
								echo "\t\t\t\t\t\t<td></td>\n";
						}
						else if ( substr( $col_value, 0, 4 ) == "http" ) 
							echo "\t\t\t\t\t\t<td><a href=\"$col_value\">$col_value</a></td>\n";
						else
							echo "\t\t\t\t\t\t<td>$col_value</td>\n";
						$colCount++;
					}
					echo "\t\t\t\t\t</tr>\n";
					$colCount = 0;
				}
				echo "\t\t\t\t</table>\n";
				
				
				/* ========================== CLOSING DB CONNECTION ======================== */
				if ( !empty($result) )
					mysql_free_result($result);
				mysql_close($link);
			?>
			</div>
		</div>
	</body> 
</html>